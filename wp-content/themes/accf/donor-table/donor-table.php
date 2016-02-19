<?php
/*
Plugin Name: 応援メッセージ登録プラグイン
Plugin URI: (プラグインの説明と更新を示すページの URI)
Description: 寄付者からの応援メッセージをデータベースに登録します
Version: 1.0
Author: 中居和昭
Author URI: (プラグイン作者の URI)
License:
*/

define( 'TABLE_NAME', 'donor_table' );
define( 'FORM_PAGE', 'donor-form' );

require_once 'donor-list-nav.php';
require_once 'donor-list-table.php';

class Donor_Table {
	private $tablename;
	const VERSION = '1.0';
	const PAGE_NAME = 'donor-table';
	const EDIT_PAGE = 'donor-table-edit';
	const OPTION_NAME = 'donor_table_version';
	const MENU_TITLE = '応援メッセージ';

	public function __construct() {
		//global $wpdb;

		register_activation_hook( __FILE__, array( &$this, 'activation_handler') );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivation_handler') );
		//add_action( 'init', array( &$this, 'register_post_type') );
		add_action( 'admin_menu', array( &$this, 'menu_handler') );
		add_action( 'admin_print_styles', array(&$this, 'print_styles_handler') );
		//add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts_action_handler') );
		//add_action( 'wp_ajax_save', array( &$this, 'ajax_save_handler' ) );
	}

	public function activation_handler() {
		global $wpdb;
		$installed_ver = get_option( self::OPTION_NAME, 0 );
		if( self::VERSION != $installed_ver ) {
			$tablename = $wpdb->prefix . TABLE_NAME;
			$charset = defined('DB_CHARSET') ? DB_CHARSET : 'utf8';
			$sql =<<<SQL
CREATE TABLE {$tablename} (
	`id` bigint(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT '匿名希望',
	`address` varchar(255) DEFAULT NULL,
	`message` text,
	`initial` tinyint(1) DEFAULT '0',
	UNIQUE KEY `id` (`id`)
) DEFAULT CHARSET = {$charset}
SQL;
			require( ABSPATH .  'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			update_option( self::OPTION_NAME, self::VERSION );
		}
	}

	public function deactivation_handler() {
		unregister_setting( self::OPTION_NAME, self::OPTION_NAME );
	}

	public function menu_handler() {
		add_object_page( self::MENU_TITLE, self::MENU_TITLE, 'edit_posts', self::PAGE_NAME, array( &$this, 'admin_list_page_handler' ), get_template_directory_uri() . '/donor-table/img/heart.gif' );
		add_submenu_page( self::PAGE_NAME, '新規追加', '新規追加', 'edit_posts', FORM_PAGE, array( &$this, 'admin_add_page_handler') );
		//add_action( 'load-' . $page, array($&this, 'admin_save_post') );
	}

	public function print_styles_handler() {
		global $plugin_page;
		if( !isset( $plugin_page ) || ( self::PAGE_NAME != $plugin_page && FORM_PAGE != $plugin_page && self::EDIT_PAGE != $plugin_page ) ) {
			return;
		}
		//wp_enqueue_style( 'twitter-bootstrap', WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/css/bootstrap.min.css' );
		//wp_enqueue_style( 'wp-jquery-ui-dialog' );
		//wp_enqueue_style( 'jquery-ui-1.9.2.custom', WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/css/jquery-ui-1.9.2.custom.min.css' );
		//wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'donor-table', get_template_directory_uri() . '/donor-table/css/donor-table.css' );
	}

	public function enqueue_scripts_action_handler() {
		global $plugin_page;
		if( !isset( $plugin_page ) || self::PAGE_NAME != $plugin_page || FORM_PAGE != $plugin_page || self::EDIT_PAGE != $plugin_page ) {
			return;
		}
		//wp_enqueue_script( 'jquery-ui-dialog' );
		//wp_enqueue_script( 'dialog-handler', WP_PLUGIN_URL . '/' . dirname(plugin_basename( __FILE__ ) ) . '/js/dialoghandler.js', array( 'jquery-ui-dialog' ), null, true);
		//add_action( 'admin_head', array(&$this, 'post_ajax_handler') );
	}

	public function admin_add_page_handler() {
		global $wpdb;
		$message = '';
		$notice = '';
		$default = array( 'id' => 0, 'name' => '', 'address' => '', 'message' => '', 'initial' => 0 );

		if( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], basename( __FILE__ ) ) ) {
			$item = shortcode_atts( $default, $_REQUEST );
			if( $item['name'] == '' ) $item['name'] = '匿名希望';
			$item_valid = $this->validate_data( $item );
			if( true == $item_valid ) {
				if( $item['id'] == 0) {
					$result = $wpdb->insert( $wpdb->prefix . TABLE_NAME, $item );
					$item['id'] = $wpdb->insert_id;
					if( $result ) {
						$message = '正常に保存されました。';
					} else {
						$notice = '保存時にエラーが発生しました。';
					}
				} else {
					$result = $wpdb->update( $wpdb->prefix . TABLE_NAME, $item, array( 'id' => $item['id'] ) );
					if( $result ) {
						$message = '正常に更新されました。';
					} else {
						$notice = '更新時にエラーが発生しました。';
					}
 				}
			} else {
				$notice = $item_valid;
			}
		} else {
			$item = $default;
			if( isset( $_REQUEST['id'] ) ) {
				$tablename = $wpdb->prefix . TABLE_NAME;
				$item = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$tablename} WHERE id = %d", $_REQUEST['id'] ), ARRAY_A );
				if( !$item ) {
					$item = $default;
					$notice = '項目が見つかりませんでした。';
				}
			}
		}

