<?php
while ( have_posts() ) : the_post(); ?>

	 <div class="product">

		<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?> >

			<?php do_action( 'ph_wcqv_product_image' ); ?>

			<div class="summary entry-summary">
				<div class="summary-content">
					<?php do_action( 'ph_wcqv_product_summary' ); ?>
				</div>
			</div>

		</div>

	</div>

	<?php endwhile; //end of the loop.
?>