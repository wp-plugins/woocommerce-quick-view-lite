<?php
/**
Plugin Name: Woocommerce Quick View Lite
Plugin URI: http://www.phoeniixx.com
Description: Quick View is a plugin that allows the customers to have a brief overview of every product in a pop-up box.
Author: phoeniixx
Version: 1.1
Author URI: http://www.phoeniixx.com
**/
if ( ! defined( 'ABSPATH' ) )
{
	exit;   
}
	// Exit if accessed directly
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	
	//global $woocommerce;
	add_action( 'woocommerce_after_shop_loop_item', 'quick_view' , 14 );
	
	add_action('wp_head', 'phoen_wcqv_style'); 
	
	//products details hooks
	//image
	add_action( 'ph_wcqv_product_image', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'ph_wcqv_product_image', 'woocommerce_show_product_images', 20 );

	// Summary
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_price', 15 );
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
	add_action( 'ph_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );
	//AJAX
	add_action( 'wp_ajax_nopriv_quick_ajax_submit', 'quick_ajax_submit' );
	add_action( 'wp_ajax_quick_ajax_submit', 'quick_ajax_submit' );

	
	function phoen_wcqv_style()
	{
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
		$plugins_url = plugins_url();
		
		wp_enqueue_style( 'style-quickview-request', $plugin_dir_url.'css/quick-view.css' );
		
		wp_enqueue_style( 'style-name', $plugins_url.'/woocommerce/assets/css/prettyPhoto.css' );
		
		wp_enqueue_style( 'style-namee', $plugin_dir_url.'/css/style.css' );
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		$plugins_url = plugins_url();
		wp_enqueue_script( 'wc-add-to-cart-variation');
		?>
		
			<script>
				var blog2 = '<?php echo $plugin_dir_url; ?>';
			</script>
			
			<?php
			//all js
		// embed the javascript file that makes the AJAX request

		wp_enqueue_script( 'script-quickview-request', plugin_dir_url( __FILE__ ) . '/js/qv_custom.js', array( 'jquery' ) );

		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( 'script-quickview-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}
	/************* Add quick view button in wc product loop Start*************/
	function quick_view()
	{
		global $table_prefix, $wpdb, $product;
	
		$sql = "select * from wp_options where option_name='quick_view'  ORDER BY `option_id` ASC  limit 1";

		$row1=$wpdb->get_row($sql);
		$row=json_decode($row1->option_value);
	
		$checkqv = $row->status;
	
		$buttonlabel = $row->button_label;
	
		if($buttonlabel == '')
		{
			$buttonlabel = "Quick View";
		}
		if($checkqv == 'enable')
		{

			echo '<a href="#" class="ajax button quick-btn" pro_id="'.$product->id.'" action="quick_ajax_submit" title="'.$buttonlabel.'">' . $buttonlabel . '</a>';
		}
		
		
	}
	/************* Add quick view button in wc product loop end*************/
	
	register_activation_hook(__FILE__, 'ph_quick_view_regitration');

	//Quick view registration 
	function ph_quick_view_regitration()
	{
		$name = 'quick_view';
		
		if( !get_option( $name ) ) 
		{
			
			$option = 'quick_view';
			$data = array(
			'status'=>'enable',
			'button_label'=>'Quick View',
			'popup_bg'=>'#fff',
			'button_quick_view_color'=>'#edeaed',
			'close_popup_btn_color'=>'#333333',
			'close_popup_btn_hcolor'=>'#9e9e9e'
			);
			
			$value = json_encode($data);
			
			add_option($option, $value);
		}

	}


	
	function quick_ajax_submit() 
	{
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		$plugins_url = plugins_url();
		wp_enqueue_script( 'wc-add-to-cart-variation');
		?>
		<script>

		var wc_add_to_cart_variation_params = {"ajax_url":"\/wp-admin\/admin-ajax.php"};
		jQuery.getScript("<?php echo $plugins_url; ?>/woocommerce/assets/js/frontend/add-to-cart-variation.min.js");
		
		</script>
		<?php
		echo '<script src="'.$plugins_url.'/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min.js" type="text/javascript"></script>
		<script src="'.$plugins_url.'/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.init.min.js" type="text/javascript"></script>';
			
	
		if ( ! isset( $_REQUEST['pid'] ) ) {
		die();
		}

		$product_id = intval( $_REQUEST['pid'] );
    
		// set the main wp query for the product
		wp( 'p=' . $product_id . '&post_type=product' );

		// remove product thumbnails gallery
	
		//remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

	

		ob_start();

		// load content template
			
		require_once(dirname(__FILE__).'/template.php');
			
			echo ob_get_clean();

		die();

	}
	
	


	/******** Add Custom Menu ************/

	add_action('admin_menu', 'add_custom_view_page');
	function add_custom_view_page() 
	{

		$plugin_dir_url =  plugin_dir_url( __FILE__ );
		
		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'/images/logo-wp.png', 57 );
        
		add_submenu_page( 'phoeniixx', 'Quick View', 'Quick View', 'manage_options', 'quick_view_setting', 'quick_view_setting' );	
	
	}

	/**************Quick View Setting***********************/
	function quick_view_setting(){
	
		require_once(dirname(__FILE__).'/admin_setting.php');
		}
	
		add_action('wp_head','quick_view_hook_css');
    
    function quick_view_hook_css()
		{
			global $table_prefix, $wpdb;

			$sql = "select * from wp_options where option_name='quick_view'  ORDER BY `option_id` ASC  limit 1";

			$row1=$wpdb->get_row($sql);
			$row=json_decode($row1->option_value);
		
			$but_qk_color = $row->button_quick_view_color;
		
			$col_pop_but_colr = $row->close_popup_btn_color;
		
			$col_pop_but_h_colr = $row->close_popup_btn_hcolor;
		
			$win_bag_color = $row->popup_bg;
		
			//$popupsize1 = $row->popup_h;
		
			//$popupsize2 = $row->popup_w;

			$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
			?>
			<style>
				#wc-quick-view-popup .quick-wcqv-main{ background:<?php if($win_bag_color != ''){ echo $win_bag_color.'!important'; } else { echo "#ffffff"; } ?>; }
			
				.ajax.button.quick-btn{ background:<?php if($but_qk_color != ''){ echo $but_qk_color; } else { echo "#edeaed"; } ?>;  }
			
				.ajax.button.quick-btn:hover{ background:<?php if($but_qk_color != ''){ echo $but_qk_color; } else { echo "#edeaed"; } ?>; }
	
				#wc-quick-view-close { color:<?php if($col_pop_but_colr != ''){ echo $col_pop_but_colr; } else { echo "#000"; } ?>; }
			
				#wc-quick-view-close:hover { color:<?php if($col_pop_but_h_colr != ''){ echo $col_pop_but_h_colr; } else { echo "#ccc"; } ?>; }
			
				
			</style>

			<?php
		
	
		}
		
}

?>