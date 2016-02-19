<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'accf' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<footer class="entry-meta">
			<?php
			if ( is_user_logged_in() ) {
				edit_post_link( __( 'Edit', 'accf' ), '<span class="edit-link">', '</span>' );
			}
			?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->