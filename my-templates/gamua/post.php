		<div id="position-<?php post_position(); ?>">
			<div class="threadauthor resp-rem">
				<?php post_author_avatar_link(); ?>
				<p>
					<strong><?php post_author_link(); ?></strong><br />
					<small><?php post_author_title_link(); ?></small>
				</p>
			</div>
			<div class="threadpost">

				<div class="threadauthor-horiz resp-add">
				 	
				<div class="threadauthor-horiz-left"><?php post_author_avatar_link(); ?></div>
				<div class="threadauthor-horiz-center"><strong><?php post_author_link(); ?></strong></div>
				<div class="threadauthor-horiz-right"><?php post_author_title_link(); ?></div>
					
				</div>

				<div class="post"><?php post_text(); ?></div>
				<div class="poststuff"><span title="<?php bb_post_time( array('format' => 'datetime') );?>"><?php printf( __('Posted %s ago'), bb_get_post_time() ); ?></span> <a href="<?php post_anchor_link(); ?>">#</a> <?php bb_post_admin(); ?></div>
			</div>
		</div>
