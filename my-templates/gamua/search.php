<?php bb_get_header(); ?>
<div class="bbcrumb"><a href="<?php bb_uri(); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Search')?></div>

<br/>
<br/>

<?php

$forum_name = explode(" ", strtolower(bb_get_option('name')))[0];
$custom_search_id;

if ($forum_name == "starling")
  $custom_search_id = "005966533546828650596:8edtpwdmbeg";
else // sparrow
  $custom_search_id = "005966533546828650596:oxrylrdroaa";

?>

<div>
	<script>
	  (function() {
	    var cx = '<?php echo($custom_search_id) ?>';
	    var gcse = document.createElement('script');
	    gcse.type = 'text/javascript';
	    gcse.async = true;
	    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
	        '//www.google.com/cse/cse.js?cx=' + cx;
	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(gcse, s);
	  })();
	</script>
	<gcse:searchbox></gcse:searchbox>
</div>

<div>
	<gcse:searchresults></gcse:searchresults>
</div>

<?php bb_get_footer(); ?>


