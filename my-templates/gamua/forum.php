<?php bb_get_header(); ?>

<div class="bbcrumb"><a href="<?php bb_uri(); ?>"><?php bb_option('name'); ?></a><?php bb_forum_bread_crumb(); ?></div>

<?php // --- Modifications to show the latest posts of all subforums -------------------------

$page_switcher = "";

if (bb_get_forum_is_category())
{
    global $bbdb;
    global $page;

    $bbdb->query("SELECT forum_id FROM $bbdb->forums WHERE forum_parent='$forum_id'");
    $forum_ids = (array) $bbdb->get_col( '', 0 );
    $forum_ids_joined = implode(",", $forum_ids);
    $topic_query = new BB_Query('topic', array('forum_id' => $forum_ids_joined,'per_page' => 30,'page' => $page));
    $topics = $topic_query->results;
    $topics_count = $bbdb->get_var('SELECT COUNT(`topic_id`) FROM `' . $bbdb->topics . 
        '` WHERE `topic_status` = 0 AND `forum_id` IN (' . $forum_ids_joined . ');');
    
    if ($pages = get_page_number_links($page, $topics_count))
        $page_switcher = '<div class="nav">' . $pages . '</div>';
} 

// ---------------------------------------------------------------------------------------- ?>

<?php if ( $topics || $stickies ) : ?>

<table id="latest" role="main">
<tr>
	<th><?php _e('Topic'); ?> &#8212; <?php bb_new_topic_link(); ?></th>
	<th><?php _e('Posts'); ?></th>
	<!-- <th><?php _e('Voices'); ?></th> -->
	<th><?php _e('Last Poster'); ?></th>
	<th><?php _e('Freshness'); ?></th>
</tr>

<?php if ( $stickies ) : foreach ( $stickies as $topic ) : ?>
<tr<?php topic_class(); ?>>
	<td><?php bb_topic_labels(); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big><?php topic_page_links(); ?></td>
	<td class="num"><?php topic_posts(); ?></td>
	<!-- <td class="num"><?php bb_topic_voices(); ?></td> -->
	<td class="num"><?php topic_last_poster(); ?></td>
	<td class="num"><a href="<?php topic_last_post_link(); ?>"><span title="<?php topic_time( array('format' => 'datetime') );?>"><?php topic_time(); ?></span></a></td>
</tr>
<?php endforeach; endif; ?>

<?php if ( $topics ) : foreach ( $topics as $topic ) : ?>
<tr<?php topic_class(); ?>>
	<td><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a><?php topic_page_links(); ?></td>
	<td class="num"><?php topic_posts(); ?></td>
	<!-- <td class="num"><?php bb_topic_voices(); ?></td> -->
	<td class="num"><?php topic_last_poster(); ?></td>
	<td class="num"><a href="<?php topic_last_post_link(); ?>"><span title="<?php topic_time( array('format' => 'datetime') );?>"><?php topic_time(); ?></span></a></td>
</tr>
<?php endforeach; endif; ?>
</table>
<!--
<p class="rss-link"><a href="<?php bb_forum_posts_rss_link(); ?>" class="rss-link"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> feed for this forum'); ?></a></p>
-->
<?php 

    if ($page_switcher === "")
        forum_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) );
    else
        echo $page_switcher;

endif ?>

<?php if ( bb_forums( $forum_id ) ) : ?>
<h2><?php _e('Subforums'); ?></h2>
<table id="forumlist">

<tr>
	<th><?php _e('Main Theme'); ?></th>
	<th><?php _e('Topics'); ?></th>
	<th><?php _e('Posts'); ?></th>
</tr>

<?php while ( bb_forum() ) : ?>
<?php if (bb_get_forum_is_category()) : ?>
<tr<?php bb_forum_class('bb-category'); ?>>
	<td colspan="3"><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><?php forum_description( array( 'before' => '<small> &#8211; ', 'after' => '</small>' ) ); ?><?php bb_forum_pad( '</div>' ); ?></td>
</tr>
<?php continue; endif; ?>
<tr<?php bb_forum_class(); ?>>
	<td><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><?php forum_description( array( 'before' => '<small> &#8211; ', 'after' => '</small>' ) ); ?><?php bb_forum_pad( '</div>' ); ?></td>
	<td class="num"><?php forum_topics(); ?></td>
	<td class="num"><?php forum_posts(); ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php endif; ?>

<?php post_form(); ?>

<?php bb_get_footer(); ?>
