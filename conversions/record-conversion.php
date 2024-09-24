<?php

function charter_record_conversion($order_id): void {
	$order = wc_get_order($order_id);
	$order_total = $order->get_total();
	$customer_email = $order->get_billing_email();
}
add_action('woocommerce_thankyou', 'charter_record_conversion', 10, 1);
//add_action('woocommerce_payment_complete', 'charter_record_conversion');
