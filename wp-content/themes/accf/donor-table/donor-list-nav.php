<?php
namespace Donor;
function get_pagenum_link( $pagenum = 1 ) {
	global $wp_rewrite;
	$pagenum = (int)$pagenum;
	$request = remove_query_arg( 'paged' );
	$home_root = parse_url( home_url() );
	$home_root = isset( $home_root['path'] ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|') ;
	$request = preg_replace( '|^' . $home_root . '|i', '', $request );
	$request = preg_replace( '|^/+|', '', $request );
	if( !$wp_rewrite->using_permalinks() || is_admin() ) {
		$base = trailingslashit( get_bloginfo( 'url') );
		if( $pagenum > 1) {
			$result = add_query_arg( 'paged', $pagenum, $base . $request );
		} else {
			$result = $base . $request;
		}
	} else {
		$gs_regex = '|\?.*?$|';
		preg_match( $gs_regex, $request, $gs_match );
		if( !empty( $gs_match[0] ) ) {
			$query_string = $gs_match[0];
			$request = preg_replace( $gs_regex, '', $request );
		} else {
			$query_string = '';
		}
		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
		$request = preg_replace( '|^index\.php|i', '', $request );
		$request = ltrim( $request, '/' );

		$base = trailingslashit( get_bloginfo( 'url' ) );

		if( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
			$base .= 'index.php/';

		if( $pagenum > 1 ) {
			$request = ( ( !empty($request) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $pagenum, 'paged' );
		}

		$result = $base . $request .$query_string;
	}

	return esc_url_raw( $result );
}

function get_previous_posts_link( $label ) {
	$paged = get_query_var( 'paged' );
	$nextpage = intval( $paged ) - 1;
	if( $nextpage < 1 )
		$nextpage = 1;
	if( intval( $paged ) > 1) {
		$link = get_pagenum_link( $nextpage );
		return '<a href="' . $link . '">'. $label .'</a>';
	}
	return '';
}

function get_next_posts_link($label = null, $max_page = 0 ) {
	global $wp_query;
	$paged = get_query_var( 'paged' );

	if ( !$max_page )
		$max_page = $wp_query->max_num_pages;

	if ( !$paged )
		$paged = 1;

	$nextpage = intval( $paged ) + 1;

	if ( null === $label )
		$label = __( 'Next Page &raquo;' );

	$link = get_pagenum_link( $nextpage );

	if ( $nextpage <= $max_page ) {
		return '<a href="' . $link . '">' . $label . '</a>';
	}

	return '';
}

?>