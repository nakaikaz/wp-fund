<?php
/*
Template Name: お問い合わせページ
*/
//wp_enqueue_script( 'jqtransform', get_template_directory_uri() . '/js/jqtransform/jquery.jqtransform.js', array('jquery'), null );
//wp_enqueue_style( 'jqtransform', get_template_directory_uri() . '/js/jqtransform/jqtransform.css', array(), null );
get_header();
?>

		<div class="container_12">

			<?php get_sidebar(); ?>

			<div id="content" class="grid_8">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header>
							<h2><?php the_title(); ?></h2>
							<p><?php _e( 'You can contact us by sending us inquiry using the form below.', 'accf' ); ?></p>
						</header>

						<div>
							<?php the_content(); ?>
						</div>

						<footer>
							<p><?php _e( 'Your information will not be shared with any other outside organiztion, except as part of answering your inquiry or providing news of the foundation.', 'accf' ); ?></p>
						</footer>

					</article><!-- #post -->
				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">

					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'accf' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'accf' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-0 -->

			<?php endif; // end have_posts() check ?>

			</div><!-- #content -->
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>