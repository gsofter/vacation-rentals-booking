<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
global $woocommerce, $wpdb;
$tax = new WC_Tax();
 

if ( $product->get_price_html() ) :
    // Get the prices
   
   
      $price_incl_tax = wc_get_price_including_tax( $product );  // price with VAT
    $tax_amount     = $price_incl_tax  + $price_incl_tax * ((int)$tax->get_rates_for_tax_class('SV')[2]->tax_rate /100); // VAT amount

    // Display the prices
    ?>
  
    <span class="price tax-price"><?php  echo wc_price( $tax_amount ); ?></span><br>
   
<?php endif ?>
 