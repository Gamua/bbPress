<?php
	$smtp =& new Swift_Connection_SMTP($st_smtp_config['server'], Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
?>