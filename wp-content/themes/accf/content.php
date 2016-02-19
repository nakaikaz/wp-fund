<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<div class="post-entries">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'accf' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php the_post_thumbnail(); ?>
			<?php if ( is_single() ) : ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php else : ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'accf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h2>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'accf' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'accf' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php entry_meta(); ?>
		</footer><!-- .entry-meta -->

	</article><!-- #post -->

</div><!-- .post-entries -->