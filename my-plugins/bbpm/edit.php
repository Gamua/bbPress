<?php
/**
 * @package bbPM
 * @version 1.0.2
 * @author Nightgunner5
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License, Version 3 or higher
 */

/**
 * Prevent {@link http://bbpress.org/plugins/topic/subscribe-to-topic/ Subscribe to Topic}
 * from removing "unsubscribe" from the query string.
 *
 * @since 0.1-alpha6b
 */
define( 'BBPM_STT_FIX', true );

/**
 * Load the bbPress core
 */
require_once dirname( dirname( dirname( __FILE__ ) ) ) . '/bb-load.php';

bb_auth( 'logged_in' ); // Is the user logged in?

global $bbpm, $bb_current_user;

if ( !bb_current_user_can( 'write_posts' ) || ( function_exists( 'bb_current_user_is_bozo' ) && bb_current_user_is_bozo() ) ) 
	bb_die( __( 'You are not allowed to edit private messages.  Are you logged in?', 'bbpm' ) );
if ( !trim( $_POST['message'] ) )
	bb_die( __( 'You need to actually submit some content!' ) );

$redirect_to = $bbpm->edit((int)$_POST['id'], stripslashes( $_POST['message'] ) );

if ( !$redirect_to )
	bb_die( __( 'There was an error sending your message.<br/><br/>MESSAGE:<br />'.stripslashes( $_POST['message'] ), 'bbpm' ) );
else if (substr($redirect_to, 0, 6) == 'ERROR:')
	if ($bbpm->settings['show_errors']) 
		bb_die( __( 'There was an error sending your message.<br/><br/>'.$redirect_to.'<br/><br/>MESSAGE:<br />'.stripslashes( $_POST['message'] ), 'bbpm' ) );
	else
		bb_die( __( 'There was an error sending your message.<br/><br/>MESSAGE:<br />'.stripslashes( $_POST['message'] ), 'bbpm' ) );
else 
	wp_redirect( $redirect_to );
exit;
