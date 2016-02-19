<?php
/**
 * Creates theme setting
 */
class Theme_Setting
{
    const THEME_NAME = 'ACCF';
    private $_values = array(
        'latest_news_num' => '',
    );

    public function __construct()
    {
        add_action('admin_menu', array(&$this, 'admin_menu_handler'));
        $this->_values['latest_news_num'] = get_option('latest_news_num');
    }

    public function admin_menu_handler()
    {
        /*add_submenu_page(
            'themes.php', 'Front Page Elements', 'オプション', 'manage_options',
            'theme-option', array(&$this, 'option_settings')
        );*/
        if (isset($_GET['page']) && $_GET['page'] == 'theme-option' ) {
            if ( 'save' == $_REQUEST['action'] ) {
                if ( isset($_REQUEST['latest_news_num']) ) {
                    update_option('latest_news_num', (int)$_REQUEST['latest_news_num']);
                    $this->_values['latest_news_num'] = (int)$_REQUEST['latest_news_num'];
                } else {
                    delete_option('latest_news_num');
                    $this->_values['latest_news_num'] = '';
                }
                header('Location: themes.php?page=theme-option&saved=true');
                die;
            }
        }
        add_theme_page('Option', 'オプション', 'manage_options', 'theme-option', array(&$this, 'option_settings'));
    }

    public function option_settings()
    {
        if( $_REQUEST['saved'] )
            echo '<div id="message" class="updated fade"><p><strong>設定を保存しました。</strong></p></div>';
?>
    <div class="wrap">
        <?php screen_icon('themes'); ?>
        <h2>テーマの設定</h2>
        <form method="post">
            <table class="optiontable form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="latest_news_num">最新ニュースの数</label>
                        </th>
                        <td>
                            <select name="latest_news_num">
                                <option value="5" <?php if($this->_values['latest_news_num'] == 5) echo 'selected'; ?>>５</option>
                                <option value="6" <?php if($this->_values['latest_news_num'] == 6) echo 'selected'; ?>>６</option>
                                <option value="7" <?php if($this->_values['latest_news_num'] == 7) echo 'selected'; ?>>７</option>
                                <option value="8" <?php if($this->_values['latest_news_num'] == 8) echo 'selected'; ?>>８</option>
                                <option value="9" <?php if($this->_values['latest_news_num'] == 9) echo 'selected'; ?>>９</option>
                                <option value="10" <?php if($this->_values['latest_news_num'] == 10) echo 'selected'; ?>>１０</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p>
                <input type="hidden" name="action" value="save" />
                <input type="submit" class="button-primary" name="submit" value="変更を保存" />
            </p>
        </form>
    </div>
<?php
    }

}

new Theme_Setting;
