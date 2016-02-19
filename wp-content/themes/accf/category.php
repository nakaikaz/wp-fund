<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 */

get_header(); ?>

	<section class="container_12">

		<?php get_sidebar( ); ?>

		<div id="content" class="grid_8">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', get_post_format() );
			}

			content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->

	</section><!-- .container_12 -->

<?php get_footer(); ?>