<?php

function charter_set_basket_uuid_handler(): void {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		wp_send_json_error('Invalid request method', 405);
	}
	if (!isset($_POST['secure']) || !wp_verify_nonce($_POST['secure'], 'secure')) {
		wp_send_json_error('Bad request', 400);
	}

	$basket_uuid = $_POST['uuid'];

	try {
		WC()->session->set('_uuid', $basket_uuid);
	} catch (Exception $e) {
		// Fail silently
	}
	try {
		$_SESSION['_uuid'] = $basket_uuid;
	} catch (Exception $e) {
		// Fail silently
	}

	wp_send_json_success([]);
}
add_action('wp_ajax_nopriv_set_basket_uuid', 'charter_set_basket_uuid_handler');
add_action('wp_ajax_set_basket_uuid', 'charter_set_basket_uuid_handler');
