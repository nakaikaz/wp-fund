<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>

	<section class="container_12">

		<?php get_sidebar(); ?>

		<div id="content" class="grid_8">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'accf' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', get_post_format() );
			}
			?>

			<?php content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'accf' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'accf' ); ?></p>
					<div class="grid_3">
					<?php get_search_form(); ?>
					</div>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->
	</section>

<?php get_footer(); ?>