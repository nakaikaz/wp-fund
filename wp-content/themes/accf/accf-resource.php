<?php
/*
Template Name: 資源提供ページ
*/
$jpg = get_template_directory_uri() . '/images/resource.' . qtrans_getLanguage() . '.jpg';
get_header( );
?>

		<div class="container_12">

			<?php get_sidebar(  ); ?>

			<div id="content" class="grid_8">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h2 class="entry-title"><?php the_title(); ?></h2>
					</header>
					<div class="entry-content">
						<p><?php _e( 'In resource endowment program, we look for unused tables, chairs, lockers and white boards in business sectors and provide information of them on NPO Portal Site. This is a system that matches nonprofits that want office products with business sectors that can provide them.', 'accf' ); ?></p>
						<a href="<?php echo $jpg; ?>" class="fancybox" title="<?php _e( 'Resource endowment', 'accf' ); ?>">
							<img src="<?php echo $jpg; ?>" width="620" height="472" alt="<?php _e( 'Resource endowment', 'accf' ); ?>"/>
						</a>
						<div class="clear">&nbsp;</div>
					</div><!-- .entry-content -->
				</article>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>