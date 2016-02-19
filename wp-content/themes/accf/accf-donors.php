<?php
/*
Template Name: 寄付者一覧ページ
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
                        <p>応援署名のみの方も含みます。（匿名希望の方は、匿名希望　様と表示しています。）</p>
                        <?php
                        global $wpdb;
                        $per_page = 10;
                        $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}donor_table WHERE initial=0" );
                        //$paged = isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 0;
                        $paged = get_query_var( 'paged' );
                        if( !is_numeric( $paged ) || $paged < 1 ) $paged = 1;
                        $total_pages = ceil( $total_items / $per_page );
                        $offset = ( $paged - 1 ) * $per_page;
                        $donors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}donor_table WHERE initial=0 LIMIT {$offset}, {$per_page}" );
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

            <?php /* ナビゲーション */
            donor_nav( $total_pages );
            ?>

            <?php endwhile; // end of the loop. ?>

            </div>
            <div style="clear: both;"></div>
        </div>
<?php get_footer(); ?>
