<?php
/**
 * 固定ページ、カテゴリの作成、寄付者テーブルに設立時寄付者を登録
 */
class Init_Proc {

    const VERSION = '1.0';
    const PAGE_NAME = 'accf-init';
    const OPTION_NAME = 'accf-init-proc';

    public function __construct() {
        add_action( 'admin_menu', array( &$this, 'add_menu_page_handler') );
        add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts_handler' ) );
    }

    public function add_menu_page_handler() {
        add_menu_page( '初期化処理', '初期化処理', 'level_10', self::PAGE_NAME, array( &$this, 'init_handler' ) );
    }

    public function enqueue_scripts_handler() {
        global $pagenow;
        if( isset( $_GET['page'] ) && self::PAGE_NAME != $_GET['page'] ) {
            return;
        }
        add_action( 'admin_head', array( &$this, 'ajax_handler' ) );
    }

    public function ajax_handler() {
?>

<div class="wrap">
<p>お待ち下さい。</p>
<img src="<?php echo get_template_directory(); ?>/images/ajax-loader.gif"/>
</div>
        <script>
        jQuery( document ).ready( function() {
            ( function( $ ) {
                var param = {};
                $.post( ajaxurl, param, function(){
                } );
            } )( jQuery );
        } );
        </script>
<?php
    }

    public function init_handler() {
?>
<?php
        if( isset( $_GET['page'] ) && self::PAGE_NAME == $_GET['page'] ) {
            $version = get_option( self::OPTION_NAME, 0 );
            if( self::VERSION != $version ) {
                $this->create_categories();
                $this->create_pages();
                $this->init_options();
                $donor_table = new Donor_Table;
                $donor_table->insert_donor_list();
                update_option( self::OPTION_NAME, self::VERSION );
            }
        }
    }

    function init_options() {
        update_option( 'blogdescription', 'あなたの想いを届ける仕組み' );  // キャッチフレーズ
        update_option( 'permalink_structure' , '/%postname%' );     // パーマリンク
        update_option( 'default_comment_status', 'closed' );            // 投稿へのコメント
        update_option( 'show_on_front', 'page' );                           // フロントページの表示
        $page = get_page_by_title( 'Home' );
        update_option( 'page_on_front', $page-ID );                     // フロントページ
        $page = get_page_by_title( 'News' );
        update_option( 'page_for_posts', $page->ID );                   // 投稿ページ
        update_option( 'posts_per_page', 5 );                               // 1ページに表示する最大投稿数
    }

