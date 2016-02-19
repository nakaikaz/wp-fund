<?php $en = ( 'en' == qtrans_getLanguage() ? true : false ); ?>
<!doctype html>
	<!--[if IE 7]>
	<html class="ie ie7" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if IE 8]>
	<html class="ie ie8" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if !(IE 7) | !(IE 8)  ]><!-->
	<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="keywords" content="青い森コミュニティ基金,一般財団法人,財団,コミュニティ基金,市民ファンド,助成金,寄付,寄附,NPO,非営利,市民活動"/>
		<meta description="私たちは、青森の市民の方々、企業の方々の社会貢献活動への「志」を支援し、民が民をサポートすることで地域コミュニティが豊かになり、持続可能な社会になることを目指しています。"/>
		<meta name="viewport" content="width=device-width" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		<?php
		wp_enqueue_style( 'slides', get_template_directory_uri() .'/css/slides.css', array(), null);
		wp_enqueue_script( 'slides', get_template_directory_uri() . '/js/jquery.slides.min.js', array('jquery'), null);
		wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), null);
		wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);
		if( $en )
			wp_enqueue_style( 'en', get_template_directory_uri() .'/style.en.css', array( 'accf-style' ), null );
		wp_head(); ?>
	</head>
	<body>
		<?php include_once("analyticstracking.php"); ?>

		<!-- begin header -->
		<div class="container_12">
			<div id="header">
				<div class="grid_5" style="height: 117px;">
					<p style="margin: 0;"><?php _e( 'Designs of civil society initiating philanthropic mind', 'accf' ); ?></p>
					<h1><a href="<?php echo home_url_qtrans(); ?>"><?php _e( 'Aoimori Community Fund', 'accf' ); ?></a></h1>
				</div>
				<div class="grid_4">&nbsp;</div>
				<div class="grid_3">
					<?php echo qtrans_generateLanguageSelectCode('both'); ?>
					<div id="searchbox">
						<?php get_search_form( ); ?>
					</div>
				</div>
				<div class="clear">&nbsp;</div>
				<div class="grid_12">
					<div id="fontsize">
						<a href="#" class="font-smaller">-</a>
						<a href="#" style="font-size: 12px;" class="font-small"><?php echo $en? 'A' : '小'; ?></a>
						<a href="#" style="font-size: 16px;" class="font-medium"><?php echo $en ? 'A' : '中'; ?></a>
						<a href="#" style="font-size: 20px;" class="font-large"><?php echo $en ? 'A' : '大'; ?></a>
						<a href="#" class="font-larger">+</a>
					</div>
					<div id="navbox">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-header', 'menu_id' => 'menu-main' ) ); // Top Menu ?>
					</div>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
		</div>
		<div class="breakout">
			<div class="container_12">
				<div class="grid_12">
					<div class="crumb">
						<?php
						if ( function_exists( 'breadcrumb_trail' ) ) {
							breadcrumb_trail( array( 'separator' => '&emsp;&rsaquo;&emsp;', 'before' => '' ) );
						}
						?>
					</div>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
		</div>
		<!-- end header -->
