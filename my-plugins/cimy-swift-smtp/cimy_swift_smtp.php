<?php
/*
Plugin Name: Cimy Swift SMTP
Plugin URI: http://www.marcocimmino.net/cimy-wordpress-plugins/cimy-swift-smtp/
Description: Send email via SMTP (Compatible with GMAIL)
Author: Marco Cimmino
Version: 1.2.3
Author URI: mailto:cimmino.marco@gmail.com

Copyright (c) 2007-2009 Marco Cimmino

original plug-in is from Marcus Vanstone
http://www.shiftthis.net/wordpress-swift-smtp-plugin/


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.


The full copy of the GNU General Public License is available here: http://www.gnu.org/licenses/gpl.txt

*/

$cimy_swift_plugin_path = plugin_basename(dirname(__FILE__))."/";

include('swift_engine.php');

//st_smtp_check_config(); //Initialize Configuration Variables

add_action('bb_admin_menu_generator', 'st_smtp_add_pages'); //Add page menu links

if (isset($_POST['st_smtp_submit_options']))
	add_action('bb_init', 'st_smtp_options_submit'); //Update Options 

// Load Options
$st_smtp_config = bb_get_option('st_smtp_config');
$cimy_swift_domain = 'cimy_swift_smtp';
load_plugin_textdomain($cimy_swift_domain, dirname(__FILE__) . '/langs');
/*
$cimy_swift_i18n_is_setup = 0;
cimy_swift_i18n_setup();

function cimy_swift_i18n_setup() {
	global $cimy_swift_domain, $cimy_swift_i18n_is_setup, $cimy_swift_plugin_path;

	if ($cimy_swift_i18n_is_setup)
		return;

	load_plugin_textdomain($cimy_swift_domain, PLUGINDIR.'/'.$cimy_swift_plugin_path.'langs', $cimy_swift_plugin_path.'langs');

}
*/

/*-------------------------------------------------------------
 Name:      st_smtp_add_pages
 Purpose:   Add pages to admin menus
-------------------------------------------------------------*/
function st_smtp_add_pages() {
	global $cimy_top_menu;
	global $bb_submenu;

	
//	if (isset($cimy_top_menu))
//		add_submenu_page('cimy_series.php', "Cimy Swift SMTP", "Swift SMTP", 10, "swift_smtp", 'st_smtp_options_page');
	bb_admin_add_submenu('Cimy Swift SMTP', 'use_keys', 'st_smtp_options_page');
//	else
//		add_options_page('Cimy Swift SMTP', 'Cimy Swift SMTP', 10, "swift_smtp", 'st_smtp_options_page');
}

