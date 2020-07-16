<?php
/**
 * Nano Core Plugin
 * @package     Nano Core
 * @version     0.1
 * @author      Nanoliberty
 * @link        http://www.nanoliberty.co
 * @copyright   Copyright (c) 2015 Nanoliberty
 * @license     GPL v2
 */

// Enqueue Color Picker.
wp_enqueue_script( 'wp-color-picker' );
wp_enqueue_style( 'wp-color-picker' );

?>
<div class="form-field term-color-picker">
	<label for="nano_colorpicker"><?php echo esc_html__( 'Color', 'nano' );?></label>
	<input type="text" name="nano_colorpicker" id="nano_colorpicker" value="" />
	<p><?php echo esc_html__( 'Please pick a color', 'nano' ); ?></p>
</div>
<script>
	(function($) {
		$(document).ready(function() {
			$( '.term-color-picker input#nano_colorpicker' ).wpColorPicker();
		});
	})(jQuery);
</script>