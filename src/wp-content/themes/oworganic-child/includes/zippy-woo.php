<?php
$coupon_code = 'first_order_20';
$errors = [
    "registed_only" => "This coupon only using for registered user",
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

// apply coupon for first order
add_action('woocommerce_before_calculate_totals', 'apply_first_order_discount_for_registered_user');
function apply_first_order_discount_for_registered_user($cart)
{
    global $coupon_code;

    if (is_admin() && !defined('DOING_AJAX'))
        return;
    if (did_action('woocommerce_before_calculate_totals') >= 2)
        return;

    // is user logged in
    if (!is_user_logged_in()) {
        return;
    }

    // check if coupon is already applied
    $applied_coupons = $cart->get_applied_coupons();
    if (in_array($coupon_code, $applied_coupons))
        return;

    $user_id = get_current_user_id();

    // apply coupon if first order
    if (is_first_order_for_registered_customer($user_id)) {
        $cart->apply_coupon($coupon_code);
    }
}

// Validate coupon in checkout process
add_action('woocommerce_checkout_process', 'validate_first_order_discount_registered_only');
function validate_first_order_discount_registered_only()
{

    global $coupon_code;
    global $errors;

    $applied_coupons = WC()->cart->get_applied_coupons();

    if (in_array($coupon_code, $applied_coupons)) {

        // if user logged in
        if (!is_user_logged_in()) {
            WC()->cart->remove_coupon($coupon_code);
            wc_add_notice($errors['registed_only'], 'error');
            return;
        }

        $user_id = get_current_user_id();

        // If first order
        if (!is_first_order_for_registered_customer($user_id)) {
            // 
            WC()->cart->remove_coupon($coupon_code);
            wc_add_notice($errors['registed_only'], 'error');
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