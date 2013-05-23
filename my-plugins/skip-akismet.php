<?php
/*
Plugin Name: Skip Akismet
Plugin URI: http://bbpress.org/plugins/topic/skip-akismet
Description: Skips the Akismet check for any users that have been registered for over 24 hours.
Author: _ck_
Author URI: http://bbShowcase.org
Version: 0.0.4
*/

if (isset($_POST['post_content'])) 
{ 
    add_action('bb_init', 'skip_akismet', 9); 
}

function skip_akismet() 
{
    global $bbdb; $user = bb_get_current_user();

    if (!empty($user->ID))
    {
        $registered_time = bb_gmtstrtotime($user->user_registered);
        if ($registered_time < (time() - 86400)) 
        {
            remove_action( 'pre_post', 'bb_ksd_check_post', 1 );
            remove_filter( 'bb_new_post', 'bb_ksd_new_post' );
            remove_filter( 'pre_post_status', 'bb_ksd_pre_post_status' );
        }
    }
}

?>