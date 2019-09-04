<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_registrants';
    
    if(isset( $_GET['id'] ) ){
	    $id = $_GET['id'];
	    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE id = $id " );
	    foreach ( $result as $registration ){
            $erID = $registration->event_id;
    	    $er_fname = $registration->first_name;
    	    $er_lname = $registration->last_name;
    	    $er_email = $registration->email;
    	    $er_phone = $registration->phone_no;
    	    $er_address = $registration->address;
    	    $er_city = $registration->city;
    	    $er_state = $registration->state_province;
    	    $er_country = $registration->country;
        }   
        
        if(isset( $_POST["er-update"] ) ){	
	        $erID = $_POST['erID'];
    	    $er_fname = $_POST['er-fname'];
    	    $er_lname = $_POST['er-lname'];
    	    $er_email = $_POST['er-email'];
    	    $er_phone = $_POST['er-phone'];
    	    $er_address = $_POST['er-address'];
    	    $er_city = $_POST['er-city'];
    	    $er_state = $_POST['er-state'];
    	    $er_country = $_POST['er-country'];
	        
		    $wpdb->update( 
            	$table_name,
            	array( 
            		'first_name' => "$er_fname",
            		'last_name' => "$er_lname",
            		'email' => "$er_email",
            		'phone_no' => $er_phone,
            		'address' => "$er_address",
            		'city' => "$er_city",
            		'state_province' => "$er_state",
            		'country' => "$er_country",
            	), 
            	array( 'id' => $id ), 
            	array( '%s','%s','%s','%d','%s','%s','%s','%s' ), 
            	array( '%d' ) 
            );
            
            //echo $wpdb->last_query;
            
            $msg = '<div id="message" class="updated notice is-dismissible">
    			<p><strong>Event Registration Updated Successfully.</strong></p>
    			<button type="button" class="notice-dismiss">
    				<span class="screen-reader-text">Dismiss this notice.</span>
    			</button>
    		</div>';
        }
    }

?>
<div class="wrap">
    <h1>Edit Event Registration</h1>
    <div id="ajax-response"><?php echo $msg; ?></div>
    <form name="editeventreg" id="editeventreg" method="post">
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required">
        		    <th scope="row"><label for="er-fname">First Name</label></th>
        			<td><input name="er-fname" id="er-fname" type="text" value="<?php echo $er_fname; ?>" aria-required="true" required></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-lname">Last Name</label></th>
        			<td><input name="er-lname" id="er-lname" type="text" value="<?php echo $er_lname; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-email">E-mail</label></th>
        			<td><input name="er-email" id="er-email" type="text" value="<?php echo $er_email; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-phone">Phone Number</label></th>
        			<td><input name="er-phone" id="er-phone" type="text" value="<?php echo $er_phone; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-address">Address</label></th>
        			<td>
        			    <textarea name="er-address" id="er-address" rows="5" cols="40" spellcheck="false" required><?php echo $er_address; ?></textarea>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-city">City</label></th>
        			<td><input name="er-city" id="er-city" type="text" value="<?php echo $er_city; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-state">State\Province</label></th>
        			<td><input name="er-state" id="er-state" type="text" value="<?php echo $er_state; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-country">Country</label></th>
        			<td><input name="er-country" id="er-country" type="text" value="<?php echo $er_country; ?>"></td>
        		</tr>
        	</tbody>
        </table>
        <div class="edit-tag-actions">
            <input type="submit" class="button button-primary" value="Update" name="er-update" >
        </div>
    </form>
</div>