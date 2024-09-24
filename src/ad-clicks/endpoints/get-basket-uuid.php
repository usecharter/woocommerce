<?php

function charter_get_basket_uuid_handler(): void {
	if (isset($_SERVER) && $_SERVER['REQUEST_METHOD'] !== 'GET') {
		wp_send_json_error('Invalid request method', 405);
        exit;
	}
    if (!isset($_GET['secure'])) {
        wp_send_json_error('Bad request', 400);
        exit;
    }
    $nonce = filter_var(wp_unslash($_GET['secure']), FILTER_SANITIZE_SPECIAL_CHARS);

	if (!wp_verify_nonce($nonce, 'secure')) {
		wp_send_json_error('Bad request', 400);
	}

	$wc_session_uuid = WC()->session->get('_uuid');
	$php_session_uuid = isset($_SESSION['_uuid']) ? filter_var(wp_unslash($_SESSION['_uuid']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

	$basket_uuid = $wc_session_uuid ?? $php_session_uuid ?? null;

	wp_send_json_success(['uuid' => $basket_uuid]);
}
add_action('wp_ajax_nopriv_get_basket_uuid', 'charter_get_basket_uuid_handler');
add_action('wp_ajax_get_basket_uuid', 'charter_get_basket_uuid_handler');
