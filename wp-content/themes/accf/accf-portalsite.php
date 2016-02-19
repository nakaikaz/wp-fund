<?php
/*
Template Name: ＮＰＯポータルサイトページ
*/
$jpg = get_template_directory_uri() . '/images/portal.' . qtrans_getLanguage() . '.jpg';
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
						<p><?php _e( 'We manage NPO Potal Site so that nonprofit organization can interact with businesses and government as well as publicity by nonprofits. ', 'accf' ); ?></p>
						<a href="<?php echo $jpg; ?>" class="fancybox">
						<img src="<?php echo $jpg; ?>" width="620" height="344" alt=""/>
						</a>
						<div class="grid_2" style="margin: 1em 10px 0 0;">
							<a href="http://www.a-npo.org/portal/" class="button" title="<?php _e( 'NPO portal site', 'accf' ); ?>" style="height: 5em; line-height: 5em;"><?php _e( 'NPO portal site', 'accf' ); ?></a>
						</div>
						<div class="grid_6" style="margin: 1em 0 0 10px;">
							<div class="grid_3" style="margin-left: 0;">
								<a href="<?php echo home_url(); ?>/download/portal_agreement.pdf" class="button gray" title="<?php _e( 'Terms of use', 'accf' ); ?>" style="margin-bottom: 1em;"><?php _e( 'Terms of use', 'accf' ); ?></a>
								<a href="<?php echo home_url(); ?>/download/portal_application.pdf" class="button gray" title="<?php _e( 'Application', 'accf' ); ?>"><?php _e( 'Application', 'accf' ); ?></a>
							</div>
							<div class="grid_3" style="margin-left: 0;">
								<a href="<?php echo home_url(); ?>/download/supporter_manual_v1.pdf" class="button gray" title="<?php _e( 'Manual for supporters', 'accf' ); ?>" style="margin-bottom: 1em;"><?php _e( 'Manual for supporters', 'accf' ); ?></a>
								<a href="#" class="button gray" title="<?php _e( 'Coming soon ...', 'accf' ); ?>"><?php _e( 'Coming soon ...', 'accf' ); ?></a>
							</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div><!-- .entry-content -->
				</article>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>