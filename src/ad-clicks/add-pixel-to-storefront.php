<?php

function charter_enqueue_script(): void {
	wp_enqueue_script('charter-pixel', 'https://usecharter.io/pixel.js', [], '1.0', true);

	wp_localize_script('charter-pixel', 'charter', [
		'url' => admin_url('admin-ajax.php'),
		'secure' => wp_create_nonce('secure')
	]);
}
add_action('wp_enqueue_scripts', 'charter_enqueue_script');
