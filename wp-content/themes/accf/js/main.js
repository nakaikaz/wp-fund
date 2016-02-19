( function( $ ) {

	$( function () {

		// Handling for font size
		var fontSize = 85;

		var initFontSize = Number( $.cookie( 'fontSize' ) );
		if ( initFontSize ) $.cookie( 'fontSize', initFontSize, { path: '/', expires : 365 } );

		$( 'a.font-smaller' ).click( function( e ) {
			e.preventDefault();
			$( 'body' ).css( { 'font-size' : (fontSize -= 5) + '%' } );
			$.cookie( 'fontSize', fontSize, { path: '/', expires : 365 } );
		} );

		$( 'a.font-larger' ).click( function( e ) {
			e.preventDefault();
			$( 'body' ).css( { 'font-size' : (fontSize += 5) + '%' } );
			$.cookie( 'fontSize', fontSize, { path: '/', expires : 365 } );
		} );

		$( 'a.font-small' ).click( function( e) {
			e.preventDefault();
			fontSize = 75;
			$( 'body' ).css( { 'font-size' : fontSize + '%' } );
			$.cookie( 'fontSize', fontSize, { path: '/', expires : 365 } );
		} );

		$( 'a.font-medium' ).click( function( e) {
			e.preventDefault();
			fontSize = 85;
			$( 'body' ).css( { 'font-size' : fontSize + '%' } );
			$.cookie( 'fontSize', fontSize, { path: '/', expires : 365 } );
		} );

		$( 'a.font-large' ).click( function( e) {
			e.preventDefault();
			fontSize = 110;
			$( 'body' ).css( { 'font-size' : fontSize + '%' } );
			$.cookie( 'fontSize', fontSize, { path: '/', expires : 365 } );
		} );

		// Handling for search box
		$( '#s' )
		.blur( function() {
			var $this = $( this );
			if( '' == $this.val() || $this.attr( 'title' ) == $this.val() ) {
				$this.val( $this.attr( 'title' ) );
			}
		} )
		.focus( function() {
			var $this = $( this );
			if( $this.attr( 'title' ) == $this.val() ) {
				$this.val( '' );
			}
		} )
		.parents( '#searchform' ).submit( function() {
			var $s = $( '#s' );
			if( $s.attr( 'title' ) == $s.val() ) {
				$s.triggerHandler( 'focus' );
			}
		} ).end()
		.blur();

		if( typeof $.fn.jqTransform == 'function') {
			$( 'form.jqtransform, form.wpcf7-form' ).jqTransform();
			$( 'input[type="email"], input[type="tel"]' ).jqTransInputText();
		}

	} );

} )( jQuery );