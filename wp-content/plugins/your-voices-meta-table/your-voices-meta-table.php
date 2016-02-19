<?php
/*
Plugin Name: 応援メッセージ登録プラグイン
Plugin URI: (プラグインの説明と更新を示すページの URI)
Description: 寄付者からの応援メッセージをデータベースに登録します
Version: 0.1
Author: 中居和昭
Author URI: (プラグイン作者の URI)
License: GPL2
*/

class YourVoicesMetaTable {
	private $tablename;
	const VERSION = '1.0';
	const TABLE_NAME = 'yvmt_meta';
	const OPTION_NAME = 'yvmt_version';
	const MENU_TITLE = '応援メッセージ';
	const PLUGIN_TITLE = '応援メッセージ';
	public function __construct() {
		global $wpdb;
		$this->tablename = $wpdb->prefix . self::TABLE_NAME;
		register_activation_hook( __FILE__, array( &$this, 'yvmt_activation') );
		register_deactivation_hook( __FILE__, array( &$this, 'yvmt_deactivation') );
		add_action( 'admin_menu', array(&$this, 'ymvt_menu') );
	}

	function yvmt_activation() {
		global $wpdb;
		$installed_ver = get_option( self::OPTION_NAME );
		if( self::VERSION != $installed_ver ) {
			$sql =<<<SQL
CREATE TABLE {$this->tablename} (
	meta_id bigint(20) NOT NULL AUTO_INCREMENT,
	post_id bigint(20) DEFAULT "0"  NOT NULL,
	name varchar(255),
	address varchar(255),
	message text,
	UNIQUE KEY meta_id(meta_id)
) CHARACTER SET 'utf8'
SQL;
			require( ABSPATH .  'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			update_option( self::OPTION_NAME, self::VERSION );
		}
	}

	function yvmt_deactivation () {
		unregister_setting( self::OPTION_NAME, self::OPTION_NAME );
	}

	function ymvt_menu () {
		$page = add_object_page( self::MENU_TITLE, self::PLUGIN_TITLE, 'administrator', 'your-voices', array( &$this, 'admin_page' ), '' );
		//add_action( 'load-' . $page, array($&this, 'admin_save_post') );
	}

	function admin_page() {
		require( ABSPATH . 'wp-admin/options-head.php' );
		$updated_message = '';
		if ( isset( $_GET['message'] ) && 'invalid' == $_GET['message'] ) {
			$updated_message = __( '無効です');
		}
?>
<div class="wrap">
	<div class="icon32" id="icon-options-general">
		<br />
	</div>
	<?php if ( $updated_message ) : ?>
	<div id="updated_message" class="updated fade"><p><?php echo $updated_message; ?></p></div>
	<?php endif; ?>
	<form action="<?php echo esc_url( add_query_arg( array(), menu_page_url( 'your-voices', false ) ) ); ?>">

	</form>
</div>
<?php
	}
}

new YourVoicesMetaTable;
?>