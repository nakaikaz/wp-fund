<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>

	<div class="container_12">

		<?php get_sidebar(); ?>

		<div id="content" class="grid_8">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- .container_12 -->

<?php get_footer(); ?>