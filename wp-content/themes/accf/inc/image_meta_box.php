<?php
/**
 * Adds a meta field to upload images for top page.
 */
class Image_Meta_Box {

    const IMAGE_JPEG = 'image/jpeg';
    const IMAGE_GIF = 'image/gif';
    const IMAGE_PNG = 'image/png';

    public function __construct() {
        add_action( 'admin_menu', array( &$this, 'admin_menu_hook_handler' ) );
        add_action( 'save_post', array( &$this, 'save_post_hook_handler' ) );
        add_action( 'admin_print_scripts', array( &$this, 'admin_print_scripts_hook_handler' ) );
        add_action( 'admin_print_styles', array( &$this, 'admin_print_styles_hook_handler' ) );
        //add_action( 'wp_handle_upload', array( &$this, 'wp_handle_upload_hook_handler' ) );
    }

    public function admin_menu_hook_handler() {
        add_meta_box( 'image_meta_section', '表示画像', array( &$this, 'meta_box_html' ), 'post', 'normal', 'high' );
    }

    public function meta_box_html () {
        if( isset( $_GET['post'] ) ) {
            $uploaded_image = get_post_meta( $_GET['post'], 'upload_image' );
        }

        if( isset( $_REQUEST['file'] ) ) {
            check_admin_referer( 'my_media_manager_options' );
            $options = get_option(' my_media_manager_options', true );
            $options['default_image'] = absint( $_REQUEST['file'] );
            update_option( 'my_media_manager_options', $options );
        }
        /*$modal_update_href = esc_url( add_query_arg(
            array(
                'page' => 'my_media_manager',
                '_wpnonce' => wp_create_nonce( 'my_media_manager_options' )
            ),
            admin_url( 'upload.php' )
        ) );*/
    ?>
    <div id="upload_image_form">
        <p>画像の表示領域は、<b>幅 620px</b>、<b>高さ 370px</b>になります。</p>
        <p>画像の幅が620pxになるように編集してください。</p>
        <label for="upload_image">画像</label>
        <input id="upload_image" type="text" size="90" name="upload_image" value="<?php echo isset( $uploaded_image[0] ) ? $uploaded_image[0] : ''; ?>"/>
        <a id="choose-image" class="button" title="メディアを追加"
            data-update-link="<?php //echo esc_attr( $modal_update_href ); ?>"
            data-choose="<?php esc_attr_e( '画像を挿入' ); ?>"
            data-update="<?php esc_attr_e( '投稿に挿入') ; ?>"
            href="#">
            メディアを追加
        </a>
    </div>
    <div id="uploaded_image_view">
        <?php if ( isset( $uploaded_image[0] ) ) : ?>
        <img src="<?php echo $uploaded_image[0]; ?>" />
        <?php endif; ?>
    </div>
    <?php
    }

    public function save_post_hook_handler ( $post_id ) {
        if( isset( $_POST['upload_image'] ) ) {
            $data = $_POST['upload_image'];
            if( '' == get_post_meta( $post_id, 'upload_image') ) {
                add_post_meta( $post_id, 'upload_image', $data, true );
            } elseif( $data != get_post_meta( $post_id, 'upload_image') ) {
                update_post_meta( $post_id, 'upload_image', $data );
            } elseif( '' == $data ) {
                delete_post_meta( $post_id, 'upload_image' );
            }
        }
    }

    public function admin_print_scripts_hook_handler() {
        wp_enqueue_media();
        wp_enqueue_script( 'admin_script', get_template_directory_uri() . '/js/mediaframe.js', array('jquery') );
    }

    public function admin_print_styles_hook_handler() {
        wp_register_style( 'admin_style', get_template_directory_uri() . '/css/img_meta_box.css', array() );
        wp_enqueue_style( 'admin_style');
    }

    /**
     * メディアアップローダーでアップロードされたファイルの処理をする
     * @param  array $array Reference to a single element of $_FILES
     * @return [type]        [description]
     */
    public function wp_handle_upload_hook_handler( $array ) {
        //if( self::IMAGE_JPEG != $array['type'] or self::IMAGE_GIF != $array['type'] or self::IMAGE_PNG != $array['type'] )
        //  return;
        //$names = pathinfo( $array['file'] );
        //$newimage = $names['dirname'].'/'.$names['filename'].'.new.'.$names['extension'];
        //copy( $array['file'], $newimage );

        $imagepath = $array['file'];
        $dst_imagepath = pathinfo( $array['file'] );
        $dst_imagepath = $dst_imagepath['dirname'] . '/' . $dst_imagepath['filename'] . '.new.' . $dst_imagepath['extension'];

        switch( $array['type'] ) {
            case 'image/gif':
                $src_image = imagecreatefromgif( $imagepath );
                $src_w = imagesx( $src_image );
                $src_h = imagesy( $src_image );
                //$dst_image = imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                $dst_image = wp_imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                imagecopyresampled( $dst_image, $src_image, 0, 0, 0, 0, 620, $src_h * 620 / $src_w, $src_w, $src_h );
                imagegif( $dst_image, $dst_imagepath );
                break;
            case 'image/jpeg':
                $src_image = imagecreatefromjpeg( $imagepath );
                $src_w = imagesx( $src_image );
                $src_h = imagesy( $src_image );
                //$dst_image = imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                $dst_image = wp_imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                imagecopyresampled( $dst_image, $src_image, 0, 0, 0, 0, 620, $src_h * 620 / $src_w, $src_w, $src_h );
                imagejpeg( $dst_image, $dst_imagepath );
                break;
            case 'image/png':
                $src_image = imagecreatefrompng( $imagepath );
                $src_w = imagesx( $src_image );
                $src_h = imagesy( $src_image );
                //$dst_image = imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                $dst_image = wp_imagecreatetruecolor( 620, $src_h * 620 / $src_w );
                imagecopyresampled( $dst_image, $src_image, 0, 0, 0, 0, 620, $src_h * 620 / $src_w, $src_w, $src_h );
                imagepng( $dst_image, $dst_imagepath );
                break;
        }
        imagedestroy( $src_image );
        //unlink( $array['file'] );
        $array['file'] = $dst_imagepath;
        return $array;
    }

}

new Image_Meta_Box;
?>
