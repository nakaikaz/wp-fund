<?php
$page = get_page(get_the_ID());
if(isset($page->post_name)){
  $slug = $page->post_name;
}
// トップページに表示する「最新のニュース」の件数
$latestNewsNum = get_option('latest_news_num');
?>
<div id="sidebar-wrap" class="grid_4">
    <div id="sidebar">
        <ul>
            <li id="text_4" class="widget widget_text">
                <div class="box">
                    <div class="textwidget">
                        <div style="text-align: center;">
                            <a href="<?php echo home_url_qtrans(); ?>/givingmarket">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/market-project.gif" alt="寄付の市場" width="300" />
                            </a>
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </li>
            <li id="text_3" class="widget widget_text">
                <div class="box">
                    <div class="textwidget">
                    <?php
                    if(isset($slug) && ('givingmarket' == $slug || 'memberstores' == $slug) ) :
                        wp_nav_menu(array('menu' => 'givingmarket', 'container' => false, 'menu_class' => 'menu bigbutton givingmarket'));
                    else :
                        wp_nav_menu(array('theme_location' => 'sidebar', 'container' => false, 'menu_class' => 'menu bigbutton'));
                    endif;
                    ?>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </li>
            <li id="text_5" class="widget widget_text">
                <div class="box social">
                    <div class="textwidget">
                        <a href="https://www.facebook.com/aoimori.community.fund">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/facebook.gif" alt="facebook" height="50"/>
                        </a>
                        <a href="<?php bloginfo('rss2_url');?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/rss_subscribe.gif" alt="subscribe" height="50" />
                        </a>
                    </div>
                </div>
            </li>
            <li id="blog-posts" class="wideget">
                <div class="box">
                    <h2><?php _e('Latest News', 'accf'); ?></h2>
                    <div class="recent-posts">
                        <?php
                        $latestPosts = new WP_Query(array('order' => 'DESC', 'posts_per_page' => $latestNewsNum));
                        if( $latestPosts->have_posts() ) : ?>
                            <ul>
                            <?php while ($latestPosts->have_posts() ) : $latestPosts->the_post(); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile; wp_reset_postdata(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </li>
        </ul>
    </div>
</div>
