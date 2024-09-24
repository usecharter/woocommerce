<?php

function charter_admin_page(): void { ?>
	<div class="wrap">
		<h1>Charter</h1>
		<form method="post" action="options.php" style="width: 100%; max-width: 700px;">
			<?php
			settings_fields('charter_option_group');
			do_settings_sections('charter');

			$api_token = get_option('charter_api_token', '');
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="charter_api_token">API Token</label>
					</th>
					<td>
						<input id="charter_api_token" type="text" name="charter_api_token" value="<?php echo esc_attr($api_token); ?>" style="width: 100%;">
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
<?php }