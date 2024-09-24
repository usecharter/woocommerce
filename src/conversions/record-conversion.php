<?php

function charter_record_conversion($order_id): void {
	if (!$order_id) return;

	try {
		$order = wc_get_order($order_id);

		$order_total = $order->get_total();
		$shipping_total = floatval($order->get_shipping_total());
		$order_discount = floatval($order->get_discount_total());

		$net_total = $order_total - $shipping_total - $order_discount;

		$email_hash = md5($order->get_billing_email());
		$customer_ip = $order->get_customer_ip_address();
		$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

		$client_uuid = null;
		if (!empty($_COOKIE['client'])) {
			$client_uuid = $_COOKIE['client'];
		} elseif (!empty($_SESSION['_uuid'])) {
			$client_uuid = $_SESSION['_uuid'];
		} elseif (WC()->session && !empty(WC()->session->get('_uuid'))) {
			$client_uuid = WC()->session->get('_uuid');
		}
		$data = [
			'value' => $net_total,
			'email_hash' => $email_hash,
			'ip' => $customer_ip,
			'user_agent' => $user_agent,
			'client' => $client_uuid
		];
		wp_remote_post('http://localhost:6333/conversion', [
			'method'    => 'POST',
			'body'      => wp_json_encode($data),
			'headers'   => [
				'Content-Type' => 'application/json',
			],
		]);
	} catch (Exception $e) {}
}
add_action('woocommerce_payment_complete', 'charter_record_conversion');
