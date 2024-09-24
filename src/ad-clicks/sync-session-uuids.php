<?php

// Start session and sync WooCommerce session UUID with PHP session UUID.
function charter_start_session(): void {
	if (!session_id()) {
		session_start();
	}
	if (!WC()->session) {
		return;
	}

	$wc_session_uuid = WC()->session->get('_uuid');
    $php_session_uuid = isset($_SESSION['_uuid']) ? filter_var(wp_unslash($_SESSION['_uuid']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

	if (($wc_session_uuid && $php_session_uuid && $wc_session_uuid !== $php_session_uuid) || (!$wc_session_uuid && $php_session_uuid)) {
		WC()->session->set('_uuid', $php_session_uuid);
	} elseif ($wc_session_uuid && !$php_session_uuid) {
		$_SESSION['_uuid'] = $wc_session_uuid;
	}
}
add_action('woocommerce_init', 'charter_start_session', 1);
