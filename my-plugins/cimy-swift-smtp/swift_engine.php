<?php

#OVERRIDE WP_MAIL FUNCTION!!!!
if ( !function_exists('bb_mail') ) {
function bb_mail($to, $subject, $content, $headers='') {
	global $st_smtp_config;

	$phpv = phpversion();
	
	if (version_compare($phpv, "5.0.0", "<")) {
		$is_php4 = true;
		$is_php5 = false;
	}
	else {
		$is_php4 = false;
		$is_php5 = true;
	}

	// PHP4
	if ($is_php4) {
		require_once('Swift/php4/lib/Swift.php');
		require_once('Swift/php4/lib/Swift/Connection/SMTP.php');
	}
	// PHP5
	else if ($is_php5) {
		require_once('Swift/php5/lib/Swift.php');
		require_once('Swift/php5/lib/Swift/Connection/SMTP.php');
	}

/* CONNECT TO SMTP */
	// default port if none inserted
	if ($st_smtp_config['port'] == "")
		$st_smtp_config['port'] = 25;

	// default server if none inserted
	if ($st_smtp_config['server'] == "")
		$st_smtp_config['server'] = "localhost";
	
	// standard SSL connection
	if ($st_smtp_config['port'] == 465 && $st_smtp_config['ssl'] == 'ssl') {
		// PHP4
		if ($is_php4) {
			$smtp =& new Swift_Connection_SMTP($st_smtp_config['server'], SWIFT_SMTP_PORT_SECURE, SWIFT_SMTP_ENC_SSL);
		}
		// PHP5
		else if ($is_php5) {
			require("php5_ssl_connection.php");
		}
	// standard TLS connection
	} else if ($st_smtp_config['port'] == 465 && $st_smtp_config['ssl'] == 'tls') {
		// PHP4
		if ($is_php4) {
			$smtp =& new Swift_Connection_SMTP($st_smtp_config['server'], SWIFT_SMTP_PORT_SECURE, SWIFT_SMTP_ENC_TLS);
		}
		// PHP5
		else if ($is_php5) {
			require("php5_tls_connection.php");
		}
	// SSL or TLS on a non-standard port (arbitrary)*/
	} else {
		$smtp =& new Swift_Connection_SMTP($st_smtp_config['server'], $st_smtp_config['port'], $st_smtp_config['ssl']);
	}
/* AUTHENTICATE SMTP */
	if (($st_smtp_config['username'] != "") && ($st_smtp_config['password'] != "")) {
		$smtp->setUsername($st_smtp_config['username']);
		$smtp->setPassword($st_smtp_config['password']);
	}
	 
	$swift =& new Swift($smtp);

/* CHECK HEADERS */
		$attached = strpos($content, 'Content-Disposition: attachment;');
		$has_bcc = false;
		$html = strpos($headers, 'text/html');

/* CREATE MESSAGE */	
	if ($html === false) {
		$message =& new Swift_Message($subject, $content);
	} else {
		$message =& new Swift_Message($subject, $content, "text/html");
	}
	
/* SET DESTINATION RECIPIENT */
	$recipient_list =& new Swift_RecipientList();
	$recipient_list->addTo($to);

/* SET FROM ADDRESS */

	// Headers
	if ((!is_array($headers)) && (!empty($headers))) {
		// Explode the headers out, so this function can take both
		// string headers and an array of headers.
		$tempheaders = (array) explode("\n", $headers);

		// If it's actually got contents
		if (!empty($tempheaders)) {
			// Iterate through the raw headers
			foreach ($tempheaders as $header) {
				// no ":" can be a blank line or a list of bcc emails, discovering...
				if (strpos($header, ':') === false ) {
					// wasn't turned on bcc flag, so cannot be bcc emails list
					if (!$has_bcc)
						continue;
					// flag is on so can be possible, but still can be last blank line
					else {
						// yes it is a bcc email!
						if (!(strpos($header, "@") === false)) {
							$has_bcc = true;
							$name = "";
							$content = $header;
						}
						// nothing interesting, changing back the flag
						else {
							$has_bcc = false;
							continue;
						}
					}
				}
				// it's a new header tag, setting bcc to false in any case
				else {
					// Explode them out
					list($name, $content) = explode(':', trim($header), 2);
					$has_bcc = false;
				}

				// Cleanup crew
				$name = trim($name);
				$content = trim($content);

				// Mainly for legacy -- process a From: header if it's there
				if ('from' == strtolower($name)) {
					if ( strpos($content, '<' ) !== false ) {
						// So... making my life hard again?
						$from_name = substr( $content, 0, strpos( $content, '<' ) - 1 );
						$from_name = str_replace( '"', '', $from_name );
						$from_name = trim( $from_name );

						$from_email = substr( $content, strpos( $content, '<' ) + 1 );
						$from_email = str_replace( '>', '', $from_email );
						$from_email = trim( $from_email );
					} else {
						$from_name = trim( $content );
					}
				}
				// bcc: line or continue with a new email for every new line
				else if (('bcc' == strtolower($name)) || ($has_bcc)) {
					// in any case to be sure
					$has_bcc = true;
					
					// emails can be all in one line or in multiple lines, so check it out
					$bcc_emails = explode(',', $content);
					
					foreach ($bcc_emails as $bcc_email) {
						// it's an email!
						if (!(strpos($bcc_email, "@") === false)) {
							$f_name = "";
							$f_email = "";
							
							if ( strpos($bcc_email, '<' ) !== false ) {
								// So... making my life hard again?
								$f_name = substr( $bcc_email, 0, strpos( $bcc_email, '<' ) - 1 );
								$f_name = str_replace( '"', '', $f_name );
								$f_name = trim( $f_name );
		
								$f_email = substr( $bcc_email, strpos( $bcc_email, '<' ) + 1 );
								$f_email = str_replace( '>', '', $f_email );
								$f_email = trim( $f_email );
								
								$recipient_list->addBcc($f_email, $f_name);
							} else {
								$f_email = trim( $bcc_email );
								
								$recipient_list->addBcc($f_email);
							}
						}
					}
				}
				else if ('reply-to' == strtolower($name)) {
					$message->setReplyTo($content);
				}
			}
		}
	}
	
	// overwriting if specified or necessary
	if ((empty($headers)) || ($st_smtp_config['overwrite_sender'])) {
		$from_name = $st_smtp_config['sender_name'];
		$from_email = $st_smtp_config['sender_mail'];
	}
	
	if (!$st_smtp_config['overwrite_sender']) {
		// Set the from name and email
		$from_email = apply_filters( 'wp_mail_from', $from_email );
		$from_name = apply_filters( 'wp_mail_from_name', $from_name );
	}
	
	$from =& new Swift_Address($from_email, $from_name);


/* CHECK FOR ATTACHMENT */
	if ($attached === false){ }else{
				$messd = nl2br($content);
				$mess = explode('<br />', $messd);
				foreach($mess as $x){
					$app .= rtrim(strstr($x, 'application'), ';');
					$filename .= rtrim(str_replace('filename="', '', strstr($x, 'filename')), '"');
					$plain = strpos($x, 'text/plain');
					if( $plain === false){}else{
						$text = true;
					}
					$end = strpos($x, 'application/');
					if($end === false){}else{
						$text = false;
					}
					if($text = true){
							$count = 0;
							if($count > 0){
								$tmsg .= $x."\n";
							}
							$count = $count + 1;
					}
				}
				$name = $filename;
				$file = ABSPATH . WP_BACKUP_DIR . '/' . $filename;
				$message->attach(new Swift_Message_Attachment(  new Swift_File($file), $name, $app));
				
		/* CHECK FOR MESSAGE */
		
		$message->attach(new Swift_Message_Part($tmsg));
	}

/* SEND EMAIL */
	// ADD THIS TO HAVE MORE ERROR CODES ONLY FOR PHP5
	if ($is_php5) {
		require("php5_sender.php");
	}
	// PHP4
	else if ($is_php4) {
		if ($swift->send($message, $recipient_list, $from))
			$success = true;
		else {
			echo "Message failed to send to ".$to." from ".$from;
			$success = false;
		}
	}
	
	$swift->disconnect();
	return $success;
}
}
?>