function st_smtp_options_page() {
	global $cimy_swift_domain;

	if (isset($_GET['error']) || (!bb_current_user_can('manage_options')))
		return;

	// Make sure we have the freshest copy of the options
	$st_smtp_config = bb_get_option('st_smtp_config');
	
	$st_smtp_config['server'] = attribute_escape($st_smtp_config['server']);
	$st_smtp_config['username'] = attribute_escape($st_smtp_config['username']);
	$st_smtp_config['password'] = attribute_escape($st_smtp_config['password']);
	$st_smtp_config['sender_name'] = attribute_escape($st_smtp_config['sender_name']);
	$st_smtp_config['sender_mail'] = attribute_escape($st_smtp_config['sender_mail']);
	
	if ($st_smtp_config['overwrite_sender'])
		$overwrite_sender = ' checked="checked"';
	else
		$overwrite_sender = '';

	?>
	<div class="wrap">
	<?php
		if (function_exists(screen_icon))
			screen_icon();
	?>
		<h2>Cimy Swift SMTP</h2>
		<p><?php _e("Add here your SMTP server details", $cimy_swift_domain); ?><br /><?php _e("<strong>Note:</strong> Gmail users need to use the server 'smtp.gmail.com' with TLS enabled and port 465", $cimy_swift_domain); ?></p>
		<form method="post" action="<?php echo bb_get_option('uri') . 'bb-admin/admin-base.php?plugin=st_smtp_options_page&amp;updated=true'; ?>">
		<input type="hidden" name="st_smtp_submit_options" value="true" />
		<table width="600">
		<tr>
			<td width="30%">
				<label for="css_sender_name"><?php _e("Sender name:", $cimy_swift_domain); ?></label>
			</td>
			<td width="70%">
				<input id="css_sender_name" name="css_sender_name" type="text" size="25" value="<?php echo $st_smtp_config['sender_name'];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_sender_mail"><?php _e("Sender e-mail:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<input id="css_sender_mail" name="css_sender_mail" type="text" size="25" value="<?php echo $st_smtp_config['sender_mail'];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_sender_overwrite"><?php _e("Always overwrite the sender:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<input id="css_sender_overwrite" name="css_sender_overwrite" type="checkbox" value="1"<?php echo $overwrite_sender;?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_server"><?php _e("SMTP server address:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<input id="css_server" name="css_server" type="text" size="25" value="<?php echo $st_smtp_config['server'];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_port"><?php _e("Port:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<select id="css_port" name="css_port">
					<option value="25" <?php if ($st_smtp_config['port'] == "25"){echo "selected='selected'";}?>><?php _e("25 (Default SMTP Port)", $cimy_swift_domain); ?></option>
					<option value="465" <?php if ($st_smtp_config['port'] == "465"){echo "selected='selected'";}?>><?php _e("465 (Use for SSL/TLS/GMAIL)", $cimy_swift_domain); ?></option>
					<option value="custom" <?php if ( ($st_smtp_config['port'] != "465") && ($st_smtp_config['port'] != "25") ){echo "selected='selected'";}?>><?php _e("Custom Port: (Use Box)", $cimy_swift_domain); ?></option>
				</select>&nbsp;<input name="css_customport" type="text" size="4" value="<?php if (($st_smtp_config['port'] != "465") && ($st_smtp_config['port'] != "25")) { echo $st_smtp_config['port']; } ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_username"><?php _e("Username:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<input id="css_username" name="css_username" type="text" size="25" value="<?php echo $st_smtp_config['username'];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_password"><?php _e("Password:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<input id="css_password" name="css_password" type="password" size="25" value="<?php echo $st_smtp_config['password'];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="css_ssl"><?php _e("Use SSL or TLS?:", $cimy_swift_domain); ?></label>
			</td>
			<td>
				<select id="css_ssl" name="css_ssl">
					<option value="" <?php if ($st_smtp_config['ssl'] == ''){echo 'selected="selected"';}?>><?php _e("No", $cimy_swift_domain); ?></option>
					<option value="ssl" <?php if ($st_smtp_config['ssl'] == 'ssl'){echo 'selected="selected"';}?>><?php _e("SSL", $cimy_swift_domain); ?></option>
					<option value="tls" <?php if ($st_smtp_config['ssl'] == 'tls'){echo 'selected="selected"';}?>><?php _e("TLS (Use for Gmail)", $cimy_swift_domain); ?></option>
				</select>
			</td>
		</tr>
		</table>
			
			<p class="submit" style="text-align:left">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e("Save Changes"); ?>" />
			</p>
		</form>
		<br />
		<h2><?php _e("Test Connection", $cimy_swift_domain); ?></h2>
		<p><?php _e("Once you've saved your settings, click the link below to test your connection.", $cimy_swift_domain); ?></p>
		<form method="post" action="">
			<input type="hidden" name="test" value="1" />
			<label><?php _e("Send Test Email to this Address:", $cimy_swift_domain); ?> <input type="text" name="testemail" size="25" /> <input class="button" type="submit" value="<?php _e("Send Test", $cimy_swift_domain); ?>" /></label><br />
		</form>

		<?php
		if (isset($_POST['test'])) {
			?><br /><br /><h2><?php _e("Test result", $cimy_swift_domain); ?></h2><?php
			$email = $_POST['testemail'];
			
			if ($email == "")
				$email = form_option('admin_email');
			
			$text = __("This is a test mail sent using the Cimy Swift SMTP Plugin. If you've received this email it means your connection has been set up properly! Cool!", $cimy_swift_domain);
			
			if (bb_mail($email, 'Cimy Swift SMTP Test', $text)) {
				echo "<p><strong>".__("TEST EMAIL SENT - Connection Verified.", $cimy_swift_domain)."<br />".__("If you don't receive the e-mail check also the spam folder.", $cimy_swift_domain)."</strong></p>";
			}
		}

		?>
	</div>
	<?php
}

function st_smtp_check_config() {

	if (!$option = bb_get_option('st_smtp_config')) {

		// Default Options
		bb_update_option('st_smtp_config', $option);
	}
}

function st_smtp_options_submit() {

	if (!bb_current_user_can('manage_options'))
		return;

	//options page
	$option['server'] = $_POST['css_server'];
	$option['username'] = $_POST['css_username'];
	$option['password'] = $_POST['css_password'];
	$option['ssl'] = $_POST['css_ssl'];

	$option['sender_name'] = $_POST['css_sender_name'];
	$option['sender_mail'] = $_POST['css_sender_mail'];
	
	if (isset($_POST['css_sender_overwrite']))
		$option['overwrite_sender'] = true;
	else
		$option['overwrite_sender'] = false;
		
	if ($_POST['css_port'] != 'custom'){
		$option['port'] = $_POST['css_port'];
	} else {
		$option['port'] = intval($_POST['css_customport']);
	}

	bb_update_option('st_smtp_config', $option);
}
?>