    function create_pages() {
        $post_names = array();
        $pages = get_pages( array( 'sort_column' => 'ID', 'sort_order' => 'ASC' ) );
        foreach( $pages as $page ) {
            $post_names[] = $page->post_name;
        }
        // ホーム
        if( !in_array( 'home', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->ホーム<!--:--><!--:en-->Home<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'home',
                'post_type' => 'page',
                'menu_order' => 0
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-front.php' );
        }
        // 組織
        if( !in_array( 'about', $post_names ) )
            $about_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->組織<!--:--><!--:en-->About<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'about',
                'post_type' => 'page',
                'menu_order' => 10
            ) );
        if( !in_array( 'organization', $post_names ) ) {
            require_once 'contents/organization.php';
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->法人情報<!--:--><!--:en-->Organization<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $about_id,
                'post_content' => Contents\ORGANIZATION,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'organization',
                'post_type' => 'page',
                'menu_order' => 11
            ) );
        }
        if( !in_array( 'background', $post_names ) ) {
            require_once 'contents/background.php';
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->設立の背景<!--:--><!--:en-->Background<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $about_id,
                'post_content' => Contents\BACKGROUND,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'background',
                'post_type' => 'page',
                'menu_order' => 12
            ) );
        }
        if( !in_array( 'executive', $post_names) ) {
            require_once 'contents/executive.php';
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->理事、監事、評議員<!--:--><!--:en-->Executive<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $about_id,
                'post_content' => Contents\EXECUTIVE,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'executive',
                'post_type' => 'page',
                'menu_order' => 13
            ) );
        }
        if( !in_array( 'publications', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->開示情報<!--:--><!--:en-->Publications<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $about_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'publications',
                'post_type' => 'page',
                'menu_order' => 14
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-publications.php' );
        }
        if( !in_array( 'access', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->アクセス<!--:--><!--:en-->Access<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $about_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'access',
                'post_type' => 'page',
                'menu_order' => 15
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-access.php' );
        }
        // 事業
        if( !in_array( 'programs', $post_names ) ) {
            $programs_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->事業<!--:--><!--:en-->Programs<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'programs',
                'post_type' => 'page',
                'menu_order' => 20
            ) );
            add_post_meta( $programs_id, '_wp_page_template', 'accf-programs.php' );
        }
        if( !in_array( 'give-funds', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->寄付と基金<!--:--><!--:en-->Give & Fund<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $programs_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'give-funds',
                'post_type' => 'page',
                'menu_order' => 21
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-give-funds.php' );
        }
        if( !in_array( 'grants', $post_names ) )
            require_once 'contents/grants.php';
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->助成支援<!--:--><!--:en-->Grants<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $programs_id,
                'post_content' => Contents\GRANTS,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'grants',
                'post_type' => 'page',
                'menu_order' => 22
            ) );
        if( !in_array( 'portalsite', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->ＮＰＯポータルサイト<!--:--><!--:en-->NPO portal site<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $programs_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'portalsite',
                'post_type' => 'page',
                'menu_order' => 23
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-portalsite.php' );
        }
        if( !in_array( 'probono', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->プロボノ支援<!--:--><!--:en-->Pro bono<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $programs_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'probono',
                'post_type' => 'page',
                'menu_order' => 24
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-probono.php' );
        }
        if( !in_array( 'resource', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->資源提供<!--:--><!--:en-->Resource<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $programs_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'resource',
                'post_type' => 'page',
                'menu_order' => 25
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-resource.php' );
        }
        // 資料一覧
        if( !in_array( 'files', $post_names ) ) {
            $files_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->資料一覧<!--:--><!--:en-->Files<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'files',
                'post_type' => 'page',
                'menu_order' => 30
            ) );
            add_post_meta( $files_id, '_wp_page_template', 'accf-files.php' );
        }
        if( !in_array( 'seminars', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->セミナー<!--:--><!--:en-->Seminars<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $files_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'seminars',
                'post_type' => 'page',
                'menu_order' => 31
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-files.php' );
        }
        if( !in_array( 'materials', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->テキスト等<!--:--><!--:en-->Materials<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $files_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'materials',
                'post_type' => 'page',
                'menu_order' => 32
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-files.php' );
        }
        if( !in_array( 'reports', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->調査報告書等<!--:--><!--:en-->Reports<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $files_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'reports',
                'post_type' => 'page',
                'menu_order' => 33
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-files.php' );
        }
        if( !in_array( 'standardaccountancy', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->ＮＰＯ法人会計基準<!--:--><!--:en-->Accounting standards<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $files_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'accountingstandards',
                'post_type' => 'page',
                'menu_order' => 34
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-files.php' );
        }
        // 寄付をする
        if( !in_array( 'give', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->寄付をする<!--:--><!--:en-->Give<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'give',
                'post_type' => 'page',
                'menu_order' => 40
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-give.php' );
        }
        // 応援メッセージ
        if( !in_array( 'yourvoices', $post_names ) ) {
            $voices_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->応援メッセージ<!--:--><!--:en-->Voices<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'voices',
                'post_type' => 'page',
                'menu_order' => 50
            ) );
            add_post_meta( $voices_id, '_wp_page_template', 'accf-voices.php' );
        }
        if( !in_array( 'initialdonors', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->設立時寄付者<!--:--><!--:en-->Initial donors<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $yourvoices_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'initialdonors',
                'post_type' => 'page',
                'menu_order' => 51
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-voices.php' );
        }
        if( !in_array( 'donors', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->寄付者一覧<!--:--><!--:en-->Donors<!--:-->',
                'post_status' => 'publish',
                'post_parent' => $voices_id,
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'donors',
                'post_type' => 'page',
                'menu_order' => 52
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-donors.php' );
        }
        // お知らせ
        if( !in_array( 'news', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->お知らせ<!--:--><!--:en-->News<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'news',
                'post_type' => 'page',
                'menu_order' => 60
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-news.php' );
        }
        // お問い合わせ
        if( !in_array( 'contact', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->お問い合わせ<!--:--><!--:en-->Contact<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'contact',
                'post_type' => 'page',
                'menu_order' => 70
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-contact.php' );
        }
        // よくあるご質問
        if( !in_array( 'faqs', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->よくあるご質問<!--:--><!--:en-->FAQs<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'faqs',
                'post_type' => 'page',
                'menu_order' => 80
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-faqs' );
        }
        // サイトマップ
        if( !in_array( 'sitemap', $post_names ) ) {
            $inserted_id = wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->サイトマップ<!--:--><!--:en-->Sitemap<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'sitemap',
                'post_type' => 'page',
                'menu_order' => 90
            ) );
            add_post_meta( $inserted_id, '_wp_page_template', 'accf-sitemap.php' );
        }
        // 寄付の市場プロジェクト
        if( !in_array( 'givingmarket', $post_names ) )
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '寄付の市場プロジェクト',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'givingmarket',
                'post_type' => 'page',
                'menu_order' => 100
            ) );
        // ＣＳＲについてのご相談
        if( !in_array( 'csr', $post_names ) )
            wp_insert_post( array(
                'post_author' => '1',
                'post_title' => '<!--:ja-->ＣＳＲについてのご相談<!--:--><!--:en-->Consultation for Corporate Social Responsibility<!--:-->',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'open',
                'post_name' => 'csr',
                'post_type' => 'page',
                'menu_order' => 110
            ) );
    }

    function create_categories() {
        $slugs = array();
        $categories = get_categories( array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false ) );
        foreach( $categories as $category ) {
            $slugs[] = $category->slug;
        }
        if( !in_array( 'news', $slugs ) )
            wp_insert_category( array(
                'cat_name' => 'お知らせ',
                'category_nicename' => 'news'
            ) );
        if( !in_array( 'slide', $slugs ) )
            wp_insert_category( array(
                'cat_name' => 'スライド',
                'category_nicename' => 'slide'
                ) );
        if( !in_array('topic', $slugs) )
            wp_insert_category(
                array(
                    'cat_name' => 'トピック',
                    'category_nicename' => 'topic'
                )
            );
    }
}

new Init_Proc;
?>
