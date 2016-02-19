<?php
/**
 * Sets up theme defaults and registers the various WordPress features that
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support()
 * To add support for post thumbnails, automatic feed links and menu.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 */


if ( ! isset($content_width) ) $content_width = 620;

function after_setup_theme_func()
{

    // 言語ファイルで多言語化
    load_theme_textdomain('accf', get_template_directory() . '/languages');

    // ヴィジュアルエディタ使用
    add_editor_style();

    // メニューサポート
    add_theme_support('menu');

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme supports a variety of post formats.
    /*add_theme_support(
        'post-formats',
        array('aside', 'image', 'link', 'quote', 'status')
    );*/

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', __('Global navigation', 'accf'));
    register_nav_menu('sidebar', __('Side menu', 'accf'));

    // This theme uses a custom image size for featured images,
    // displayed on "standard" posts.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(620, 9999); // Unlimited height, soft crop
}
add_action('after_setup_theme', 'after_setup_theme_func');


/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function accf_scripts_styles() {
    global $wp_styles;

    /*
     * Loads our special font CSS file.
     *
     * The use of Open Sans by default is localized. For languages that use
     * characters not supported by the font, the font can be disabled.
     *
     * To disable in a child theme, use wp_dequeue_style()
     * function mytheme_dequeue_fonts() {
     *     wp_dequeue_style( 'twentytwelve-fonts' );
     * }
     * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
     */

    /* If there are characters in your language that are not supported
        by Open Sans, translate this to 'off'. Do not translate into your
        own language. */
    if ('off' !== _x('on', 'Open Sans font: on or off', 'accf') ) {
        $subsets = 'latin,latin-ext';

        /* To add an additional Open Sans character subset specific to your
            language, translate this to 'greek', 'cyrillic' or 'vietnamese'.
            Do not translate into your own language. */
        $subset = _x(
            'no-subset',
            'Open Sans font: add new subset (greek, cyrillic, vietnamese)',
            'accf'
        );

        if ( 'cyrillic' == $subset )
            $subsets .= ',cyrillic,cyrillic-ext';
        elseif ( 'greek' == $subset )
            $subsets .= ',greek,greek-ext';
        elseif ( 'vietnamese' == $subset )
            $subsets .= ',vietnamese';

        $protocol = is_ssl() ? 'https' : 'http';
        $query_args = array(
            'family' => 'Open+Sans:400italic,700italic,400,700',
            'subset' => $subsets,
        );
        wp_enqueue_style(
            'accf-fonts',
            add_query_arg($query_args, "$protocol://fonts.googleapis.com/css"),
            array(),
            null
        );
    }

    /*
     * Loads our main stylesheet.
     */
    wp_enqueue_style('accf-style', get_stylesheet_uri());

    /*
     * Loads the Internet Explorer specific stylesheet.
     */
    wp_enqueue_style(
        'accf-ie',
        get_template_directory_uri() . '/css/ie.css',
        array('accf-style'),
        '20121010'
    );
    $wp_styles->add_data('accf-ie', 'conditional', 'lt IE 9');
}
add_action('wp_enqueue_scripts', 'accf_scripts_styles');


/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 */
function page_menu_args($args) {
    if ( ! isset( $args['show_home'] ) )
        $args['show_home'] = true;
    return $args;
}
add_filter('wp_page_menu_args', 'page_menu_args');

/**
 * Registers our main widget area and the front page widget areas.
 */
