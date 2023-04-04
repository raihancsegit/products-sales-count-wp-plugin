<?php

if( !class_exists( 'WcSalesManage' ) )
{
    class WcSalesManage
    {
        public function __construct()
        {
            $pscp_enable = '';
		    // register actions
		    $pscp_enable = get_option('pscp_enable') ? get_option('pscp_enable') : '';
		    
		    $pscp_after_single = get_option('pscp_after_single') ? get_option('pscp_after_single') : '';
		    if($pscp_enable == 1){
                add_action( 'woocommerce_single_product_summary', array(&$this,'wc_scm_product_sold_count'), 11);
            }
        }

        public function wc_scm_product_sold_count() {
			global $product;
			wp_reset_postdata(); // reset post meta
			$pscpText= get_option('pscp_text') ? get_option('pscp_text') : '';
			$pscp_0_order_text= get_option('pscp_0_order_text') ? get_option('pscp_0_order_text') : '';
			$salesTxt = ($pscpText!='') ? $pscpText : 'Sales';
			$product = json_decode($product);
			
			$units_sold = get_post_meta( $product->id, 'total_sales', true );
			
			$after_text = get_option( 'pscp_after_text', true );
			
			if($units_sold=='0' && $pscp_0_order_text!='')
			{
				$units_sold = $pscp_0_order_text;
				$salesTxt = '';
				}
			
			if( isset( $after_text ) && $after_text ) {
			    
			    $soldtext = sprintf( __( '<span class="wc-scm-text">%s</span> <span class="wc-scm-count">%s</span>', 'woocommerce' ), $salesTxt, $units_sold );
			    
			}else {
			    
			    $soldtext = sprintf( __( '<span class="wc-scm-count">%s</span> <span class="wc-scm-text">%s</span>', 'woocommerce' ), $units_sold,$salesTxt );
			}
			
			_e( '<div class="wc-scm"><div class="wc-scm-inner">' . $soldtext . '</div></div>', 'wpexpertsin');
	    }
    }
}

if( class_exists( 'WcSalesManage' ) ):

    $WcSalesManageObj = new WcSalesManage;
   
   endif;
?>