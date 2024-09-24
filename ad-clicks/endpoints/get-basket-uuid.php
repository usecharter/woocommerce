<?php

function charter_get_basket_uuid_handler(): void {
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		wp_send_json_error('Invalid request method', 405);
	}
	if (!isset($_GET['secure']) || !wp_verify_nonce($_GET['secure'], 'secure')) {
		wp_send_json_error('Bad request', 400);
	}

	$wc_session_uuid = WC()->session->get('_uuid');
	$php_session_uuid = $_SESSION['_uuid'];

	$basket_uuid = $wc_session_uuid ?? $php_session_uuid ?? null;

	wp_send_json_success(['uuid' => $basket_uuid]);
}
add_action('wp_ajax_nopriv_get_basket_uuid', 'charter_get_basket_uuid_handler');
add_action('wp_ajax_get_basket_uuid', 'charter_get_basket_uuid_handler');
