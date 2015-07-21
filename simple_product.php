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
		
	$pageposts1 = $wpdb->get_results( " SELECT * FROM `".$table_prefix."postmeta` WHERE `post_id` = $pid && meta_key='_product_image_gallery' && meta_value !='' " );

	$thumbnail_count1 = $wpdb->get_results( " SELECT * FROM `".$table_prefix."postmeta` WHERE `post_id` = $pid && meta_key='_product_image_gallery' && meta_value !='' " );

	foreach($thumbnail_count1 as $thumbnail_count)
	{
		$meta_ids = explode(",",$thumbnail_count->meta_value);
		
	}

	$thumbnail_counts =  count($meta_ids);

	if($_product->product_type == 'simple')
	{
		
	?>
	<div class="post-<?php echo $pid; ?> product type-product status-publish has-post-thumbnail shipping-taxable purchasable product-type-simple instock" id="product-<?php echo $pid; ?>" itemtype="http://schema.org/Product" itemscope="">

	<?php

	$sale = get_post_meta( $pid, '_sale_price', true);

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
		AND comment_approved = '1'
	");

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
				
		<?php
		
		$_regular_price = get_post_meta( $pid, '_regular_price', true);
		
		if($_regular_price)
		{
			?>
			<form enctype="multipart/form-data" method="post" class="cart">
				
				<div class="qty-r"><input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1"></div>

				<input type="hidden" value="<?php echo $pid; ?>" name="add-to-cart" />

				<!--<a class="single_add_to_cart_button button alt">Add to cart</a>-->
				<button class="single_add_to_cart_button button alt" type="submit">Add to cart</button>
				
				
			</form>
			<?php
		}
		
		?>
		
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
			
					<span class="view_details"><a rel="tag" href="<?php echo get_permalink( $pid ); ?>"><?php echo esc_html( $viewdetail_label ); ?></a></span>
		
				
		</div>

	</div><!-- .summary -->

	</div><!-- #product-8 -->
	
	<?php
	
		
		$plugin_dir_url =  esc_url( plugin_dir_url( __FILE__ ) );
		
		$plugins_url = plugins_url();	
		
		require_once(dirname(__FILE__).'/all_js.php');
	
	}
	
	exit;
}
?>