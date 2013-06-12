		</div>
	</div>
	<div id="footer" role="contentinfo">
		<!-- I removed this because Spammers might be attracted by bbPress ... -->
        <!-- <p><?php printf(__('%1$s is proudly powered by <a href="%2$s">bbPress</a>.'), bb_option('name'), "http://bbpress.org") ?></p> -->
        <p><?php printf("<a href='http://gamua.com'>Gamua</a> - Consistent Game Development across all Platforms") ?></p>

		<!-- If you like showing off the fact that your server rocks -->
		<!-- <p class="showoff">
<?php
global $bbdb;
printf(
__( 'This page generated in %s seconds, using %d queries.' ),
bb_number_format_i18n( bb_timer_stop(), 2 ),
bb_number_format_i18n( $bbdb->num_queries )
);
?>
		</p> -->
	</div>

<?php do_action('bb_foot'); ?>

</body>
</html>
