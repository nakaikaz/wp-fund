<?php
/**
 * The default template for displaying content. Used for both topic category.
 */
?>
<div id="topic" class="post-entries">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
            <?php the_post_thumbnail(); ?>
                <h2 class="entry-title"><?php the_title(); ?></h2>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'accf' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'accf' ), 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->

    </article><!-- #post -->

</div><!-- .post-entries -->
