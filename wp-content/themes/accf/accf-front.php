<?php
/*
Template Name: フロントページ
*/
// shows posts in 'topic' category at top page.
global $post;
$slides = array();

$slidePosts = new WP_Query(array('order' => 'DESC', 'posts_per_page' => 5, 'category_name' => 'slide'));
if ( $slidePosts->have_posts() ) {
    while ( $slidePosts->have_posts() ) {
        $slidePosts->the_post();
        $permalink = get_permalink();
        $image = get_post_meta($post->ID, 'upload_image');
        $slides[] = array('permalink' => $permalink, 'image' => $image[0]);
    }
    wp_reset_postdata();
}
get_header(); ?>

<div class="container_12">

    <?php get_sidebar(); ?>

    <div id="content" class="grid_8">
        <div id="featured">
            <div id="slides">
                <?php foreach( $slides as $slide ) : ?>
                <a href="<?php echo $slide['permalink']; ?>">
                    <img src="<?php echo $slide['image']; ?>" />
                </a>
                <?php endforeach; ?>
            </div>
        </div>

<script>
( function( $ ) {
    $( function() {
        // Slides for the front page
        <?php if ( count($slides) == 0 ) : ?>
        $( '#featured').css('border', '1px dotted #ccc');
        <?php endif; ?>
        $('#slides').css('display', 'none').slidesjs({
            width: 620,
            height: 350,
            effect: { fade: { speed: 1600, crossfade: true } },
            pagination: { active: true, effect: 'fade' },
            navigation: { active: false },
            play: { active: false, effect: 'fade',
                <?php /* 画像が１つより多ければオートスライド */ ?>
                <?php if( count($slides) > 1 ) : ?>
                auto: true,
                <?php else : ?>
                auto: false,
                <?php endif; ?>
                interval: 7000, swap: false, pauseOnHover: true, restartDelay: 5000 }
        });
    });
} )( jQuery );
</script>

<?php
// shows posts in 'topic' category at top page.
$topicPosts = new WP_Query(array('order' => 'DESC', 'posts_per_page' => 1, 'category_name' => 'topic')); ?>
 <?php if ( $topicPosts->have_posts() ) : ?>

    <?php while ( $topicPosts->have_posts() ) : $topicPosts->the_post(); ?>
        <?php get_template_part('content', 'topic'); ?>
    <?php endwhile; ?>

<?php endif; ?>

    </div><!-- /#content -->
    <div style="clear: both;"></div>
</div>
<?php get_footer();
