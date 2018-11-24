<?php
/**
 * On Install Plugin
 *
 * @author Market Better
 * @package design-data 
 * @version 1.1
 */

class MMG_DD_Install
{



	/**
	 * Install
	 * Install needed options
	 * and tables
	 */
	public function install()
	{				
		global $wpdb;


		/**
		 * Call WP Library
		 */
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Design Library
		 * Create Table
		 * Name: prefix_design_assets		 
		 */
		$table_name = $wpdb->prefix . DD_TABLE;

		/**
		 * Drop Table First
		 */
		dbDelta("DROP TABLE IF EXISTS {$table_name}");

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		  code TINYTEXT,
		  user_id mediumint(9),
		  order_number TINYTEXT,
		  order_status TINYTEXT,
		  product_sku TINYTEXT,
		  design_template TINYTEXT,
		  design_snapshot TINYTEXT,		  
		  data_json TEXT NULL,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";		
		dbDelta( $sql );
		



	}
}