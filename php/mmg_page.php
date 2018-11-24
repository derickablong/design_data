<?php
/**
 * Design Data
 *
 * @author Market Better
 * @package design-data 
 * @version 1.1
 */


/**
 * VIEW: Design Data
 * @since 1.1	 
 */
function mmg_design_data_page() {	
	
	if (isset( $_GET['view'] )) {

		$data = mmg_design_data_get( $_GET['view'] );
		include( DDDIR . 'php/mmg_page_details.php' );

	} else {

		$design_data = mmg_design_data_all();
		include( DDDIR . 'php/mmg_page_data.php' );

	}
	

}