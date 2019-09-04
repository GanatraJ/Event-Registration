<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_location';
    if(isset( $_GET['id'] ) ){
	    $id = $_GET['id'];
	    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE id = $id " );
        foreach ( $result as $location ){
            $er_address = $location->address;
            $er_city = $location->city;
            $er_phno = $location->phone_number;
            $er_loc = $location->location_name;
        }   
        
        if(isset( $_POST["er-update"] ) ){	
	        $er_address = $_POST['er-address'];
		    $er_city = $_POST['er-city'];
		    $er_phno = $_POST['er-phno'];
		    $er_loc = $_POST['er-loc'];
		   
		    $wpdb->update( 
            	$table_name,
            	array( 
            		'address' => $er_address,	
            		'city' => $er_city,	
            		'phone_number' => $er_phno,
            		'location_name' => $er_loc
            	), 
            	array( 'id' => $id ), 
            	array( '%s', '%s', '%d', '%s' ), 
            	array( '%d' ) 
            );
            
            $msg = '<div id="message" class="updated notice is-dismissible">
    			<p><strong>Event Location Updated Successfully.</strong></p>
    			<button type="button" class="notice-dismiss">
    				<span class="screen-reader-text">Dismiss this notice.</span>
    			</button>
    		</div>';
        }
    }

?>
<div class="wrap">
    <h1>Edit Location</h1>
    <div id="ajax-response"><?php echo $msg; ?></div>
    <form name="editloc" id="editloc" method="post">
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required term-name-wrap">
        		    <th scope="row"><label for="er-address">Address</label></th>
        			<td><input name="er-address" id="er-address" type="text" value="<?php echo $er_address; ?>" aria-required="true"></td>
        		</tr>
        		<tr class="form-field term-slug-wrap">
        			<th scope="row"><label for="er-city">City</label></th>
        			<td><input name="er-city" id="er-city" type="text" value="<?php echo $er_city; ?>"></td>
        		</tr>
        		<tr class="form-field form-required term-name-wrap">
        		    <th scope="row"><label for="er-phno">Phone Number</label></th>
        			<td><input name="er-phno" id="er-phno" type="text" value="<?php echo $er_phno; ?>" aria-required="true"></td>
        		</tr>
        		<tr class="form-field form-required term-name-wrap">
        		    <th scope="row"><label for="er-loc">Name of Location</label></th>
        			<td><input name="er-loc" id="er-loc" type="text" value="<?php echo $er_loc; ?>" aria-required="true"></td>
        		</tr>
        	</tbody>
        </table>
        <div class="edit-tag-actions">
            <input type="submit" class="button button-primary" value="Update" name="er-update" >
        </div>
    </form>
</div>