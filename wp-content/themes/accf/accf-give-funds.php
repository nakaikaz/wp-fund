<?php
/*
Template Name: 寄付と基金ページ
 */
$language = qtrans_getLanguage();
get_header( );
?>

        <div class="container_12">

            <?php get_sidebar(); ?>

            <div id="content" class="grid_8">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><?php the_title(); ?></h2>
                    </header>
                    <div class="entry-content">
                        <div class="box grid_2" style="margin:1em 0 .5em 0;padding: 1em 0 .5em 0;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/give-funds.<?php echo $language; ?>.gif" width="100" height="100" alt="<?php _e( 'Give & Fund', 'accf' ); ?>" style="margin: 0;"/>
                        </div>
                        <div class="box grid_6" style="margin:1em 0 .5em 0;padding: 1em 0 .5em 0;">
                            <p><?php _e( 'The purpose of fund is to ensure that donors who want to support nonprofit organizations can be matched to proper ones.', 'accf' ); ?></p>
                        </div>
                        <div class="clear">&nbsp;</div>

                        <div class="box grid_2" style="margin:.5em 0;padding: 0;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/4themes.<?php echo $language; ?>.gif" width="100" height="100" alt="<?php _e( '4 themes', 'accf' ); ?>" style="margin: 0;"/>
                        </div>
                        <div class="box grid_6" style="margin:.5em 0;padding: 0;">
                            <ul>
                                <li><?php _e( 'Activity to give children better educational environments', 'accf' ); ?></li>
                                <li><?php _e( 'Activity to solve local issues', 'accf' ); ?></li>
                                <li><?php _e( 'Activity to raise level of well-being of Aomori prefecture', 'accf' ); ?></li>
                                <li><?php _e( 'Activity to encourage people to live in Aomori prefecture', 'accf' ); ?></li>
                            </ul>
                        </div>
                        <div class="clear">&nbsp;</div>

                        <div class="box grid_2" style="margin:.5em 0;padding: 0;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/community-fund.<?php echo $language; ?>.gif" width="100" height="100" alt="<?php _e( 'Aoimori Community Fund', 'accf' ); ?>" style="margin: 0;"/>
                        </div>
                        <div class="box grid_6" style="margin:.5em 0;padding: 0;">
                            <p><?php _e( 'We named the fund "Aoimori Community Fund" which aims to renew civil society in Aomori prefecture by people\'s philanthropic mind. "Aoimori Community Fund" is the general term of grants and endowments which Aoimori Creative Community Fund manages.', 'accf' ); ?></p>
                        </div>
                        <div class="clear">&nbsp;</div>

                        <div class="box grid_2" style="margin:.5em 0;padding: 0;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/grants.<?php echo $language; ?>.gif" width="100" height="100" alt="<?php _e( 'Grants', 'accf' ); ?>" style="margin: 0;"/>
                        </div>
                        <div class="box grid_6" style="margin:.5em 0;padding: 0;">
                            <p><?php _e( 'Aoimori Community Fund provides nonprofit organizations with supports and grants on 4 themes the Fund advocates.', 'accf' ); ?></p>
                        </div>
                        <div class="clear">&nbsp;</div>

                        <div class="box" style="margin-bottom: 0; padding-bottom: 0;">
                            <a href="<?php echo get_template_directory_uri(); ?>/images/contribution_fig.<?php echo $language; ?>.jpg" class="fancybox">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/contribution_fig.<?php echo $language; ?>.jpg" width="620" height="529" alt=""/>
                            </a>
                        </div>

                    </div><!-- .entry-content -->
                    <footer class="entry-meta"></footer>

                </article>
            </div>
            <div style="clear: both;"></div>
        </div>
<?php get_footer(); ?>
