<?php

function charter_register_settings(): void {
	register_setting('charter_option_group', 'charter_api_token');
}
add_action('admin_init', 'charter_register_settings');
