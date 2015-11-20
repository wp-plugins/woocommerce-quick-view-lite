<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	global $table_prefix, $wpdb;

	//$product_type = sanitize_text_field( $_POST['product_type'] );

	$plugin_dir_url = esc_url( plugin_dir_url( __FILE__ ) );
	
	$pid = sanitize_text_field( $_POST['pid'] );

	$_pf = new WC_Product_Factory();  

	$_product = $_pf->get_product($pid);

	$product = new WC_Product( $pid );

	$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."quick_view_settings` ORDER BY `id` ASC  limit 1",ARRAY_A);	

	foreach($qry22 as $qry)
	{
		
	}
	$pageposts2 = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$table_prefix."postmeta` WHERE `post_id` = %d && meta_key=%s ", $pid, '_thumbnail_id') );

	$large_image_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".$table_prefix."postmeta` WHERE `post_id` = %d && meta_key=%s ", $pid, '_thumbnail_id') );
		
	if($_product->product_type == 'variable')
	{
		
		$available_variations = $_product->get_available_variations();
		
		
	?>
	<div class="post-<?php echo $pid; ?> product type-product status-publish has-post-thumbnail shipping-taxable purchasable product-type-variable instock" id="product-<?php echo $pid; ?>" itemtype="http://schema.org/Product" itemscope="">

	<?php
		
		$available_variations22 = $_product->get_available_variations();

		$variation_id22=$available_variations22[0]['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.

		$variable_product22= new WC_Product_Variation( $variation_id22 );

		$sale = $variable_product22 ->sale_price;

		
	?>
		<div class="gallery-carousel images">
	
		<?php
		
			if($large_image_count > 0)
			{
				?>
					
							<?php
							foreach($pageposts2 as $post2)
							{

								$meta_id = $post2->meta_value;

								$pageposts12 = $wpdb->get_results( $wpdb->prepare( " SELECT * FROM `".$table_prefix."posts` where ID = %d ", $meta_id ) );

									foreach($pageposts12 as $post12)
									{

										$image_first = $post12->guid;
										$post_title = $post12->post_title;
										?>
											<a data-rel="prettyPhoto[product-gallery]" title="" class="woocommerce-main-image zoom" itemprop="image" href="<?php echo $image_first; ?>">
												<img title="<?php echo $post_title; ?>" alt="<?php echo $post_title; ?>" class="attachment-shop_single wp-post-image" src="<?php echo $image_first; ?>">
											</a>
										<?php
									}
							}
							?>

							
				<?php
			}
			else
			{
				?>
				
					<img alt="Placeholder" src="<?php echo $plugin_dir_url; ?>/images/placeholder.png">
						

				<?php
			}


			
		?>

	</div>
	
	<?php


	if($sale != '')
	{
		?>
			<span class="onsale">Sale!</span>
		<?php
	}

	?>
	<div class="summary entry-summary set-r">

	<h1 class="product_title entry-title" itemprop="name"><?php echo esc_html( get_the_title($pid) ); ?></h1>
	<?php

		$count22 = $wpdb->get_var("SELECT COUNT(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $pid
		AND comment_approved = '1'
		AND meta_value > 0");

		$rating22 = $wpdb->get_var("SELECT SUM(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $pid
		AND comment_approved = '1'");

	if ( $count22 > 0 ) {

			$average = number_format($rating22 / $count22, 2);

			echo '<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			echo '<span class="star-rating" title="'.sprintf(__('Rated %s out of 5', 'woocommerce'), $average).'"><span style="width:'.($average*17).'px"><span itemprop="ratingValue" class="rating">'.$average.'</span> </span></span>';

			echo '</div>';
		}

	?>	
		
		<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

		<p class="price"><?php echo $_product->get_price_html(); ?></p>

			<meta itemprop="price" content="<?php echo esc_html( $_product->get_price() ); ?>" />
			<meta itemprop="priceCurrency" content="<?php echo esc_html( get_woocommerce_currency() ); ?>" />
			<link itemprop="availability" href="http://schema.org/<?php echo esc_html( $_product->is_in_stock() ? 'InStock' : 'OutOfStock' ); ?>" />

		</div>
		
		<div itemprop="description">
			<p><?php echo $_product->post->post_excerpt; ?></p>
		</div>
				
	<form data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>" data-product_id="<?php echo $pid; ?>" enctype="multipart/form-data" method="post" class="variations_form cart">
				<table cellspacing="0" class="variations">
				<tbody>

	<?php
		
		$query232 = $wpdb->get_results("SELECT * FROM `".$table_prefix."posts` WHERE `post_parent` = '$pid' && post_status='publish' && post_type='product_variation' ORDER BY `".$table_prefix."posts`.`menu_order` ASC");
			
		$variation_ids = array();
		
		foreach( $query232 as $query_array )
		{
			$variation_ids[] = $query_array->ID;
		}
		
		$variation_attribute_name = array();
		
		foreach ($available_variations as $prod_variation)
		{
			
			$variation_id = $prod_variation['variation_id'];
			
			
			if($prod_variation['variation_is_visible'] == 1 && $prod_variation['variation_is_active'] == 1 && $prod_variation['is_purchasable'] == 1 )
			{
				
				
				foreach ($prod_variation['attributes'] as $attr_name => $attr_value) 
				{ 
					
					if(!in_array($attr_name,$variation_attribute_name))
					{
						$variation_attribute_name[] = $attr_name;
					}
					
				}
				
			}
		}
		
			$countattr = count($variation_attribute_name);
			
			$ii=1;
			
			foreach ($variation_attribute_name as $attr_name) 
			{ 
				$attr_name_fst =  str_replace("attribute_","","$attr_name");
				
				$attr_name_last =  str_replace("pa_","","$attr_name_fst");
				?>


				<tr>
					<td class="label"><label for="pa_<?php echo $attr_name_last; ?>"><?php echo $attr_name_last; ?></label></td>
					<td class="value">
						<select id="pa_<?php echo $attr_name_last; ?>" data-attribute_name="<?php echo $attr_name; ?>" name="<?php echo $attr_name; ?>">
						
						<?php
						
						$attribute_values = array();

						foreach ($variation_ids as $variation_id) 
						{

							$query2322 = $wpdb->get_results("SELECT * FROM `".$table_prefix."postmeta` WHERE `post_id` = '$variation_id' && meta_key ='$attr_name' ORDER BY `meta_id` ASC ");

							foreach($query2322 as $attribute_value)
							{
								if(!in_array($attribute_value->meta_value,$attribute_values))
								{
									$attribute_values[] = $attribute_value->meta_value;
									
								}
								
							}

						}

							?>
							<option value="">Choose an option…</option>
							<?php
							foreach($attribute_values as $attribute_val)
							{
								if($attribute_val != '')
								{
									?>
										<option class="attached enabled" value="<?php echo $attribute_val; ?>"><?php echo $attribute_val; ?></option>
									<?php
								}
							}
						
						?>

						</select>
						<?php
						
						if($countattr == $ii)
						{
							?>
								<a href="#reset" class="reset_variations" style="visibility: hidden;">Clear selection</a>
							<?php
						}
						?>
					</td>
				</tr>
				
				<?php
				$ii++;
			}
			
		?>

				</tbody>
			</table>

			
			<div style="display: none;" class="single_variation_wrap">
				
				<div class="single_variation"></div>

				<div class="variations_button">
					<div class="qty-r"><input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" step="1"></div>

					<button class="single_add_to_cart_button button alt" type="submit">Add to cart</button>
					
				</div>
				
				
				<input type="hidden" value="<?php echo $pid; ?>" name="add-to-cart">
				<input type="hidden" value="<?php echo $pid; ?>" name="product_id">
				<input type="hidden" value="" class="variation_id" name="variation_id">

			</div>

			
		
	</form>

	<div class="product_meta">
		<?php
		if($product->get_sku() != '')
		{
			?>
				<span class="sku_wrapper">SKU: <span itemprop="sku" class="sku"><?php echo esc_html( $product->get_sku() ); ?></span>.</span>
			<?php
		}
				$term_list1 = wp_get_post_terms($pid,'product_cat',array('fields'=>'ids'));
				$cat_id = (int)$term_list1[0];
				$term_list2 = wp_get_post_terms($pid,'product_cat',array('fields'=>'names'));
				$cat_name = $term_list2[0];
				if($cat_id != '')
				{
					?>
						<span class="posted_in">Category: <a rel="tag" href="<?php echo get_term_link ($cat_id, 'product_cat'); ?>"><?php echo esc_html( $cat_name ); ?></a>.</span>
					<?php
				}
				
				
					$viewdetail_label = "view details";
				
				
					?>
				
					<span class="view_details"><a rel="tag" href="<?php echo get_permalink( $pid ); ?>"><?php echo $viewdetail_label; ?></a></span>
			
					
			
	</div>


</div>
	<?php
	
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
		$plugins_url = plugins_url();	
		
		require_once(dirname(__FILE__).'/all_js.php');
	?>
	
	<script>
	/* <![CDATA[ */
	
	var wc_add_to_cart_variation_params = {"ajax_url":"\/wp-admin\/admin-ajax.php"};
	
	/* ]]> */


	jQuery(document).ready(function($) {
		
		$.getScript("<?php echo $plugins_url; ?>/woocommerce/assets/js/frontend/add-to-cart-variation.min.js");
		
	});

	
	</script>

	<?php
	}

	exit;
}
?>
