<?php bb_get_header(); ?>

<?php if ( $forums ) : ?>

<div class="bbcrumb"><a href="<?php bb_uri(); ?>">Start</a> &raquo; <?php _e('Front Page')?></div>

<div id="discussions">
<?php if ( $topics || $super_stickies ) : ?>

<h2><?php _e('Latest Discussions'); ?></h2>

<table id="latest">
<tr>
	<th class="col-topic  num"><?php _e('Topic'); ?> &#8212; <?php bb_new_topic_link(); ?></th>
	<th class="col-posts  resp-rem"><?php _e('Posts'); ?></th>
	<th class="col-poster resp-rem"><?php _e('Last Poster'); ?></th>
	<th class="col-activity num"><?php _e('Activity'); ?></th>
</tr>

<?php if ( $super_stickies ) : foreach ( $super_stickies as $topic ) : ?>
<tr<?php topic_class(); ?>>
	<td class="col-topic"><?php bb_topic_labels(); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big><?php topic_page_links(); ?></td>
	<td class="col-posts    num resp-rem"><?php topic_posts(); ?></td>
	<td class="col-poster   num resp-rem"><?php topic_last_poster(); ?></td>
	<td class="col-activity num"><a href="<?php topic_last_post_link(); ?>"><span title="<?php topic_time( array('format' => 'datetime') );?>"><?php topic_time(); ?></span></a></td>
</tr>
<?php endforeach; endif; // $super_stickies ?>

<?php if ( $topics ) : foreach ( $topics as $topic ) : ?>
<tr<?php topic_class(); ?>>
	<td class="col-topic"><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a><?php topic_page_links(); ?>
		<?php 
			$numPosts = get_topic_posts();
			$lastPoster = get_topic_last_poster();
			$topicInfo = $numPosts == 1 ? "by " . $lastPoster :
			                              $numPosts . " posts, latest by <strong>" . $lastPoster . "</strong>";
		?>
		<span class="topic-info resp-add"><br/>[<?php echo $topicInfo ?>]</span>
	</td>
	<td class="col-posts    num resp-rem"><?php topic_posts(); ?></td>
	<td class="col-poster   num resp-rem"><?php topic_last_poster(); ?></td>
	<td class="col-activity num"><a href="<?php topic_last_post_link(); ?>"><span title="<?php topic_time( array('format' => 'datetime') );?>"><?php topic_time(); ?></span></a></td>
</tr>
<?php endforeach; endif; // $topics ?>
</table>
<?php bb_latest_topics_pages( array( 'before' => '<div class="nav">', 'after' => '</div>' ) ); ?>
<?php endif; // $topics or $super_stickies ?>

<?php if ( bb_forums() ) : ?>
<h2><?php _e('Forums'); ?></h2>
<table id="forumlist">

<tr>
	<th class="col-theme"><?php _e('Main Theme'); ?></th>
	<th class="col-topics"><?php _e('Topics'); ?></th>
	<th class="col-total"><?php _e('Posts'); ?></th>
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
<?php endif; // bb_forums() ?>

<?php if ( bb_is_user_logged_in() ) : ?>
<div id="viewdiv">
<h2><?php _e('Views'); ?></h2>
<ul id="views">
<?php foreach ( bb_get_views() as $the_view => $title ) : ?>
<li class="view"><a href="<?php view_link( $the_view ); ?>"><?php view_name( $the_view ); ?></a></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; // bb_is_user_logged_in() ?>

<div id="hottags" role="main">
<h2><?php _e('Hot Tags'); ?></h2>
<p class="frontpageheatmap"><?php bb_tag_heat_map(); ?></p>
</div>

</div>

<?php else : // $forums ?>

<div class="bbcrumb"><a href="<?php bb_uri(); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Add New Topic'); ?></div>

<?php post_form(); endif; // $forums ?>

<?php bb_get_footer(); ?>