		add_meta_box( 'donor_form_meta_box', '応援メッセージ', array( &$this, 'donor_form_meta_box_handler' ), 'donor', 'normal', 'default' );
?>
<div class="wrap">
	<div class="icon32 icon32-posts-post" id="icon-edit"></div>
	<h2>
		<?php echo self::MENU_TITLE; ?> 登録
		<a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=' . self::PAGE_NAME); ?>"><?php echo '一覧に戻る'; ?></a>
		<a class="add-new-h2 donor-add" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=' . FORM_PAGE); ?>"><?php echo '新規追加' ?></a>
	</h2>
	<?php if( !empty( $notice ) ) : ?>
	<div id="notice" class="error"><p><?php echo $notice; ?></p></div>
	<?php endif; ?>
	<?php if( !empty( $message) ) : ?>
	<div id="message" class="updated"><p><?php echo $message; ?></p></div>
	<?php endif; ?>

	<form id="form" method="post" style="max-width: 800px;">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
		<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
		<div class="metabox-holder" id="poststuff">
			<div id="post-body">
				<div id="post-body-content">
					<?php do_meta_boxes( 'donor', 'normal', $item ); ?>
					<input type="submit" value="<?php echo ' 保 存 '; ?>" id="submit" class="button-primary" name="submit"/>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
	}

	public function donor_form_meta_box_handler( $item ) {
?>
<table cellspacing="2" cellpadding="5" class="form-table">
	<tbody>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="name">名前（空欄の場合は「匿名希望」）</label></th>
			<td><input type="text" name="name" id="name" class="text" size="40" placeholder="寄付者の名前を入力" value="<?php echo stripslashes( $item['name'] ); ?>" /></td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="address">住所</label></th>
			<td><input type="text" name="address" id="address" class="text" size="40" placeholder="寄付者の住所を入力" value="<?php echo stripslashes( $item['address'] ); ?>" /></td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="message">メッセージ</label></th>
			<td><textarea name="message" id="message" class="text" rows="7" cols="40" placeholder="寄付者からの応援メッセージを入力"><?php echo stripslashes( $item['message'] ); ?></textarea></td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row"><label for="initial">設立時寄付者</label></th>
			<td>
				<input type="checkbox" name="initial" id="initial" value="1" <?php echo $item['initial'] == 1 ? 'checked' : ''; ?>/>設立時寄付者です
			</td>
		</tr>
	</tbody>
</table>
<?php
	}

	public function admin_list_page_handler() {
		//global $wpdb;
		$wp_list_table = new Donor_List_Table;
		$wp_list_table->prepare_items();
		$message = '';
		if( 'delete' == $wp_list_table->current_action() ) {
			$message = '<div class="updated below-h2" id="message"><p>' . sprintf( '%d 項目を削除しました。', count( $_REQUEST['id'] ) ) . '</p></div>';
		}
?>
<div class="wrap">
	<div class="icon32 icon32-posts-post" id="icon-edit"></div>
	<h2><?php echo self::MENU_TITLE; ?> 一覧
		<a class="add-new-h2 donor-add" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=' . FORM_PAGE); ?>"><?php echo '新規追加' ?></a>
	</h2>
	<?php echo $message; ?>
</div>
<form method="get">
	<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
	<?php $wp_list_table->display(); ?>
</form>
<!--
<div id="donor-form-dialog" title="寄付者登録">
	<p class="validateTips">全てのフィールドを入力してください。</p>
	<form>
		<fieldset>
			<label for="name">名前</label>
			<input type="text" name="name" id="name" class="text" size="40" /><br />
			<label for="address">住所</label>
			<input type="text" name="address" id="address" class="text" size="40" /><br />
			<label for="message">メッセージ</label>
			<textarea name="message" id="message" class="text" rows="7" cols="40"></textarea>
		</fieldset>
	</form>
</div>
-->
<?php
	}

	/**
	 * フォームから入力された値をチェックします。
	 *
	 * @param array $item フォームで入力されるデータ
	 * @return boolean       妥当ならtrue
	 */
	public function validate_data( $item ) {
		// チェックすべき項目無し
		return true;
	}

	function post_ajax_handler() {
		$nonce = wp_create_nonce( TABLE_NAME );
?>
<script>
jQuery( document ).ready( function() {
	( function( $ ) {

	$( '#donor-form-dialog' ).dialog( {
		autoOpen: false,
		height: 500,
		width:400,
		closeOnEscape: false,
		modal: true,
		buttons: [{
				id: 'save-button',
				text: ' 保 存 ',
				click: function() {
					var param = {
						action: 'save',
						security: '<?php echo $nonce; ?>'
					};
					param['name'] = $( 'input[name="name"]' ).val();
					param['address'] = $( 'input[name="address"]' ).val();
					param['message'] = $( 'textarea[name="message"]').val();
					var that = this;
					$.post( ajaxurl, param, function( id ) {
						$( 'input[name="name"]' ).val('');
						$( 'input[name="address"]' ).val('');
						$( 'textarea[name="message"]').val('');
						$( '#save-button' ).hide();
						$( '#cancel-button' ).hide()
							.after( $( '<img>', { id: 'loading-icon', src: '../wp-content/plugins/donor-table/img/ajax-loader.gif', style:'' } ) );
						setTimeout( function() {
							$( '#loading-icon' ).remove();
							$( '#save-button').show();
							$( '#cancel-button' ).show();
							$( that ).dialog( 'close' );
						}, 1500);
					} );
				}
			},{
				id:'cancel-button',
				text: 'キャンセル',
				click: function() {
					$( this ).dialog( 'close' );
				}
		}]
	} );

	/*$( 'a.donor-add' ).click( function( event ) {
		event.preventDefault();
		$( '#donor-form-dialog' ).dialog( 'open' );
	} );*/

	} )( jQuery );
} );
</script>
<?php
	}

	public function ajax_save_handler() {
		check_ajax_referer( TABLE_NAME, 'security' );
		global $wpdb;
		$name = $_POST['name'];
		$address = $_POST['address'];
		$message = $_POST['message'];
		$wpdb->insert(
				$this->tablename,
				array(
					'name' => $name,
					'address' => $address,
					'message' => $message
				),
				array(
					'%s',
					'%s',
					'%s'
				)
		);
		/*$wpdb->query(	$wpdb->prepare(
						"INSERT INTO"
				)
		);*/
		$id = $wpdb->insert_id;
		echo esc_html( $id );
		die();
	}
}

new Donor_Table;

?>
