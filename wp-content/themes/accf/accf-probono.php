<?php
/*
Template Name: プロボノ支援ページ
*/
$jpg = get_template_directory_uri() . '/images/probono.' . qtrans_getLanguage() . '.jpg';
get_header( );
?>

		<div class="container_12">

			<?php get_sidebar(); ?>

			<div id="content" class="grid_8">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h2 class="entry-title"><?php the_title(); ?></h2>
					</header>
					<div class="entry-content">
						<p><?php _e( 'In pro bono program, we look for volunteers, who are familliar with IT, accountancy and public relations, among experts and bussiness sectors and provide information of them on NPO Portal Site. This is a system that matches nonprofits with professional skills of for-profit sector.', 'accf' ); ?></p>
						<a href="<?php echo $jpg; ?>" class="fancybox" title="<?php _e( 'Pro bono', 'accf' ); ?>">
							<img src="<?php echo $jpg; ?>" width="620" height="472" alt="<?php _e( 'Pro bono', 'accf' ); ?>"/>
						</a>
						<div class="clear">&nbsp;</div>
					</div><!-- .entry-content -->
				</article>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>