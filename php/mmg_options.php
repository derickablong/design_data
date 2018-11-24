<?php
/**
 * Design Data Options
 *
 * @author Market Better
 * @package design-data 
 * @version 1.1
 */






/**
 * Get Last Data Code
 *  
 * @since 1.1	 
 */
function mmg_get_last_code_data() {	
	global $wpdb;

	$table_name = $wpdb->prefix . DD_TABLE;	
	$query = "SELECT id 
	          FROM {$table_name} 
	          ORDER BY id DESC
	          LIMIT 1";


	$result = $wpdb->get_results( $query );
	$code = 'design_data_000000001';

	if( count( $result ) ) {
		$counter = ($result[0]->id + 1);		
		$code = str_pad($counter, 9, '0', STR_PAD_LEFT);
		$code = 'design_data_' . $code;
	}

	return $code;
}






/**
 * Get All Data
 * @since  1.1
 */
function mmg_design_data_all() {

	global $wpdb;
	$table_name = $wpdb->prefix . DD_TABLE;

	$results = $wpdb->get_results( "SELECT * FROM {$table_name}" );
	return $results;

}






/**
 * Get Design Data By ID
 *
 * 
 * @return details
 * @since  1.1
 */
function mmg_design_data_get( $data_id = 0 ) {
	global $wpdb;
	$table_name = $wpdb->prefix . DD_TABLE;

	$con = "id = {$data_id}";
	if (!is_numeric( $data_id ))
		$con = "code = '{$data_id}'";

	$query = "SELECT * FROM {$table_name} WHERE {$con}";
	return $wpdb->get_results( $query )[0];
}
