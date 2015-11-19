<?php
wp_enqueue_script('wp-color-picker'); 

wp_enqueue_style('wp-color-picker');

wp_enqueue_media();

global $wpdb,$table_prefix;

$checkqv =  sanitize_text_field( $_POST['checkqv'] );
$buttonlabel =  sanitize_text_field( $_POST['buttonlabel'] );

$win_bag_color =  sanitize_text_field( $_POST['win_bag_color'] );

$but_qk_color =  sanitize_text_field( $_POST['but_qk_color'] );

$col_pop_but_colr =  sanitize_text_field( $_POST['col_pop_but_colr'] );

$col_pop_but_h_colr =  sanitize_text_field( $_POST['col_pop_but_h_colr'] );

$option = 'quick_view';
			$data = array(
			'status'=>$checkqv,
			'button_label'=>$buttonlabel ,
			'popup_bg'=>$win_bag_color,
			'button_quick_view_color'=>$but_qk_color,
			'close_popup_btn_color'=>$col_pop_but_colr,
			'close_popup_btn_hcolor'=>$col_pop_but_h_colr
			);

$new_value = json_encode($data);

if($_POST)
{

	if( sanitize_text_field( $_POST['submit'] ))
	{
		$query_check = update_option( $option, $new_value);
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

 $sql = "select * from wp_options where option_name='quick_view'  ORDER BY `option_id` ASC  limit 1";

$row1=$wpdb->get_row($sql);
$row=json_decode($row1->option_value);


?>

<div id="profile-page" class="wrap">
<?php

	$tab = sanitize_text_field( $_GET['tab'] );

?>
<h2>
 Quick View plugin  Options 
</h2>
	<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=quick_view_setting&amp;tab=general">Setting</a>
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

			<td><input type="checkbox" value="enable" <?php if($row->status == 'enable'){ echo "checked"; } ?> id="checkqv" name="checkqv" ></td>

		</tr>
		
		
		
		
		
	</tbody>	

</table>

<table class="form-table">

	<tbody>

		<h3>Button Options</h3>

		
		<tr id="buttonlabel" class="user-nickname-wrap" style="display:<?php if($qry['buttontype'] == 1){ echo "none"; } ?>">

			<th><label for="buttonlabel">Quick View Button Label</label></th>

			<td><label for="buttonlabel"><input type="text" value="<?php echo $row->button_label; ?>" id="buttonlabel" name="buttonlabel" ></label></td>

		</tr>

		
</tbody>

</table>

<table class="form-table">

<tbody>	

	<h3>General Styling Options</h3>
		
		<tr class="user-user-login-wrap">

			<th><label for="win_bag_color">Window background color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $row->popup_bg; ?>" id="win_bag_color" name="win_bag_color"></td>

		</tr>

		

		<tr class="user-user-login-wrap">

			<th><label for="but_qk_color">Button “Quick View” color</label></th>

			<td><input type="text" class="r 	
Height(px)egular-text" value="<?php echo $row->button_quick_view_color; ?>" id="but_qk_color" name="but_qk_color"></td>

		</tr>

	</tbody>
	
</table>
	
<table class="form-table">

	<tbody>	

		<h3>Content Styling Options</h3>

		<tr class="user-user-login-wrap">

			<th><label for="col_pop_but_colr">Close Popup button color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $row->close_popup_btn_color; ?>" id="col_pop_but_colr" name="col_pop_but_colr"></td>

		</tr>
		
		<tr class="user-user-login-wrap">

			<th><label for="col_pop_but_h_colr">Close Popup button hover color</label></th>

			<td><input type="text" class="regular-text" value="<?php echo $row->close_popup_btn_hcolor; ?>" id="col_pop_but_h_colr" name="col_pop_but_h_colr"></td>

		</tr>

	


	</tbody>

</table>


	<p class="submit"><input type="submit" value="Save changes" class="button button-primary" id="submit" name="submit"></p>

		
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
