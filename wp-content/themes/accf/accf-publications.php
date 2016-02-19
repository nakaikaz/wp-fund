<?php
/*
Template Name: 開示情報ページ
*/
global $post;
$attachments = get_posts( array(
    'numberposts' => -1,
    'post_type' => 'attachment',
    'post_mime_type' => 'application/pdf',
    'mediacategory' => 'annualreport',
) );
get_header( 'front' );
?>

        <div class="container_12">
            <!-- begin sidebar -->
            <?php get_sidebar( 'front' ); ?>
            <!-- end sidebar -->
            <div id="content" class="grid_8">
                <div class="entry">
                    <h2>開示情報</h2>
                    <h3>報告書</h3>
                    <ul class="no_list_style bottom_line_ccc">
                        <?php if( $attachments ) : ?>
                            <?php foreach( $attachments as $attachment ) : ?>
                            <li>
                                <dl style="line-height: 3.1">
                                    <dt style="width: 400px; line-height: 3.1">
                                        <a href="<?php echo $attachment->guid; ?>">
                                            <?php echo $attachment->post_title; ?>
                                        </a>
                                    </dt>
                                    <dd style="width: 32px; line-height: 3.1">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/pdficon_large.png" style="margin: 0;"/>
                                    </dd>
                                </dl>
                            </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                        <li style="line-height:3.1">報告書のデータがありません</li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
<?php get_footer('front'); ?>
