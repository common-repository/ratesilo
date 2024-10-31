<?php 
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	if (isset( $_POST['_ratesilo_nonce'] ) && wp_verify_nonce( $_POST['_ratesilo_nonce'], 'save_options' )) {
		if(isset($_POST['ratesilo_floating_enable'])) {
			update_option('ratesilo_floating_enable', intval($_POST['ratesilo_floating_enable']));
		}
		if(isset($_POST['ratesilo_floating_user'])) {
			$regex = "/^[a-zA-Z][A-Za-z0-9.]*$/";
			if(preg_match($regex, $_POST['ratesilo_floating_user'])) {
				update_option('ratesilo_floating_user', sanitize_text_field($_POST['ratesilo_floating_user']));
			}
		}
		if(isset($_POST['ratesilo_floating_position'])) {
			$regex = "/^(left|right)$/";
			if(preg_match($regex, $_POST['ratesilo_floating_position'])) {
				update_option('ratesilo_floating_position', sanitize_text_field($_POST['ratesilo_floating_position']));
			}
		}
		if(isset($_POST['ratesilo_floating_height'])) {
			$regex = "/^[0-9]+(px|%)$/";
			if(preg_match($regex, $_POST['ratesilo_floating_height'])) {
				update_option('ratesilo_floating_height', sanitize_text_field($_POST['ratesilo_floating_height']));
			}
		}
		if(isset($_POST['ratesilo_floating_width'])) {
			$regex = "/^[0-9]+(px|%)$/";
			if(preg_match($regex, $_POST['ratesilo_floating_width'])) {
				update_option('ratesilo_floating_width', sanitize_text_field($_POST['ratesilo_floating_width']));
			}
		}
		if(isset($_POST['ratesilo_floating_count'])) {
			update_option('ratesilo_floating_count', intval($_POST['ratesilo_floating_count']));
		}
		if(isset($_POST['ratesilo_floating_text'])) {
			update_option('ratesilo_floating_text', sanitize_text_field($_POST['ratesilo_floating_text']));
		}
		if(isset($_POST['ratesilo_floating_color'])) {
			$regex = "/^(#)[0-9|a-f|A-F]{6}$/";
			if(preg_match($regex, $_POST['ratesilo_floating_color'])) {
				update_option('ratesilo_floating_color', sanitize_text_field($_POST['ratesilo_floating_color']));
			}
		}
		if(isset($_POST['ratesilo_floating_background'])) {
			$regex = "/^(#)[0-9|a-f|A-F]{6}$/";
			if(preg_match($regex, $_POST['ratesilo_floating_background'])) {
				update_option('ratesilo_floating_background', sanitize_text_field($_POST['ratesilo_floating_background']));
			}
		}
		/*
		if(count($_POST) > 0) {
			foreach($_POST as $key => $value) {
				update_option($key, $value);
			}
		} */
	}
	
?>
<div class="wrap">
<h2>Ratesilo Shortcodes</h2>
<strong>Inline Widget</strong>
<input type="text" class="widefat" readonly="" value="[ratesilo username='YOUR_USERNAME_HERE' type='inline']">

<strong>Grid Widget</strong>
<input type="text" class="widefat" readonly="" value="[ratesilo username='YOUR_USERNAME_HERE' type='grid' columns='3']">

<h2>Ratesilo Floating Widget Options</h2>
	<form method="post">
		<?php wp_nonce_field( 'save_options', '_ratesilo_nonce' ); ?>
		<table><tbody>
			<tr>
				<td><label for="ratesilo_floating_enable">Show Floating Widget</label></td>
				<td>
					<select name="ratesilo_floating_enable">
						<option value="1" <?php echo (get_option("ratesilo_floating_enable", 1) == 1)?'selected=""':'' ?>>Yes</option>
						<option value="0" <?php echo (get_option("ratesilo_floating_enable", 1) == 0)?'selected=""':'' ?>>No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_user">Ratesilo Username</label></td>
				<td><input type="text" name="ratesilo_floating_user" value="<?php echo esc_attr(get_option("ratesilo_floating_user", "")); ?>"></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_position">Position</label></td>
				<td>
					<select name="ratesilo_floating_position">
						<option value="left" <?php echo (esc_attr(get_option("ratesilo_floating_position", "left")) == "left")?'selected=""':'' ?>>Left</option>
						<option value="right" <?php echo (esc_attr(get_option("ratesilo_floating_position", "left")) == "right")?'selected=""':'' ?>>Right</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_height">Height</label></td>
				<td><input type="text" name="ratesilo_floating_height" value="<?php echo esc_attr(get_option("ratesilo_floating_height", "400px")); ?>"></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_width">Width</label></td>
				<td><input type="text" name="ratesilo_floating_width" value="<?php echo esc_attr(get_option("ratesilo_floating_width", "300px")); ?>"></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_count">Number of reviews to show</label></td>
				<td><input type="text" name="ratesilo_floating_count" value="<?php echo intval(get_option("ratesilo_floating_count", 0)); ?>"> <small>0 to show all</small></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_text">Label Text</label></td>
				<td><input type="text" name="ratesilo_floating_text" value="<?php echo esc_attr(get_option("ratesilo_floating_text", "Why People Like Us?")); ?>"></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_color">Label Font Color</label></td>
				<td><input type="color" name="ratesilo_floating_color" value="<?php echo esc_attr(get_option("ratesilo_floating_color", "#FFFFFF")); ?>"></td>
			</tr>
			<tr>
				<td><label for="ratesilo_floating_background">Label Background</label></td>
				<td><input type="color" name="ratesilo_floating_background" value="<?php echo esc_attr(get_option("ratesilo_floating_background", "#1BA1E2")); ?>"></td>
			</tr>
		</tbody></table>
		
		<button type="submit" class="button primary-button large-button">Update Options</button>
	</form>
</div>