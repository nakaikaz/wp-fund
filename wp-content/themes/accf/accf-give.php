<?php
/*
Template Name: 寄付をするページ
*/
//wp_enqueue_script( 'jqtransform', get_template_directory_uri() . '/js/jqtransform/jquery.jqtransform.js', array('jquery'), null );
//wp_enqueue_style( 'jqtransform', get_template_directory_uri() . '/js/jqtransform/jqtransform.css', array(), null );
get_header( );
?>

        <div class="container_12">

            <?php get_sidebar( ); ?>

            <div id="content" class="grid_8">

                <div class="post-entries">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <header class="entry-header">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <p><?php _e( 'The civic foundation depends entirely on contributions from residents and businesses to fund the civil activities.', 'accf' ); ?></p>
                            <p><?php _e( 'By making an one-off donation, with which you let us decide what to fund, you can enrich our community.', 'accf' ); ?></p>

                            <form action="https://credit.j-payment.co.jp/gateway/payform.aspx" method="POST">
                                <input type="hidden" name="aid" value="105988" />
                                <input type="hidden" name="pt" value="1" />
                                <div class="rowElem">
                                    <div class="innerRow">
                                        <label for="iid"><?php _e( 'Amount: ', 'accf' ); ?></label>
                                        <select name="iid">
                                        <option value="d003000"><?php _e( '3,000 yen', 'accf' ); ?></option>
                                        <option value="d005000"><?php _e( '5,000 yen', 'accf' ); ?></option>
                                        <option value="d010000"><?php _e( '10,000 yen', 'accf' ); ?></option>
                                        <option value="d030000"><?php _e( '30,000 yen', 'accf' ); ?></option>
                                        <option value="d050000"><?php _e( '50,000 yen', 'accf' ); ?></option>
                                        <option value="d100000"><?php _e( '100,000 yen', 'accf' ); ?></option>
                                        </select>
                                        <input type="submit" name="submit" value="<?php _e( 'Donate Now!', 'accf' ); ?>" />
                                    </div>
                                </div>
                            </form>
                            <p style="text-align: center;"><?php _e( 'Available cards are listed below:', 'accf'); ?></p>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/cards.gif" style="display:  block; margin: 0 auto 1em; text-align: center;"/>
                            <p style="text-align: center; margin-top: 1em;"><?php _e( 'Aoimori Community Fund uses the online-payment system of J-Payment inc.', 'accf' ); ?></p>
                        </div><!-- .entry-content -->

                        <footer class="entry-meta">
                        </footer><!-- .entry-meta -->

                    </article><!-- #post -->

                </div><!-- .post-entries -->

            </div>
            <div style="clear: both;"></div>
        </div>
<?php get_footer(); ?>
