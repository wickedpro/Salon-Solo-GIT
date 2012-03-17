<?php
/**
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
  <link href='http://fonts.googleapis.com/css?family=Stint+Ultra+Condensed' rel='stylesheet' type='text/css'><!--h2font-->
  <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'><!--body--><!--Flex Slider -->
  <link rel="stylesheet" href="css/flexslider.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script src="js/libs/jquery.flexslider-min.js"></script>
  <script type="text/javascript" charset="utf-8">
     $(window).load(function() {
     $('.flexslider').flexslider({
         animation: "fade",
         directionNav: false, 
     });
    });
</script>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php
			wp_title( '|', true, 'right' );
		?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
<header>
		<h1>Salon Solo</h1>
    </header>
    
    <div id="main" role="main">
		<div id="logo">
			<ul id="navigation">
				<li><h4>Home</h4></li>
				<li><h4>About</h4></li>
				<li><h4>Services</h4></li>
				<li><h4>Store</h4></li>
				<li><h4>Blog</h4></li>
				<li><h4>Contact</h4></li>
			</ul>
		</div>

