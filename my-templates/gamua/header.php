<?php
$_head_profile_attr = '';
if ( bb_is_profile() ) {
	global $self;
	if ( !$self ) {
		$_head_profile_attr = ' profile="http://www.w3.org/2006/03/hcard"';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>
<head<?php echo $_head_profile_attr; ?>>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta name="google-site-verification" content="9mnrTPsE6rw-r6mFmLc1Fkf0wbcCeLtuKrNoLwZ3qRk" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=790">
	<title><?php bb_title() ?></title>
	<link rel="shortcut icon" href="<?php bb_option('uri'); ?>favicon.ico" type="image/vnd.microsoft.icon" />

    <script type="text/javascript" src="<?php echo bb_get_active_theme_uri() . "js/jquery-1.10.2.min.js" ?>"></script>

	<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ubuntu+Mono:400|Ubuntu:400,500,700|Ubuntu+Condensed" type="text/css">
<?php if ( 'rtl' == bb_get_option( 'text_direction' ) ) : ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css" />
<?php endif; ?>

<?php

bb_feed_head();
bb_head();

// ***** Variations for each Framework ******

// the first part of the forum name is used as the folder for the varying images.
// Furthermore, you need to define a fallback-color.

$forum_name_parts = explode(" ", strtolower(bb_get_option('name')));
$forum_name = $forum_name_parts[0];
$image_folder = bb_get_active_theme_uri() . "images/" . $forum_name;
$header_color; $piwik_id;

if ($forum_name == "starling")
{
  $header_color = "#c14140";
  $piwik_id = 5;
}
else // sparrow
{
  $header_color = "#296ac1";
  $piwik_id = 4;
}

$header_style = "background-color: " . $header_color . "; " . 
                "background-image: url(" . $image_folder . "/header_bg.jpg);";
$logo_style   = "background-image: url(" . $image_folder . "/header_logo.png);";

// ******

?>

</head>
<body id="<?php bb_location(); ?>">
	
  <!-- Piwik Analytics -->
  <script type="text/javascript">
    var _paq = _paq || [];

    (function () {
        var siteId = <?php echo $piwik_id ?>;
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

  <div id="wrapper">
		
	  <div class="stylehead" style="<?php echo $header_style ?>">
      <div class="header_row">
        <div class="header">
          <a href="<?php bb_uri(); ?>">
            <div class="logo" style="<?php echo $logo_style ?>">
              <h1><?php bb_option('name'); ?></h1>
              <p><?php bb_option('description'); ?></p>
            </div>
          </a>
          <?php if (!in_array( bb_get_location(), array('login-page', 'register-page'))) login_form(); ?>
        </div>
      </div>
    </div>
    
    <div class="bbcrumb_bar">
      <div class="bbcrumb_container">
        <div class="search">
          <?php search_form(); ?>
        </div>
      </div>
    </div>
	
		<div id="main">

<?php if ( bb_is_profile() ) profile_menu(); ?>
