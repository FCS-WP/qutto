<?php
$coupon_code = 'first_order_20';
$min_order_total = 60;

$errors = [
    "registered_only" => "This coupon only using for registered user",
    "invalid" => "Invalid Coupon",
];

// Check if customer has previous orders
function is_first_order_for_registered_customer($user_id = 0)
{
    // only for registered users
    if ($user_id <= 0) {
        return false;
    }

    // count the number of completed orders
    $customer_orders = wc_get_customer_order_count($user_id);

    return $customer_orders == 0;
}

add_action('woocommerce_cart_calculate_fees', 'apply_coupon_on_cart_update');
function apply_coupon_on_cart_update()
{
    global $min_order_total;
    if (!is_user_logged_in())
        return;

    $user_id = get_current_user_id();
    if (!is_first_order_for_registered_customer($user_id))
        return;

    $cart = WC()->cart;
    $cart_total = $cart->get_subtotal();
    $applied_coupons = $cart->get_applied_coupons();
    $has_first_order_coupon = in_array('first_order_20', $applied_coupons);


    if ($cart_total >= $min_order_total) {
        // apply cp if sub total >= 60
        if (!$has_first_order_coupon) {
            $cart->apply_coupon('first_order_20');
            $cart->calculate_totals();
        }
    } else {
        // remove coupon if subtotal < 60
        if ($has_first_order_coupon) {
            $cart->remove_coupon('first_order_20');
            $cart->calculate_totals();
        }
    }
    
}

// Validate coupon in checkout process
add_action('woocommerce_checkout_process', 'validate_first_order_discount_registered_only');
function validate_first_order_discount_registered_only()
{

    global $coupon_code;
    global $errors;


    // get all applied coupons
    $applied_coupons = WC()->cart->get_applied_coupons();

    if (in_array($coupon_code, $applied_coupons)) {

        // if user logged in
        if (!is_user_logged_in()) {
            WC()->cart->remove_coupon($coupon_code);
            wc_add_notice($errors['registered_only'], 'error');
            return;
        }

        $user_id = get_current_user_id();

        // If not first order
        if (!is_first_order_for_registered_customer($user_id)) {
            WC()->cart->remove_coupon($coupon_code);
            wc_add_notice($errors['invalid'], 'error');
        }
    }
}

// restrict cp in cart
add_filter('woocommerce_coupon_is_valid', 'restrict_first_order_coupon_usage_to_registered_users_only', 10, 3);
function restrict_first_order_coupon_usage_to_registered_users_only($valid, $coupon, $discount)
{
    global $coupon_code;
    global $errors;

    if ($coupon->get_code() == $coupon_code) {
        if (!is_user_logged_in()) {
            throw new Exception($errors['invalid']);
        }

        $user_id = get_current_user_id();

        if (!is_first_order_for_registered_customer($user_id)) {
            throw new Exception($errors['invalid']);
        }
    }

    return $valid;
}

?>