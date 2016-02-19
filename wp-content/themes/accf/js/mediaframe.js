(function($) {
	var frame;

	$( function() {

		$('#choose-image').on( 'click', function( event ) {
			var $el = $(this);
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media.frames.customHeader = wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),
				// Tell the modal to show only images.
				library: { type: 'image' },

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal
					close: false
				}
			});

			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first().toJSON();
				var $img = $( '<img>' );
				$img.attr( 'src', attachment.url );
				//Object:
				//attachment.alt - image alt
				//attachment.author - author id
				//attachment.caption
				//attachment.dateFormatted - date of image uploaded
				//attachment.description
				//attachment.editLink - edit link of media
				//attachment.filename
				//attachment.height
				//attachment.icon - don't know WTF?))
				//attachment.id - id of attachment
				//attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
				//attachment.menuOrder
				//attachment.mime - mime type, for example image/jpeg"
				//attachment.name - name of attachment file, for example "my-image"
				//attachment.status - usual is "inherit"
				//attachment.subtype - "jpeg" if is "jpg"
				//attachment.title
				//attachment.type - "image"
				//attachment.uploadedTo
				//attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
				//attachment.width
				$( '#uploaded_image_view').html( $img );
				$( '#upload_image' ).val( attachment.url);
				frame.close();
			});

			frame.open();
		});
	});
}(jQuery));
