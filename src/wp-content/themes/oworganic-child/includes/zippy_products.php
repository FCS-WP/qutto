<?php
$in_store_message = "This product is available only in stores";

add_action('woocommerce_single_product_summary', 'custom_only_in_store_message', 1);

function custom_only_in_store_message()
{
    global $product;
    global $in_store_message;
    $product_slug = $product->get_slug();

    if ($product_slug == "snacks") {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        add_action('woocommerce_single_product_summary', function() use ($in_store_message) {
            echo '<p style="font-size: 16px; margin-top: 15px"><span class="product-unavailable">' . $in_store_message . '</span></p>';
        }, 30);
    }
}

add_filter('woocommerce_add_to_cart_validation', 'prevent_snacks_add_to_cart', 10, 3);
function prevent_snacks_add_to_cart($passed, $product_id, $quantity)
{
    $product = wc_get_product($product_id);
    global $in_store_message;

    if ($product && $product->get_slug() == 'snacks') {
        wc_add_notice(__($in_store_message, 'woocommerce'), 'error');
        return false;
    }

    return $passed;
}

add_filter('woocommerce_loop_add_to_cart_link', 'remove_snacks_add_to_cart_button', 10, 2);
function remove_snacks_add_to_cart_button($button, $product)
{
    if ($product->get_slug() === 'snacks') {
        return '';
    }
    return $button;
}