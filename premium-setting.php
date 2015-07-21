<?php
$plugin_dir_url =  plugin_dir_url( __FILE__ );
?>
<style>
.premium-box{ width:100%; height:auto; background:#fff;  }
.premium-features{}
.premium-heading{  color: #484747;font-size: 40px;padding-top: 35px;text-align: center;text-transform: uppercase;}
.premium-features li{ width:100%; float:left;  padding: 80px 0; margin: 0; }
.premium-features li .detail{ width:50%; }
.premium-features li .img-box{ width:50%; }

.premium-features li:nth-child(odd) { background:#f4f4f9; }
.premium-features li:nth-child(odd) .detail{float:right; text-align:left; }
.premium-features li:nth-child(odd) .detail .inner-detail{}
.premium-features li:nth-child(odd) .detail p{ }
.premium-features li:nth-child(odd) .img-box{ float:left; text-align:right;}

.premium-features li:nth-child(even){  }
.premium-features li:nth-child(even) .detail{ float:left; text-align:right;}
.premium-features li:nth-child(even) .detail .inner-detail{ margin-right: 46px;}
.premium-features li:nth-child(even) .detail p{ float:right;} 
.premium-features li:nth-child(even) .img-box{ float:right;}

.premium-features .detail{}
.premium-features .detail h2{ color: #484747;  font-size: 24px; font-weight: 700; padding: 0;}
.premium-features .detail p{  color: #484747;  font-size: 13px;  max-width: 327px;}

/**images**/
.custom-button-type-options{ background:url(<?php echo $plugin_dir_url; ?>images/custom-button-type-options.png); width:502px; height:196px; display:inline-block; margin-right: 25px; background-repeat:no-repeat;}

.product-navigation{ background:url(<?php echo $plugin_dir_url; ?>images/product-navigation.png); width:496px; height:237px; display:inline-block; background-size:500px auto; margin-right:30px; background-repeat:no-repeat;}

.product-option{ background:url(<?php echo $plugin_dir_url; ?>images/product-option.png); width:363px; height:464px; display:inline-block; background-repeat:no-repeat;}

.product-image-size{background:url(<?php echo $plugin_dir_url; ?>images/product-image-size.png); width:469px; height:395px; display:inline-block; margin-right:30px; background-repeat:no-repeat;}

.product-upload{background:url(<?php echo $plugin_dir_url; ?>images/product-upload.png); width:490px; height:392px; display:inline-block; background-repeat:no-repeat;}

.product-view{background:url(<?php echo $plugin_dir_url; ?>images/product-view.png); width:509px; height:195px; display:inline-block; margin-right:30px; background-repeat:no-repeat;}

.styling-option{background:url(<?php echo $plugin_dir_url; ?>images/styling-option.png); width:300px; height:721px; display:inline-block; background-repeat:no-repeat;}

/*upgrade css*/

.upgrade{background:#f4f4f9;padding: 50px 0; width:100%; clear: both;}
.upgrade .upgrade-box{ background-color: #808a97;
    color: #fff;
    margin: 0 auto;
   min-height: 110px;
    position: relative;
    width: 60%;}

.upgrade .upgrade-box p{ font-size: 15px;
     padding: 19px 20px;
    text-align: center;}

.upgrade .upgrade-box a{background: none repeat scroll 0 0 #6cab3d;
    border-color: #ff643f;
    color: #fff;
    display: inline-block;
    font-size: 17px;
    left: 50%;
    margin-left: -150px;
    outline: medium none;
    padding: 11px 6px;
    position: absolute;
    text-align: center;
    text-decoration: none;
    top: 36%;
    width: 277px;}

.upgrade .upgrade-box a:hover{background: none repeat scroll 0 0 #72b93c;}

.premium-vr{ text-transform:capitalize;} 

</style>







<div class="premium-box">


<div class="upgrade">
<div class="upgrade-box">
<!--<p> Switch to the premium version of Woocommerce Check Pincode/Zipcode for Shipping and COD to get the benefit of all features! </p>
--><a target="_blank" href="http://www.phoeniixx.com/product/woocommerce-quick-view/"><b>UPGRADE</b> to the <span class="premium-vr">premium version</span></a>

</div>
</div>

<ul class="premium-features">
<h1 class="premium-heading">Premium Features</h1>
<li>

<div class="img-box"><span class="custom-button-type-options"></span></div>

 <div class="detail">
 <div class="inner-detail">
   <h2>Custom Button Type Options</h2>
    <p>
       This option allows you to choose whether you want a text or an icon based plugin, so that you get to design the button to fit with your site theme.
    </p>
  </div>
  </div> 
</li>


<li>
 <div class="detail">
  <div class="inner-detail">
   <h2>Product Navigation via Quick View:</h2>
    <p>
      Opening different popups for different products takes up a lot of time. This option gives you navigation arrows in a single popup so customers can browse freely.
    </p>
   </div> 
 </div>
 <div class="img-box"><span class="product-navigation"></span></div>
</li>


<li>
<div class="img-box"><span class="product-option"></span></div>

 <div class="detail">
 <div class="inner-detail">
   <h2>Product Options:</h2>
    <p>
       You can pick the content you want to appear on your popup box based on your database. Create custom popup content just for your site.
    </p>
  </div> 
  </div>
</li>


<li>
 <div class="detail">
  <div class="inner-detail">
   <h2>Product Image sizes:</h2>
    <p>
By choosing the image sizes of product image and other icons in the popup box you can design the popup box based on any design you want    
</p>
   </div> 
 </div>
 <div class="img-box"><span class="product-image-size"></span></div>
</li>

<li>

<div class="img-box"><span class="product-upload"></span></div>

 <div class="detail">
 <div class="inner-detail">
   <h2>Product Image Uploads:</h2>
    <p>
Choose images for navigation arrows that gel with your complete popup design.    
</p>
  </div> 
  </div>
</li>


<li>
 <div class="detail">
  <div class="inner-detail">
   <h2>Product "View Details":</h2>
    <p>
    With this neat feature customers can jump right onto the product page through the popup box making browsing easier for your customers.
    </p>
   </div> 
 </div>
 <div class="img-box"><span class="product-view"></span></div>
</li>


<li>
 <div class="detail">
  <div class="inner-detail">
   <h2>Styling Options:</h2>
    <p>
These complete styling options give you the freedom to create a popup box that is in line with the theme of your website.
    </p>
   </div> 
 </div>
 <div class="img-box"><span class="styling-option"></span></div>
</li>




</ul>

<div class="upgrade">
<div class="upgrade-box">
<!--<p> Switch to the premium version of Woocommerce Check Pincode/Zipcode for Shipping and COD to get the benefit of all features! </p>
--><a target="_blank" href="http://www.phoeniixx.com/product/woocommerce-quick-view/"><b>UPGRADE</b> to the <span class="premium-vr">premium version</span></a>
</div>

</div>


</div>

