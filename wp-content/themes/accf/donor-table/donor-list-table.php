<?php
/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if( !class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . '/wp-admin/includes/class-wp-list-table.php';
}

class Donor_List_Table extends WP_List_Table {

	function __construct( ) {
		parent::__construct( array(
			'singular' => 'donor',		//singular name of the listed records
			'plural' => 'donors',		//plural name of the listed records
			'ajax' => false			//does this table support ajax?
		) );
	}

	/** ************************************************************************
	 * Recommended. This method is called when the parent class can't find a method
	 * specifically build for a given column. Generally, it's recommended to include
	 * one method for each column you want to render, keeping your package class
	 * neat and organized. For example, if the class needs to process a column
	 * named 'title', it would first see if a method named $this->column_title()
	 * exists - if it does, that method will be used. If it doesn't, this one will
	 * be used. Generally, you should try to use custom column methods as much as
	 * possible.
	 *
	 * Since we have defined a column_title() method later on, this method doesn't
	 * need to concern itself with any column with a name of 'title'. Instead, it
	 * needs to handle everything else.
	 *
	 * For more detailed insight into how columns are handled, take a look at
	 * WP_List_Table::single_row_columns()
	 *
	 * @param array $item A singular item (one full row's worth of data)
	 * @param array $column_name The name/slug of the column to be processed
	 * @return string Text or HTML to be placed inside the column <td>
	 **************************************************************************/
	function column_default( $item, $column_name) {
		switch ( $column_name ) {
			case 'id':
			case 'name':
			case 'address':
			case 'message':
				return stripslashes( $item[ $column_name ] );
			default:
				return print_r( $item, true );
		}
	}

/** ************************************************************************
	* Recommended. This is a custom column method and is responsible for what
	* is rendered in any column with a name/slug of 'title'. Every time the class
	* needs to render a column, it first looks for a method named
	* column_{$column_title} - if it exists, that method is run. If it doesn't
	* exist, column_default() is called instead.
	*
	* This example also illustrates how to implement rollover actions. Actions
	* should be an associative array formatted as 'slug'=>'link html' - and you
	* will need to generate the URLs yourself. You could even ensure the links
	*
	*
	* @see WP_List_Table::::single_row_columns()
	* @param array $item A singular item (one full row's worth of data)
	* @return string Text to be placed inside the column <td> (movie title only)
	**************************************************************************/
	function column_name( $item ) {

		$actions = array(
			'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Edit' ) . '</a>', FORM_PAGE, 'edit', $item['id'] ),
			//'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Delete' ) . '</a>', FORM_PAGE, 'delete', $item['id'] )
		);

		return sprintf( '%1$s %2$s', stripslashes( $item['name'] ), $this->row_actions($actions));
	}

	function column_address( $item ) {

		$actions = array(
			'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Edit' ) . '</a>', FORM_PAGE, 'edit', $item['id'] ),
			//'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Delete' ) . '</a>', FORM_PAGE, 'delete', $item['id'] )
		);

		return sprintf( '%1$s %2$s', stripslashes( $item['address'] ), $this->row_actions($actions));
	}

	function column_initial( $item ) {

		$actions = array(
			'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Edit' ) . '</a>', FORM_PAGE, 'edit', $item['id'] ),
		);
		$str = $item['initial'] == 1 ? '設立時寄付者' : '';
		return sprintf( '%1$s %2$s', $str, $this->row_actions($actions));
	}

	function column_message( $item ) {

		$actions = array(
			'edit' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Edit' ) . '</a>', FORM_PAGE, 'edit', $item['id'] ),
			//'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s">' . __( 'Delete' ) . '</a>', FORM_PAGE, 'delete', $item['id'] )
		);

		return sprintf( '%1$s %2$s', stripslashes( $item['message'] ), $this->row_actions($actions) );
	}

    /** ************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
	function column_cb( $item ) {
		return sprintf(
				  '<input type="checkbox" name="id[]" value="%s"/>',
				  $item['id']
		);
	}

	/** ************************************************************************
	 * REQUIRED! This method dictates the table's columns and titles. This should
	 * return an array where the key is the column slug (and class) and the value
	 * is the column's title text. If you need a checkbox for bulk actions, refer
	 * to the $columns array below.
	 *
	 * The 'cb' column is treated differently than the rest. If including a checkbox
	 * column in your table you must create a column_cb() method. If you don't need
	 * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
	 *
	 * @see WP_List_Table::::single_row_columns()
	 * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
	 **************************************************************************/
	function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => __( 'ID' ),
			'name' => __( '名前' ),
			'address' => __( '住所' ),
			'initial' => __( '設立時寄付者' ),
			'message' => __( '応援メッセージ' )
		);
		//$columns = apply_filters( 'tr_form_manage_posts_columns', $columns );
		return $columns;
	}

	/** ************************************************************************
	 * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
	 * you will need to register it here. This should return an array where the
	 * key is the column that needs to be sortable, and the value is db column to
	 * sort by. Often, the key and value will be the same, but this is not always
	 * the case (as the value is a column name from the database, not the list table).
	 *
	 * This method merely defines which columns should be sortable and makes them
	 * clickable - it does not handle the actual sorting. You still need to detect
	 * the ORDERBY and ORDER querystring variables within prepare_items() and sort
	 * your data accordingly (usually by modifying your query).
	 *
	 * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
	 **************************************************************************/
	function get_sortable_columns() {
		$sortable = array(
			'id' => array( 'id', true ),
			'name' => array( 'name', false ),
			'address' => array( 'address', false ),
			'initial' => array( 'initial', false )
		);
		//$sortable = apply_filters( 'tr_form_sortable_columns', $sortable );
		return $sortable;
	}

	/** ************************************************************************
	 * Optional. If you need to include bulk actions in your list table, this is
	 * the place to define them. Bulk actions are an associative array in the format
	 * 'slug'=>'Visible Title'
	 *
	 * If this method returns an empty value, no bulk action will be rendered. If
	 * you specify any bulk actions, the bulk actions box will be rendered with
	 * the table automatically on display().
	 *
	 * Also note that list tables are not automatically wrapped in <form> elements,
	 * so you will need to create those manually in order for bulk actions to function.
	 *
	 * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
	 **************************************************************************/
	function get_bulk_actions() {
		$actions = array(
			 'delete' => __( 'Delete' )
		);
		return $actions;
	}

    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     *
     * @see $this->prepare_items()
     **************************************************************************/
	function process_bulk_action() {
		global $wpdb;
		if( 'delete' === $this->current_action() ) {
			$ids = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : array();
			if( is_array($ids) )
				$ids = implode (',', $ids);
			if( !empty($ids) ) {
				$tablename = $wpdb->prefix . TABLE_NAME;
				$wpdb->query( "DELETE FROM {$tablename} WHERE id IN({$ids})");
			}
			//wp_die( 'Items deleted (or they would be if we had items to delete)!' );
		}
	}

	/** ************************************************************************
	 * REQUIRED! This is where you prepare your data for display. This method will
	 * usually be used to query the database, sort and filter the data, and generally
	 * get it ready to be displayed. At a minimum, we should set $this->items and
	 * $this->set_pagination_args(), although the following properties and methods
	 * are frequently interacted with here...
	 *
	 * @global WPDB $wpdb
	 * @uses $this->_column_headers
	 * @uses $this->items
	 * @uses $this->get_columns()
	 * @uses $this->get_sortable_columns()
	 * @uses $this->get_pagenum()
	 * @uses $this->set_pagination_args()
	 **************************************************************************/
	function prepare_items() {
		global $wpdb;

		$tablename = $wpdb->prefix . TABLE_NAME;

		$per_page = 10;

		/**
		 * REQUIRED. Now we need to define our column headers. This includes a complete
		 * array of columns to be displayed (slugs & titles), a list of columns
		 * to keep hidden, and a list of columns that are sortable. Each of these
		 * can be defined in another method (as we've done here) before being
		 * used to build the value for our _column_headers property.
		 */
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		/**
		 * REQUIRED. Finally, we build an array to be used by the class for column
		 * headers. The $this->_column_headers property takes an array which contains
		 * 3 other arrays. One for all columns, one for hidden columns, and one
		 * for sortable columns.
		 */
		$this->_column_headers = array( $columns, $hidden, $sortable );

		/**
		 * Optional. You can handle your bulk actions however you see fit. In this
		 * case, we'll handle them within our package just to keep things clean.
		 */
		$this->process_bulk_action();

		$total_items = $wpdb->get_var( "SELECT COUNT(id) FROM {$tablename}" );

		$paged = isset( $_REQUEST['paged'] ) ? ( 1 < $_REQUEST['paged'] ? intval( $_REQUEST['paged'] - 1 ) : 0) : 0;
		$orderby = isset( $_REQUEST['orderby'] ) && in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns() ) )? $_REQUEST['orderby']  : 'id';
		$order = isset( $_REQUEST['order'] ) && in_array( $_REQUEST['order'], array( 'asc', 'desc' ) )?  $_REQUEST['order']  : 'asc';

		$query = $wpdb->prepare("SELECT * FROM {$tablename} ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d", $per_page, $paged * $per_page);
		$this->items = $wpdb->get_results(
				$query,
				ARRAY_A );

		/**
		 * REQUIRED for pagination. Let's figure out what page the user is currently
		 * looking at. We'll need this later, so you should always include it in
		 * your own package classes.
		 */
		//$current_page = $this->get_pagenum();

		/**
		 * The WP_List_Table class does not handle pagination for us, so we need
		 * to ensure that the data is trimmed to only the current page. We can use
		 * array_slice() to
		 */
		//$this->items = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		/**
		 * REQUIRED. We also have to register our pagination options & calculations.
		 */
		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page' => $per_page,
			 'total_pages' => ceil( $total_items / $per_page )
		));
	}

}

?>
