<?php
/**
 * Design Data Actions
 *
 * @author Market Better
 * @package design-data 
 * @version 1.1
 */






/**
 * Insert Data
 * @since  1.1
 */
function mmg_design_data_insert( $data = array() ) {

	global $wpdb;
	$table_name = $wpdb->prefix . DD_TABLE;

	$wpdb->insert( $table_name, $data );
	return $wpdb->insert_id;

}






/**
 * Update Data
 * @since  1.1
 */
function mmg_design_data_update( $data = array(), $where = array() ) {

	global $wpdb;
	$table_name = $wpdb->prefix . DD_TABLE;

	$wpdb->update( $table_name, $data, $where );	

}






/**
 * Check if order number
 * already exists
 * @since  1.1
 */
function mmg_design_data_order_exists( $order_id = 0 ) {

	global $wpdb;
	$table_name = $wpdb->prefix . DD_TABLE;

	$result = $wpdb->get_results( "SELECT id FROM {$table_name} WHERE order_number = {$order_id}" );
	return ( count( $result ) > 0 );

}






/**
 * Create JSON Data
 * @since  1.1
 */
function mmg_design_data_create_json( $args = array(), $json = array(), $data = array() ) {


	$template = mmg_design_template_get( $args['design_template'] );

	$data = array(
		'name' => $template->name,
		'overlay_image' => $template->thumbnail
	);

	$panels = json_decode( $template->panels );
	$json_panels = array();
	foreach ( $panels as $panel => $positions ) {
		if ( 'null' != strtolower($panel) ) {


			$panel = ucwords( str_replace('_', ' ', $panel) );
			$mask_file = '';
			$json_positions = array();


			foreach ( $positions as $position ) {


				
				if ( property_exists($position, 'panel_image') ) {

					$mask_file = $position->panel_image;

				} else {



					$name = $position->name;
					$plug = "{$panel} - {$name}";


					$json_positions[] = array(

						'name' => $position->name,
						'type' => $position->type,
						'value' => strip_tags( $json[ $plug ] ),
						'x_position' => $position->x_position,
						'y_position' => $position->y_position,
						'width' => $position->width,
						'height' => $position->height,
						'rotation' => $position->rotation

					);



				}					


			}


			$json_panels[] = array(
				'name' => $panel,
				'mask_file' => $mask_file,
				'positions' => $json_positions
			);




		}
	}

	$data['panels'] = $json_panels;

	return json_encode($data);

}






/**
 * Woocommerce Hook
 * @since  1.1
 */
function mmg_design_data_woocommerce( $args = array(), $json = array() ) {

	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_order_items");
	foreach ($results as $result) {


		$order = wc_get_order( $result->order_id );	

		/**
		 * Order Number
		 */
		$args = array( 
			'code' => mmg_get_last_code_data(),
			'order_number' => $result->order_id,
			'order_status' => $order->get_status()
		);	
		


		$valid = false;
		$update = false;
		
		if ( mmg_design_data_order_exists( $result->order_id ) )
			$update = true;
	

    
	    foreach ($order->get_items() as $item_id => $item_obj) {

	    	$order_data = $item_obj->get_meta_data();


    		$product = $item_obj->get_data();
	    	$product_obj = wc_get_product( $product['product_id'] );    	



	    	if ( method_exists($product_obj, 'get_data') ) {

	    		$product_data = $product_obj->get_data();	    		
	    		$args['product_sku'] = $product_data['sku'];

	    	}
		    



	    	foreach ( $order_data as $key => $data )  {

	    		$current_data = $data->get_data();	


	    		if ( $current_data['key'] != '_gravity_forms_history' ) {


	    			/**
	    			 * User
	    			 */
	    			if ( 'current user' == strtolower($current_data['key']) ) {
	    				
	    				$args['user_id'] = (int) $current_data['value'];
	    				
						$valid = true;

	    			}


	    			/**
	    			 * Design Template
	    			 */
	    			else if ( 'design template' == strtolower($current_data['key']) ) {
	    				
	    				$args['design_template'] = $current_data['value'];

	    			}


	    			/**
	    			 * Design Snapshot
	    			 */
	    			else if ( 'design snapshot' == strtolower($current_data['key']) ) {
	    				
	    				$args['design_snapshot'] = $current_data['value'];

	    			}


	    			/**
	    			 * Store Data For JSON
	    			 */
	    			else {

	    				$json[ $current_data['key'] ] = $current_data['value'];

	    			}

	    			

	    		}  	

	    	}

	    }//end foreach




	    /**
		 * If has new order,
		 * insert new design data
		 */	
		if ($valid) {


			$json_data = mmg_design_data_create_json( $args, $json );
			$args['data_json'] = $json_data;
			

			if ($update)
				mmg_design_data_update( $args, array( 'order_number' => $args['order_number'] ) );
			else
				mmg_design_data_insert( $args );

		}

		

	}//end foreach

	
}






/**
 * Pretty JSON
 * @since  1.1
 */
function mmg_design_data_pretty_json( $json ) {	
	
	$json = strip_tags( $json );
	$json = str_replace('",', "</span>,", $json);
	$json = str_replace('":"', "</span>: <span class='dd-value'>", $json);	
	$json = str_replace('"', "<span class='dd-index'>", $json);
	$json = str_replace(':[', ' : [', $json);
	$json = str_replace(array('{', '}'), array("<span class='dd-curle'>{</span>", "<span class='dd-curle'>}</span>"), $json);
	$json = str_replace(array('[', ']'), array("<span class='dd-bracket'>[</span>", "<span class='dd-bracket'>]</span>"), $json);
	$json = str_replace(':', "<span class='dd-colon'>:</span>", $json);


    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $newLine     = "<br>";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element,
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {

            $result .= $newLine;
            
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    

    return $result;
}