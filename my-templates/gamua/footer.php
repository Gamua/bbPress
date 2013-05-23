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

<!--
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("UA-11324041-1");
pageTracker._trackPageview();
} catch(err) {}</script>
-->

<script type="text/javascript">
    var _paq = _paq || [];

    (function () {
        var siteId = 4;
        var piwikBaseUrl = (("https:" == document.location.protocol) ? "https://analytics.gamua.com/" : "http://analytics.gamua.com/");

        _paq.push(['setSiteId', siteId]);
        _paq.push(['setTrackerUrl', piwikBaseUrl + 'piwik.php']);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);

        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
        g.type = 'text/javascript';
        g.defer = true;
        g.async = true;
        g.src = piwikBaseUrl + 'piwik.js';
        s.parentNode.insertBefore(g, s);
    })();
</script>

</body>
</html>
