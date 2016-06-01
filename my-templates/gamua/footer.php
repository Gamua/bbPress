		</div>
	</div>
	<div id="footer" role="contentinfo">
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

<script type='text/javascript'>
    var _merchantSettings = _merchantSettings || [];
    _merchantSettings.push(['AT', '10lJ37']);
    _merchantSettings.push(['CT', 'Forum']);
    (function () {
        var autolink = document.createElement('script');
        autolink.type = 'text/javascript';
        autolink.async = true;
        autolink.src = ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(autolink, s);
    })();
</script>
<!-- <?php echo 'Page rendered with PHP ' . phpversion(); ?> -->

</body>
</html>