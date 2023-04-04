<?php 
/**
 * @wordpress-plugin
 * Plugin Name:       Product Sales Count Plugin
 * Plugin URI:        newplugin.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Raihan Islam
 * Author URI:        raihan.website
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       new-plugin
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PSCP {
    public function __construct()
    {
        add_action('admin_menu',array(&$this,'register_product_sales_count'));
        add_action('admin_init',array(&$this,'register_setting_options'));
        add_action( 'admin_enqueue_scripts',array(&$this,'admin_register_script') );
    }

    public function admin_register_script(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }
    public function register_setting_options(){
           register_setting( 'pscp_options', 'pscp_enable', 'sanitize_text_field');
			register_setting( 'pscp_options', 'pscp-inlinecss', 'sanitize_text_field');
			register_setting( 'pscp_options', 'pscp_0_order_text', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_after_single', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_text', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_text_color', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_count_color', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_bg_color', 'sanitize_text_field'); 
			register_setting( 'pscp_options', 'pscp_social_buttons', 'sanitize_text_field'); 
		   register_setting( 'pscp_options', 'pscp_after_text', 'sanitize_text_field'); 
    }
    public function register_product_sales_count()
    {
        add_submenu_page( 
        'woocommerce', 
        'Product Sale Count', 
        'Product Sale Count', 
        'manage_options', 
        'product-sales-count', 
        array(&$this,'init_product_sales_count')
        );
    }

    public function init_product_sales_count(){
       ?>
<div class="product-sales-count">
    <h2>Product Sales Count</h2>
    <form action="options.php" method="post">
        <script>
        (function() {
            jQuery(function() {
                jQuery('.color-field').wpColorPicker();
            });
        })(jQuery);
        </script>
        </script>
        <div class="main-slaes-count-section">
            <table cellpadding="10">
                <tr>
                    <td valign="top"
                        style="background: #fff;box-shadow: 10px 10px 20px 10px #f5f5f5;padding-left: 20px;"
                        width="500">
                        <p><input type="checkbox" id="pscp_enable" name="pscp_enable" value="1"
                                <?php checked(get_option('pscp_enable'),1);?> /><label> Enable Sold Count</label>
                        </p>
                        <p><label>Text color:</label> <br>
                            <input type="text" id="pscp_text_color" name="pscp_text_color"
                                value="<?php _e( get_option('pscp_text_color') );?>" placeholder="#ffffff" size="20"
                                data-default-color="#111111" class="color-field">
                        </p>

                        <p><label>Count color:</label> <br><input type="text" id="pscp_count_color"
                                name="pscp_count_color" value="<?php _e(  get_option('pscp_count_color') );?>"
                                placeholder="Count color" size="20" data-default-color="#a46497" class="color-field">
                        </p>
                        <p><label>Background color:</label> <br><input type="text" id="pscp_bg_color"
                                name="pscp_bg_color" value="<?php _e(  get_option('pscp_bg_color') );?>"
                                placeholder="BG color" size="20" data-default-color="" class="color-field"></p>

                        <p><label> Message:</label><br> <input type="text" id="pscp_0_order_text"
                                name="pscp_0_order_text" value="<?php _e ( get_option('pscp_0_order_text'));?>"
                                placeholder="define a custom message for 0 order products" size="40"><br><i>defin
                                custom message for 0 order</i></p>
                        <p><label> Text:</label><br> <input type="text" id="pscp_text" name="pscp_text"
                                value="<?php _e( get_option('pscp_text') );?>" placeholder="Sales" size="40"></p>
                        <p><input type="checkbox" id="pscp_after_text" name="pscp_after_text" value="1"
                                <?php checked(get_option('pscp_after_text'),1);?> /><label>Display sold item number
                                after text</label></p>
                        <p><label>Inline CSS </label><br><textarea rows="10" cols="50" id="pscp-inlinecss"
                                name="pscp-inlinecss"><?php _e( $inlineCss, 'pscp');?></textarea> </p>
                        <p><label>Product bottom tagline</label><br><textarea rows="10" cols="50" id="pscp_after_single"
                                name="pscp_after_single"><?php _e( $pscp_after_single , 'pscp');?></textarea><br><i>This
                                message will display bottom of every single product content </i> </p>

                    </td>
                </tr>
            </table>
        </div>
        <p></p>
        <span class="submit-btn">
            <?php _e( get_submit_button('Save Settings','button-primary','submit','','') , 'pscp');?>
        </span>
        </p>
        <?php settings_fields('pscp_options'); ?>
    </form>

</div>
<?php
    }
}
if(class_exists('PSCP')):
$pscpobj = new PSCP;
endif;


require dirname(__FILE__).'/wc-pscp-class.php';