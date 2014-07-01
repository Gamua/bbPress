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

<?php
        //This adds the information about Flox being the official game backend
        //for Starling to forum topics/threads as a driftwood-like scroll-aware
        //banner on the left-hand side of the topic. There is a single dependency
        //on jQuery. All driftwood-relevant code is below this line.

        $forum_name_parts = explode(" ", strtolower(bb_get_option('name')));
        $forum_name = $forum_name_parts[0];
        $is_test_forum = $forum_name == "gamua";
        $is_starling_forum = $forum_name == "starling";
        $is_sparrow_forum = $forum_name == "sparrow";

        if (bb_is_topic() && ($is_test_forum || $is_starling_forum)) {
?>
    <style type="text/css">
        #driftwood {
            display: none;
            overflow: hidden;
            position: fixed;

            width: 120px;
            background-color: #eee;
            -moz-border-radius: 8px;
            -khtml-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;

            padding-top: 20px;
        }

        #driftwood * {
            display: block;
            overflow: auto;
            margin: auto;
            font-size: 14px;
            line-height: 21px;
            text-align: center;
            color: black;

            /*ie, i heart u*/
            border: none;
            outline: none;
        }

        #driftwood:hover {
            background-color: #ddd;
        }

        #driftwood:hover > a {
            text-decoration: none;
        }
    </style>

    <div id="driftwood">
        <a href="http://gamua.com/flox" title="Flox - The No-Fuzz Game Backend">
            <div>
                <img width="100" height="37" src="<?php echo bb_get_active_theme_uri() . "images/driftwood/flox-logo.png" ?>"/>
            </div>
            <div style="margin-top:20px; margin-bottom:20px; padding-left:10px; padding-right:10px;">
                The No-Fuzz Game Backend For Starling
            </div>
            <div>
                <img width="120" height="152" src="<?php echo bb_get_active_theme_uri() . "images/driftwood/birds-looking-up.png" ?>"/>
            </div>
        </a>
    </div>

    <script type="text/javascript" defer="defer" async="async">
        $("document").ready(function () {
            var win = $(window);
            var driftwood = $("#driftwood");
            var driftwoodVisible = false;
            var driftwoodY = 150;
            var contentWidthHalf = 400;

            var positionDriftwood = function () {
                var left = win.width() / 2 + contentWidthHalf;
                var top = Math.min(driftwoodY, Math.max(20, driftwoodY - win.scrollTop()));

                driftwood.css("left", left).css("top", top);

                if (!driftwoodVisible) {
                    driftwoodVisible = true;
                    driftwood.show();
                }
            };

            win.resize(positionDriftwood);
            win.scroll(positionDriftwood);
            positionDriftwood();
        });
    </script>
<?php } ?>

<script type='text/javascript'>
    var _merchantSettings = _merchantSettings || [];
    _merchantSettings.push(['AT', '10lJ37'], ['CT', 'Forum']);
    (function () {
        var autolink = document.createElement('script');
        autolink.type = 'text/javascript';
        autolink.async = true;
        autolink.src = ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(autolink, s);
    })();
</script>

</body>
</html>
