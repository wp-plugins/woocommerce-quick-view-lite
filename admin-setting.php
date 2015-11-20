<?php
wp_enqueue_script('wp-color-picker'); 

wp_enqueue_style('wp-color-picker');

wp_enqueue_media();

global $wpdb,$table_prefix;

$checkqv =  sanitize_text_field( $_POST['checkqv'] );

$popupsize1 =  sanitize_text_field( $_POST['popupsize1'] );

$popupsize2 =  sanitize_text_field( $_POST['popupsize2'] );

$buttonlabel =  sanitize_text_field( $_POST['buttonlabel'] );

$win_bag_color =  sanitize_text_field( $_POST['win_bag_color'] );

$but_qk_color =  sanitize_text_field( $_POST['but_qk_color'] );

$col_pop_but_colr =  sanitize_text_field( $_POST['col_pop_but_colr'] );

$col_pop_but_h_colr =  sanitize_text_field( $_POST['col_pop_but_h_colr'] );

if($_POST)
{

	if( sanitize_text_field( $_POST['submit'] ) == 'Save')
	{
		$query_check = $wpdb->query( $wpdb->prepare( "UPDATE `".$table_prefix."quick_view_settings` SET `checkqv` = '$checkqv', `popupsize1` = '$popupsize1', `popupsize2` = '$popupsize2' , `buttonlabel` = '$buttonlabel',`win_bag_color` = '$win_bag_color', `but_qk_color` = '$but_qk_color' , `col_pop_but_colr` = '$col_pop_but_colr', `col_pop_but_h_colr` = '$col_pop_but_h_colr'" ) );
	}

		if($query_check == 1)
		{
		?>

			<div class="updated" id="message">

				<p><strong>Setting updated.</strong></p>

			</div>

		<?php
		}
		else
		{
			?>
				<div class="error below-h2" id="message"><p> Something Went Wrong Please Try Again With Valid Data.</p></div>
			<?php
		}
}

$qry22 = $wpdb->get_results("SELECT * FROM `".$table_prefix."quick_view_settings` ORDER BY `id` ASC  limit 1",ARRAY_A);	

foreach($qry22 as $qry)

{

	

}

?>

<div id="profile-page" class="wrap">
<?php

	$tab = sanitize_text_field( $_GET['tab'] );

?>
<h2>
WooCommerce Quick View - Plugin Options
</h2>
	<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=quick_view_setting&amp;tab=general">General</a>
			<a class="nav-tab <?php if($tab == 'premium'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=quick_view_setting&amp;tab=premium">Premium</a>
	</h2>

<form novalidate="novalidate" method="post" action="" >
<?php 
if($tab == 'general' || $tab == '')
{
	
?>
<table class="form-table">

	<tbody>

		<h3>General Options</h3>
		
		<tr class="user-nickname-wrap">

			<th><label for="checkqv">Enable Quick View</label></th>

			<td><input type="checkbox" value="1" <?php if($qry['checkqv'] == 1){ echo "checked"; } ?> id="checkqv" name="checkqv" ></label></td>

		</tr>
		
		<tr class="user-nickname-wrap">

			<th><label for="popupsize1">Quick View Popup Size</label></th>

			<td><span class="long"><label class="up grey">Height(px)<input type="text" name="popupsize1" id="popupsize1" value="<?php echo $qry['popupsize1']; ?>" class="regular-text up" style="width:100px"></label></span><span class="px-multiply">&nbsp; X &nbsp;  </span>
			
			<span class="wid"><label class="up grey">Width(px)<input type="text" name="popupsize2" id="popupsize2" value="<?php echo $qry['popupsize2']; ?>" class="regular-text up" style="width:100px"></label></span><span class="px-multiply">&nbsp;</td>

		</tr>
	</tbody>	

</table>

<table class="form-table">

	<tbody>

		<h3>Button Options</h3>

		
		<tr id="buttonlabel" class="user-nickname-wrap" style="display:<?php if($qry['buttontype'] == 1){ echo "none"; } ?>">

			<th><label for="buttonlabel">Quick View Button Label</label></th>

			<td><label for="buttonlabel"><input type="text" value="<?php echo $qry['buttonlabel']; ?>" id="buttonlabel" name="buttonlabel" ></label></td>

		</tr>

		
</tbody>

</table>

<table class="form-table">

<tbody>	

	<h3>General Styling Options</h3>
		
		<tr class="user-user-login-wrap">

			<th><label for="win_bag_color">Window background color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['win_bag_color']; ?>" id="win_bag_color" name="win_bag_color"></td>

		</tr>

		

		<tr class="user-user-login-wrap">

			<th><label for="but_qk_color">Button “Quick View” color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['but_qk_color']; ?>" id="but_qk_color" name="but_qk_color"></td>

		</tr>

	</tbody>
	
</table>
	
<table class="form-table">

	<tbody>	

		<h3>Content Styling Options</h3>

		<tr class="user-user-login-wrap">

			<th><label for="col_pop_but_colr">Close Popup button color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['col_pop_but_colr']; ?>" id="col_pop_but_colr" name="col_pop_but_colr"></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="col_pop_but_h_colr">Close Popup button hover color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $qry['col_pop_but_h_colr']; ?>" id="col_pop_but_h_colr" name="col_pop_but_h_colr"></td>

		</tr>

	


	</tbody>

</table>


	<p class="submit"><input type="submit" value="Save" class="button button-primary" id="submit" name="submit"></p>

		
<?php
}
if($tab == 'premium')
{
	require_once(dirname(__FILE__).'/premium-setting.php');
}
?>

</form>

</div>

<script>

jQuery(document).ready(function($)

{

	jQuery("#win_bag_color").wpColorPicker();

	jQuery("#but_qk_color").wpColorPicker();

	
	jQuery("#col_pop_but_colr").wpColorPicker();
	
	jQuery("#col_pop_but_h_colr").wpColorPicker();


	var custom_upload;

	
	$(document).on("click",".uploadimage",uploadimage_button);

    function uploadimage_button(){

		textid = this.id+'1';

        var custom_upload = wp.media({

        title: 'Add Media',

        button: {

            text: 'Insert Image'

        },

        multiple: false  // Set this to true to allow multiple files to be selected

    })

    .on('select', function() {

        var attachment = custom_upload.state().get('selection').first().toJSON();

        $('.custom_media_image').attr('src', attachment.url);

        $('#'+textid).val(attachment.url);

        

    })

    .open();

 

    }

		
});

</script>
<style>
.form-table th {
    width: 270px;
	padding: 25px;
}
.form-table td {
	
    padding: 20px 10px;
}
.form-table {
	background-color: #fff;
}
h3 {
    padding: 10px;
}
.px-multiply{ color:#ccc; vertical-align:bottom;}


.long{ display:inline-block; vertical-align:middle; }

.wid{ display:inline-block; vertical-align:middle; }

.up{ display:block;}

.grey{ color:#b0adad;}
</style>