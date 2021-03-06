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
wp_enqueue_media();
?>
<div class="form-field term-image">
	<label for="term-image"><?php echo esc_html__( 'Image', 'nano' );?></label>
	<div class="term-image-thumb">
		<img class="image" src="<?php echo get_template_directory_uri().'/images/placeholder.png' ?>" alt="<?php echo esc_html__( 'Image type', 'nano' ); ?>" width="50">
	</div>
	<div class="term-image-control">
		<a href="#" class="button add" title="<?php echo esc_html__( 'Click to select an existing image or upload a new images', 'nano' ); ?>"><?php echo esc_html__( 'Upload/Add Image', 'nano' ); ?></a>
		<a href="#" class="button remove" title="<?php echo esc_html__( 'Remove image selected', 'nano' ); ?>"><?php echo esc_html__( 'Remove', 'nano' ); ?></a>
		<input type="hidden" name="nano_image" id="nano_image" value="" />
	</div>
	<p><?php echo esc_html__( 'Select your image', 'nano' ); ?></p>
</div>
<script>
	(function($) {
		$(document).ready(function() {

			if ( $( '.term-image' ).find( 'input' ).val() ) {
				$( 'a.button.remove' ).show();
			} else {
				$( 'a.button.remove' ).hide();
			}

			$( '.term-image' ).on("click", "a.button.add", function (e) {
				e.preventDefault();

				// Set all variables to be used in scope
				var $addButton         = $(this),
					$imageContainer    = $( '.image' );

				// Create the media frame.
				var file_frame = wp.media.frames.file_frame = wp.media({
					 title: "<?php echo esc_html__( 'Select or upload image', 'nano' ); ?>",
					 library: { // remove these to show all
							type: 'image' // specific mime
					 },
					 button: {
							text: "<?php echo esc_html__( 'Select', 'nano' ); ?>"
					 },
					 multiple: false  // Set to true to allow multiple files to be selected
				});
	 
				// When an image is selected, run a callback.
				file_frame.on('select', function () {
					 // We set multiple to false so only get one image from the uploader
	 
					var attachment = file_frame.state().get('selection').first().toJSON();
	 				
	 				// Insert value to input hidden
					$addButton.siblings('input').val(attachment.url);

					// Add image to thumbnail
					$imageContainer.attr( 'src', attachment.url );

					$( 'a.button.remove' ).show();
				});
				// Finally, open the modal
				file_frame.open();
			});

			$( 'a.button.remove' ).on( 'click', function( e ) {
				e.preventDefault();

				// Remove attribute input
				$(this).siblings( 'input' ).val( '' );

				// Restore image link
				$( '.image' ).attr( 'src', '<?php echo get_template_directory_uri().'/images/placeholder.png'; ?>' );

				$(this).hide();
			} )
		});
	})(jQuery);
</script>