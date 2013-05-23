<?php
	try {
		if ($swift->send($message, $recipient_list, $from))
			$success = true;
		else {
			echo "Message failed to send to ".$to." from ".$from;
			$success = false;
		}
	} catch (Swift_ConnectionException $e) {
		echo "There was a problem communicating with SMTP: " . $e->getMessage();
		$success = false;
	} catch (Swift_Message_MimeException $e) {
		echo "There was an unexpected problem building the email:" . $e->getMessage();
		$success = false;
	}
?>