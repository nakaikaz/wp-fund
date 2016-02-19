<?php
/*
Template Name: 応援メッセージページ
*/
get_header();
?>

        <div class="container_12">

            <?php get_sidebar(); ?>

            <div id="content" class="grid_8">
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h2><?php the_title(); ?></h2>
                    </header>

                    <div class="entry">
                        <p>基金設立時に、２０３名、社、団体 の方々から応援を頂いております。ありがとうございました！</p>
                        <?php
                        global $wpdb;
                        $donors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}donor_table" );
                        if( $donors ) : ?>
                        <ul class="no_list_style bottom_line_ccc padding_10_0">
                            <?php foreach( $donors as $donor ) : ?>
                            <li>
                                <div class="grid_2"><?php echo stripslashes( $donor->address ); ?></div>
                                <div class="grid_2" style="margin-left: 0; margin-right: 0;"><?php echo stripslashes( $donor->name ); ?></div>
                                <div class="grid_4"><?php echo stripslashes( $donor->message ); ?></div>
                                <div class="clear">&nbsp;</div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>

                    </div>

                    <footer>
                        <p></p>
                    </footer>

                </article><!-- #post -->

            <?php endwhile; // end of the loop. ?>
            </div>
            <div style="clear: both;"></div>
        </div>
<?php get_footer(); ?>
