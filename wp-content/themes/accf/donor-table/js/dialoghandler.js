( function( $ ) {
	
	$( '#donor-form-dialog' ).dialog( {
		autoOpen: false,
		height: 500,
		width:400,
		closeOnEscape: false,
		modal: true,
		buttons: [{
				id: 'save-button',
				text: ' 保 存 ',
				click: function() {
					$( this ).dialog( 'close' );
				}
			},{
				id:'cancel-button',
				text: 'キャンセル',
				click: function() {
					$( this ).dialog( 'close' );
				}
		}]
	} );
	
	$( 'a.donor-add' ).click( function( event ) {
		event.preventDefault();
		$( '#donor-form-dialog' ).dialog( 'open' );
	} );
	
} )( jQuery );