function accf_widgets_init() {
    register_sidebar(
        array(
            'name' => __('Main Sidebar', 'accf'),
            'id' => 'sidebar-1',
            'description' => __('Appears on posts and pages except the optional Front Page template, which has its own widgets', 'accf'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name' => __('First Front Page Widget Area', 'accf'),
            'id' => 'sidebar-2',
            'description' => __('Appears when using the optional Front Page template with a page set as Static Front Page', 'accf'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name' => __('Second Front Page Widget Area', 'accf'),
            'id' => 'sidebar-3',
            'description' => __('Appears when using the optional Front Page template with a page set as Static Front Page', 'accf'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action('widgets_init', 'accf_widgets_init');

if ( ! function_exists( 'content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 */
function content_nav($html_id) {
    global $wp_query;

    $html_id = esc_attr($html_id);

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
            <div class="nav-previous alignleft"><?php next_posts_link( __('<span class="meta-nav">&larr;</span> Older posts', 'accf') ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link( __('Newer posts <span class="meta-nav">&rarr;</span>', 'accf') ); ?></div>
        </nav><!-- #<?php echo $html_id; ?> .navigation -->
    <?php endif;
}
endif;

if ( ! function_exists('comment_html') ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own comment_html(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function comment_html($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e('Pingback:', 'accf'); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __('(Edit)', 'accf'), '<span class="edit-link">', '</span>'); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <header class="comment-meta comment-author vcard">
                <?php
                    echo get_avatar($comment, 44);
                    printf(
                        '<cite class="fn">%1$s %2$s</cite>',
                        get_comment_author_link(),
                        // If current post author is also comment author, make it known visually.
                        ($comment->user_id === $post->post_author) ? '<span> ' . __('Post author', 'accf') . '</span>' : ''
                    );
                    printf(
                        '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                        esc_url(get_comment_link( $comment->comment_ID )),
                        get_comment_time('c'),
                        /* translators: 1: date, 2: time */
                        sprintf(__('%1$s at %2$s', 'accf'), get_comment_date(), get_comment_time())
                    );
                ?>
            </header><!-- .comment-meta -->

            <?php if ('0' == $comment->comment_approved) : ?>
                <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'accf'); ?></p>
            <?php endif; ?>

            <section class="comment-content comment">
                <?php comment_text(); ?>
                <?php edit_comment_link(__('Edit', 'accf'), '<p class="edit-link">', '</p>'); ?>
            </section><!-- .comment-content -->

            <div class="reply">
                <?php comment_reply_link( array_merge($args, array('reply_text' => __('Reply', 'accf'), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
    <?php
            break;
    endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own entry_meta() to override in a child theme.
 *
 */
function entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'accf' ) );

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( ', ', 'accf' ) );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_date() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
    if ( $tag_list ) {
        $utility_text = __( 'Posted on %3$s<br />Filed under %1$s<br />Tagged under %2$s', 'accf' );
    } elseif ( $categories_list ) {
        $utility_text = __( 'Posted on %3$s<br />Filed under %1$s', 'accf' );
    } else {
        $utility_text = __( 'Posted on %3$s', 'accf' );
    }

    printf(
        $utility_text,
        $categories_list,
        $tag_list,
        $date
    );
}
endif;


/**
 * カスタム投稿タイプ
 */
define( 'USE_TAXONOMY', true );
function create_custom_post_type() {
    register_post_type( 'featured',
        array(
            'label' => 'フィーチャー',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'rewrite' => true,
            'hierarchical' => false,
            'has_archive' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'author', 'trackbacks', 'revisions', 'page-attributes' )
        )
    );
    /*register_taxonomy( 'featured_category', 'featured',
        array(
            'hierarchical' => true,
            'label' => 'フィーチャーカテゴリ',
            'public' => true
        )
    );*/
}
add_action( 'init', 'create_custom_post_type' );

/**
 * customize search form
 * @author nakai
 */
function replace_search_form( $form ) {
    $action = home_url( '/' );
    $search_query = get_search_query();
    $search = esc_attr__('Search');
    $title = __( 'Type a search term', 'accf' );
    $form =<<<FORM
<form method="get" id="searchform" action="{$action}" >
    <input type="text" value="{$search_query}" name="s" id="s" style="width: 140px;" size="35" title="{$title}" class="text"/>
    <input type="submit" id="searchsubmit" class="submit" value="{$search}" />
 </form>
FORM;
    return $form;
}

add_filter( 'get_search_form', 'replace_search_form' );

/**
 * redirect /files/seminars to /files.
 * @author nakai
 */
function redirect() {
    $blogurl = home_url();
    $url = $blogurl . get_permalink();
    if( preg_match('/\/files\/(seminars|materials|reports|standardaccountancy)$/', $url) ){
        wp_redirect( $blogurl . '/files' );
        exit;
    }
    if( preg_match( '/\/about$/', $url ) ) {
        wp_redirect( $blogurl . '/about/organization');
        exit;
    }
    if ( preg_match('/\/voices$/', $url ) ) {
        wp_redirect( $blogurl . '/voices/initialdonors' );
        exit;
    }
}
add_action('template_redirect', 'redirect');

class Media_Category {

    public function __construct() {
        add_action( 'init', array( &$this, 'register_taxonomy_handler' ) );
        //add_action( 'admin_menu', array( &$this, 'add_media_taxonomy_handler' ) );
        //add_filter( 'attachment_fields_to_edit', array( &$this, 'replace_attachment_taxonomy_input_to_check' ), 100, 2 );
        //add_action( 'load-media.php', array( &$this, 'join_media_taxonomy_datas' ) );
    }

    public function register_taxonomy_handler() {
        $labels = array(
            'name' => 'メディアカテゴリー',
            'singular_name' => 'メディアカテゴリー',
            'search_items' => 'メディアカテゴリーで探す',
            'all_items' => '全てのメディアカテゴリー',
            'parent_item' => '',
            'parent_item_colon' => '',
            'edit_item' => 'メディアカテゴリーの編集',
            'update_item' => 'メディアカテゴリーを更新',
            'add_new_item' => 'メディアカテゴリーを追加',
            'new_item_name' => '新規メディアカテゴリー名',
        );

        register_taxonomy(
            'mediacategory',
            'attachment',
            array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'mediacategory',
                ),
            )
        );
    }

    /*public function add_media_taxonomy_handler() {
        global $wp_taxonomies, $submenu;
        $media_taxonomies = array();
        if( $wp_taxonomies ) {
            foreach( $wp_taxonomies as $key => $obj ) {
                if( count( $obj->object_type ) == 1 && $obj->object_type[0] == 'attachment' && $obj->show_ui ) {
                    $media_taxonomies[$key] = $obj;
                }
            }
        }

        if( $media_taxonomies ) {
            $priority = 50;
            foreach( $media_taxonomies as $key => $media_taxonomy ) {
                if( current_user_can( $media_taxonomy->cap->manage_terms ) ) {
                    $submenu['upload.php'][$priority] = array( $media_taxonomy->labels->menu_name, 'upload_files', 'edit-tags.php?taxonomy=' . $key );
                    $priority += 5;
                }
            }
        }
    }*/

    /*public function replace_attachment_taxonomy_input_to_check( $fields, $post ) {
        if( $fields ) {
            foreach( $fields as $taxonomy => $obj ) {
                if( isset( $obj['hierarchical'] ) && $obj['hierarchical'] ) {
                    $terms = get_terms( $taxonomy, array( 'get' => 'all' ) );
                    $taxonomy_tree = array();
                    $branches = array();
                    $term_ids = array();
                    foreach( $terms as $term ) {
                        $term_ids[$term->term_id] = $term;
                        if( $term->parent == 0 ) {
                            $taxonomy_tree[$term->term_id] = array();
                        } else {
                            $branches[$term->parent][$term->term_id] = array();
                        }
                    }

                    if( count( $branches ) ) {
                        foreach( $branches as $foundation => $branch ) {
                            foreach( $branches as $branch_key => $val ) {
                                if( array_key_exists( $foundation, $val ) ) {
                                    $branches[$branch_key][$foundation] = &$branches[$foundation];
                                }
                            }
                        }
                        foreach( $branches as $foundation => $branch ) {
                            if( isset( $taxonomy_tree[$foundation] ) ) {
                                $taxonomy_tree[$foundation] = $branch;
                            }
                        }
                    }

                    $html = $this->walker_media_taxonomy_html( $post->ID, $taxonomy, $term_ids, $taxonomy_tree );
                    $fields[$taxonomy]['input'] = 'checkbox';
                    $fields[$taxonomy]['checkbox'] = $html;
                }
            }
        }
        return $fields;
    }*/


    /*public function walker_media_taxonomy_html( $post_id, $taxonomy, $term_ids, $taxonomy_tree, $html = '', $cnt = 0 ) {
        foreach( $taxonomy_tree as $term_id => $arr ) {
            $checked = is_object_in_term( $post_id, $taxonomy, $term_id ) ? ' checked="checked"' : '';
            $html .= str_repeat( '?', count( get_ancestors( $term_id, $taxonomy ) ) );
            $html .= ' <input type="checkbox" id="attachments[' . $post_id . '][' . $taxonomy . ']-' . $cnt . '" name="attachments[' . $post_id . '][' .
                $taxonomy . '][]" value="' . $term_ids[$term_id]->name . '"' . $checked . ' /><label for="attachments[' . $post_id . '][' . $taxonomy . ']-' . $cnt . '">' . $term_ids[$term_id]->name. "</label><br />";
            $cnt++;
            if( count( $arr ) ) {
                $html = walker_media_taxonomy_html( $post_id, $taxonomy, $term_ids, $arr, $html, &$cnt );
            }
        }
        return $html;
    }*/

    /*public function join_media_taxonomy_datas() {
        global $wp_taxonomies;
        if( $_POST['action'] != 'editattachment' )
            return;
        $attachment_id = (int)$_POST['attachment_id'];
        $media_taxonomies = array();
        if( $wp_taxonomies ) {
            foreach( $wp_taxonomies as $key => $obj ) {
                if( count( $obj->object_type ) == 1 && $obj->object_type[0] == 'attachment' ) {
                    $media_taxonomies[$key] = $obj;
                }
            }
        }
        if( $media_taxonomies ) {
            foreach( $media_taxonomies as $key => $media_taxonomy ) {
                if( isset( $_POST['attachments'][$attachment_id][$key] ) ) {
                    if( is_array( $_POSt['attachments'][$attachment_id][$key] ) ) {
                        $_POST['attachment'][$attachment_id][$key] = implode( ', ', $_POST['attachments'][$attachment_id][$key] );
                    }
                }else{
                    $_POST['attachments'][$attachment_id][$key] = '';
                }
            }
        }
    }*/

}

new Media_Category;

include 'inc/setting.php';
include 'inc/image_meta_box.php';
include 'inc/init.php';

/**
 * Returns qtranslated home uri if qTranslate plugin is activated
 * @return string home uri
 */
if ( !function_exists( 'qtrans_convertURL' ) || !function_exists( 'qtrans_getLanguage' ) ) :
function home_url_qtrans() {
    return home_url();
}
else:
function home_url_qtrans() {
    return qtrans_convertURL( home_url(), qtrans_getLanguage() );
}
endif;


include 'donor-table/donor-table.php';

function donor_nav( $total_pages ) {
if ( $total_pages > 1 ) : ?>
<nav id="donor-nav" class="navigation">
    <div class="nav-previous alignleft">
        <?php echo Donor\get_previous_posts_link( '<span class="meta-nav">&larr;</span> 前' ); ?>
    </div>
    <div class="nav-next alignright">
        <?php echo Donor\get_next_posts_link( '次 <span class="meta-nav">&rarr;</span>', $total_pages ) ; ?>
    </div>
</nav><!-- .navigation -->
<?php endif;
}


/**
 * Creates English title if the locale is en_US
 * @return string the title of the web site
 */
function wp_title_filter() {
    $theTitle = get_the_title();
    $baseTitle = __('Aoimori Community Fund', 'accf');
    if( is_front_page() )
        return $baseTitle;
    elseif( $theTitle )
        return $theTitle . '｜' . $baseTitle;
    else
        return $baseTitle;
}
add_filter('wp_title', 'wp_title_filter');

/**
 * must be confirmed if email address is valid!
 */
define('EMAIL_IS_UNMATCH', '確認用のメールアドレスが一致していません');
function wpcf7_text_validation_filter_extend($result, $tag) {
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim(strtr((string)$_POST[$name], "\n", " "));
    if ( 'email' == $type || 'email*' == $type ) {
        if (preg_match('/(.*)_for_check$/', $name, $matches)) {
            $targetName = $matches[1];
            if ($_POST[$name] != $_POST[$targetName]) {
                $result['valid'] = false;
                $result['reason'][$name] = EMAIL_IS_UNMATCH;
            }
        }
    }
    return $result;
}
add_filter('wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2);


