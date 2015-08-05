<?php
/*
Plugin Name: Woocommerce Quick View lite
Plugin URI: http://www.phoeniixx.com
Description: Quick View is a plugin that allows the customers to have a brief overview of every product in a pop-up box.
Author: phoeniixx
Version: 1.1
Author URI: http://www.phoeniixx.com
Created by the Phoeniixx Group
(website: www.phoeniixx.com  email : support@phoeniixx.com)
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Put your plugin code here
	add_action('wp_head', 'phoen_adpanel_style2');

	add_action( 'woocommerce_after_shop_loop_item', 'add_quick_view_ultimate_link_each_products' , 14 );

	function phoen_adpanel_style2()
	{
		
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
		$plugins_url = plugins_url();
		
		wp_enqueue_style( 'style-quickview-request', $plugin_dir_url.'css/quick-view.css' );
		
		wp_enqueue_style( 'style-name', $plugins_url.'/woocommerce/assets/css/prettyPhoto.css' );
		
		wp_enqueue_style( 'style-namee', $plugin_dir_url.'/css/style.css' );
		?>
		
			<script>
				var blog_title = '<?php echo $plugin_dir_url; ?>';
			</script>
		
			
			<?php
		// embed the javascript file that makes the AJAX request
		wp_enqueue_script( 'script-quickview-request', plugin_dir_url( __FILE__ ) . '/js/custom.js', array( 'jquery' ) );

		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( 'script-quickview-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );


	}
	
	
	function add_quick_view_ultimate_link_each_products()
	{
		global $table_prefix, $wpdb;
		
		$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."quick_view_settings` ORDER BY `id` ASC  limit 1",ARRAY_A);	

		foreach($qry22 as $qry)
		{
			
		}
		
		$checkqv = $qry['checkqv'];
		
		$buttonlabel = $qry['buttonlabel'];
		
		if($buttonlabel == '')
		{
			$buttonlabel = "Quick View";
		}
		if($checkqv == 1)
		{
			$pro_id = get_the_ID();
			
			//$blog_title = get_site_url();
			
			$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
				
			$_pf = new WC_Product_Factory();  

			$_product = $_pf->get_product($pro_id);
			
			if(is_shop() || is_product_category())
			{
				$product_type =  $_product->product_type;
			
				if($buttontype == 0)
				{	
					if($product_type === 'simple')
					{
						echo '<a class="ajax button quick-btn" pro_id="'.$pro_id.'" action="quick_ajax_submit_s" title="'.$buttonlabel.'">'.$buttonlabel.'</a>';
					}
					elseif($product_type === 'variable')
					{
						echo '<a class="ajax button quick-btn" pro_id="'.$pro_id.'" action="quick_ajax_submit_v" title="'.$buttonlabel.'">'.$buttonlabel.'</a>';
					}
					elseif($product_type === 'external')
					{
						echo '<a class="ajax button quick-btn" pro_id="'.$pro_id.'" action="quick_ajax_submit_e" title="'.$buttonlabel.'">'.$buttonlabel.'</a>';
					}
					elseif($product_type === 'grouped')
					{
						echo '<a class="ajax button quick-btn" pro_id="'.$pro_id.'" action="quick_ajax_submit_g" title="'.$buttonlabel.'">'.$buttonlabel.'</a>';
					}
				}
				
			}
		}
		
		
	}
	
	
	
	add_action( 'wp_ajax_nopriv_quick_ajax_submit_s', 'quick_ajax_submit_s' );
	add_action( 'wp_ajax_quick_ajax_submit_s', 'quick_ajax_submit_s' );
	
	add_action( 'wp_ajax_nopriv_quick_ajax_submit_e', 'quick_ajax_submit_e' );
	add_action( 'wp_ajax_quick_ajax_submit_e', 'quick_ajax_submit_e' );
	
	add_action( 'wp_ajax_nopriv_quick_ajax_submit_v', 'quick_ajax_submit_v' );
	add_action( 'wp_ajax_quick_ajax_submit_v', 'quick_ajax_submit_v' );
	
	add_action( 'wp_ajax_nopriv_quick_ajax_submit_g', 'quick_ajax_submit_g' );
	add_action( 'wp_ajax_quick_ajax_submit_g', 'quick_ajax_submit_g' );
	
	
	function quick_ajax_submit_s() {
		
		require_once(dirname(__FILE__).'/simple_product.php');
		
	}
	
	function quick_ajax_submit_e() {
		
		require_once(dirname(__FILE__).'/external_product.php');
	}
	
	function quick_ajax_submit_v() {
		
		require_once(dirname(__FILE__).'/variable_product.php');
	}
	
	function quick_ajax_submit_g() {
		
		require_once(dirname(__FILE__).'/grouped_product.php');
	}
	
	
	
	function quick_view_settings_link($links) { 
	
		  $settings_link = '<a href="admin.php?page=quick_view_setting">Settings</a>'; 
		  
		  array_unshift($links, $settings_link); 
		  
		  return $links; 
		  
		}
		 
	$plugin = plugin_basename(__FILE__);
	
	add_filter("plugin_action_links_$plugin", 'quick_view_settings_link' );
	
	function quick_view_setting()
	{
		
		require_once(dirname(__FILE__).'/admin-setting.php');
		
	} 
	
	add_action('admin_menu', 'quick_view_settings_menu');

	function quick_view_settings_menu(){
		
		$plugin_dir_url =  plugin_dir_url( __FILE__ );
		
		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'/images/logo-wp.png', 57 );
        
		add_submenu_page( 'phoeniixx', 'Quick View', 'Quick View', 'manage_options', 'quick_view_setting', 'quick_view_setting' );

	}
	
	register_activation_hook(__FILE__, 'quick_view_plugin_activation');
	
	function quick_view_plugin_activation()
	{

		global $table_prefix, $wpdb;

		$tblname = 'quick_view_settings';

		$wp_track_members_table = $table_prefix . "$tblname";

		#Check to see if the table exists already, if not, then create it

		if($wpdb->get_var("show tables like '$wp_track_members_table'") != $wp_track_members_table) 
		{

			$sql0  = "CREATE TABLE `". $wp_track_members_table . "` ( ";

			$sql0 .= "  `id`  int(11)   NOT NULL auto_increment, ";

			$sql0 .= "  `pimg_size`  text   NOT NULL, ";
			
			$sql0 .= "  `pimg_size1`  text   NOT NULL, ";

			$sql0 .= "  `timg_size`  text   NOT NULL, ";
			
			$sql0 .= "  `timg_size1`  text   NOT NULL, ";

			$sql0 .= "  `laimg_size`  text   NOT NULL, ";
			
			$sql0 .= "  `laimg_size1`  text   NOT NULL, ";

			$sql0 .= "  `taimg_size` text   NOT NULL, ";
			
			$sql0 .= "  `taimg_size1` text   NOT NULL, ";

			$sql0 .= "  `pachang_size`  text   NOT NULL, ";
			
			$sql0 .= "  `pachang_size1`  text   NOT NULL, ";
			
			$sql0 .= "  `sale_tag`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `pro_image`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `pro_name`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `pro_des`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `pro_rev`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `po_rate`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `product_price`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `product_excerpt`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `checkqv`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `checkqvm`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `productnav`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `popupsize1`  text  NOT NULL, ";
			
			$sql0 .= "  `popupsize2`  text  NOT NULL, ";
			
			$sql0 .= "  `buttontype`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `icon_image`  text   NOT NULL, ";
			
			$sql0 .= "  `buttonlabel`  text   NOT NULL, ";
			
			$sql0 .= "  `buttonpos`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `viewdetail`  int(11)   NOT NULL, ";
			
			$sql0 .= "  `viewdetail_label`  text   NOT NULL, ";
			
			$sql0 .= "  `p_l_a_image`  text   NOT NULL, ";
			
			$sql0 .= "  `p_r_a_image`  text   NOT NULL, ";
			
			$sql0 .= "  `t_l_a_image` text   NOT NULL, ";
			
			$sql0 .= "  `t_r_a_image` text   NOT NULL, ";
			
			$sql0 .= "  `ph_l_a_image`  text NOT NULL, ";
			
			$sql0 .= "  `ph_r_a_image` text  NOT NULL, ";
			
			$sql0 .= "  `pronamecolor` text  NOT NULL, ";
			
			$sql0 .= "  `pricecolor`  text  NOT NULL, ";
			
			$sql0 .= "  `skucolor` text  NOT NULL, ";
			
			$sql0 .= "  `catcolor` text   NOT NULL, ";
			
			$sql0 .= "  `win_bag_color` text  NOT NULL, ";
			
			$sql0 .= "  `but_qk_color` text  NOT NULL, ";
			
			$sql0 .= "  `but_qk_t_color` text  NOT NULL, ";
			
			$sql0 .= "  `but_qk_h_color` text  NOT NULL, ";
			
			$sql0 .= "  `but_qk_h_t_color` text  NOT NULL, ";
			
			$sql0 .= "  `star_color` text NOT NULL, ";
			
			$sql0 .= "  `but_ad_color` text  NOT NULL, ";
			
			$sql0 .= "  `but_ad_t_color` text NOT NULL, ";
			
			$sql0 .= "  `col_pop_but_colr` text NOT NULL, ";
			
			$sql0 .= "  `col_pop_but_h_colr` text NOT NULL, ";

			$sql0 .= "  PRIMARY KEY `order_id` (`id`) "; 

			$sql0 .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

			#We need to include this file so we have access to the dbDelta function below (which is used to create the table)

			require_once(ABSPATH . '/wp-admin/upgrade-functions.php');

			dbDelta($sql0);
			
			$rows_affected = $wpdb->insert( $wp_track_members_table, array('sale_tag' => '1', 'pro_image' => '1', 'pro_name' => '1', 'pro_des' => '1', 'pro_rev' => '1', 'po_rate' => '1', 'product_price' => '1', 'product_excerpt' => '1', 'checkqv' => '1', 'popupsize1' => '400', 'popupsize2' => '750', 'win_bag_color' => '#ffffff', 'but_qk_color' => '#edeaed', 'col_pop_but_colr' => '#333333', 'col_pop_but_h_colr' => '#9e9e9e'));
			
			dbDelta( $rows_affected );
		}
	}
	
	add_action('wp_head','hook_css_new');
    
    function hook_css_new()
    {
		global $table_prefix, $wpdb;
		
		$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."quick_view_settings` ORDER BY `id` ASC  limit 1",ARRAY_A);	

		foreach($qry22 as $qry)
		{
			
		}
		//print_r($qry);
		$but_qk_color = $qry['but_qk_color'];
		
		$col_pop_but_colr = $qry['col_pop_but_colr'];
		
		$col_pop_but_h_colr = $qry['col_pop_but_h_colr'];
		
		$win_bag_color = $qry['win_bag_color'];
		
		$popupsize1 = $qry['popupsize1'];
		
		$popupsize2 = $qry['popupsize2'];

		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
		?>
		<style>
			#wc-quick-view-popup .quick-wcqv-main{ background:<?php if($win_bag_color != ''){ echo $win_bag_color; } else { echo "#ffffff"; } ?>; }
			
			.ajax.button.quick-btn{ background:<?php if($but_qk_color != ''){ echo $but_qk_color; } else { echo "#edeaed"; } ?>;  }
			
			.ajax.button.quick-btn:hover{ background:<?php if($but_qk_color != ''){ echo $but_qk_color; } else { echo "#edeaed"; } ?>; }
	
			#wc-quick-view-close { color:<?php if($col_pop_but_colr != ''){ echo $col_pop_but_colr; } else { echo "#000"; } ?>; }
			
			#wc-quick-view-close:hover { color:<?php if($col_pop_but_h_colr != ''){ echo $col_pop_but_h_colr; } else { echo "#ccc"; } ?>; }
			
			#wc-quick-view-popup .quick-wcqv-main { height:<?php if($popupsize1 != ''){ echo $popupsize1; } else { echo "500"; } ?>px;width:<?php if($popupsize2 != ''){ echo $popupsize2; } else { echo "500"; } ?>px; }
		</style>

		<?php
	
	}
}