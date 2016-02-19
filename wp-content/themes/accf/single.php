<?php
/**
 * The Template for displaying all single posts.
 *
 * No one can not put comments on a single post! Because we wouldn't answer them properly, would it?
 *
 */

get_header(); ?>

	<div class="container_12">

		<?php get_sidebar( ); ?>

		<div id="content" class="grid_8">

			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', get_post_format() );
			}
			?>

		</div>

	</div>

<?php get_footer(); ?>