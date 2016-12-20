<?php
/**
 * Plugin Name: Post Notification
 * Plugin Description: Sends an Notification email if there's a new post to an favorite topic. (Modified Version 1.4 with Post Content included in E-Mail)
 * Author: Thomas Klaiber
 * Author URI: http://thomasklaiber.com/
 * Plugin URI: http://thomasklaiber.com/bbpress/post-notification/
 * Version: 1.4
 */

function notification_new_post($post_id=0) {
	global $bbdb, $bb_table_prefix, $topic_id, $bb_current_user;

	$all_users = notification_select_all_users();
	foreach ($all_users as $userdata) :
		if ( notification_is_activated( $userdata->ID ) ) :
			if ( is_user_favorite( $userdata->ID, $topic_id ) ) :
				$sender_email = bb_get_user_email($bb_current_user->ID);
				$user_email = $userdata->user_email;
				if ($sender_email !== $user_email) :
					$subject = bb_get_option('name') . ': ' . __('Notification');
					$headers = 'From: ' . bb_get_option('name') . ' <' . bb_get_option('from_email') . '>';
					$message = sprintf(
						"The user \"%s\" just added a new post on the topic \"%s\":\n\n%s%s",
						get_user_name($bb_current_user->ID), get_topic_title($topic_id),
						strip_tags(get_post_text($post_id)), get_topic_link($topic_id));
					bb_mail( $user_email, $subject, $message, $headers);
				endif;
			endif;
		endif;
	endforeach;
}
add_action('bb_new_post', 'notification_new_post');

function notification_select_all_users() {
	global $bbdb;

	$all_users = $bbdb->get_results("SELECT ID, user_email FROM $bbdb->users WHERE user_status=0");

	return $all_users;
}

function notification_profile() {
	global $user_id, $bb_current_user;

	if ( bb_is_user_logged_in() ) :

		$checked = "";
		if (notification_is_activated($user_id)) :
			$checked = "checked='checked'";
		endif;

		echo "<fieldset>
<legend>Favorite Notification</legend>
<p> " . __('Do you want to get an email when there is a new post to a topic in your favorites?') . "</p>
<table width=\"100%\">
<tr>
<th width=\"21%\" scope=\"row\">" . __('Activate') . ":</th>
<td width=\"79%\" ><input name=\"favorite_notification\" id=\"favorite_notification\" type=\"checkbox\" value=\"1\"" . $checked . " /></td>
</tr>
</table>
</fieldset>\n\n";
	endif;
}
add_action('extra_profile_info', 'notification_profile');

function notification_profile_edit() {
	global $user_id;

	bb_update_usermeta($user_id, "favorite_notification", $_POST['favorite_notification'] ? true : false);
}
add_action('profile_edited', 'notification_profile_edit');

function notification_is_activated($user_id) {
	$user = bb_get_user( $user_id );
	if ($user->favorite_notification) :
		return true;
	else :
		return false;
	endif;
}
?>