<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event';
    
    if(isset( $_GET['id'] ) ){
	    $id = $_GET['id'];
	    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE id = $id " );
        foreach ( $result as $event ){
            $er_title = $event->title;
	        $er_type = $event->type;
	        $er_date = $event->date;
    	    $er_summary = $event->summary;
    	    $er_description = $event->description;
    	    $er_location = $event->location;
    	    $er_capacity = $event->capacity;
    	    $er_category = $event->event_category;
    	    $er_price = $event->price;
    	    $er_status = $event->status;
        }   
        
        if(isset( $_POST["er-update"] ) ){	
	        $er_title = $_POST['er-title'];
    	    $er_type = $_POST['er-type'];
    	    $er_date = $_POST['er-date'];
    	    $er_summary = $_POST['er-summary'];
    	    $er_description = $_POST['er-description'];
    	    $er_location = $_POST['er-location'];
    	    $er_capacity = $_POST['er-capacity'];
    	    $er_category = $_POST['er-category'];
    	    $er_price = $_POST['er-price'];
    	    $er_status = $_POST['er-status'];
	        
		    $wpdb->update( 
            	$table_name,
            	array( 
            		'title' => "$er_title",	
            		'type' => "$er_type",
            		'date' => "$er_date",
            		'summary' => "$er_summary",
            		'description' => "$er_description",
            		'location' => $er_location,
            		'status' => $er_status,
            		'capacity' => $er_capacity,
            		'event_category' => $er_category,
            		'price' => $er_price,
            	), 
            	array( 'id' => $id ), 
            	array( '%s', '%s','%s','%s','%s','%d','%d','%d','%d','%d' ), 
            	array( '%d' ) 
            );
            
            //echo $wpdb->last_query;
            
            $msg = '<div id="message" class="updated notice is-dismissible">
    			<p><strong>Event Updated Successfully.</strong></p>
    			<button type="button" class="notice-dismiss">
    				<span class="screen-reader-text">Dismiss this notice.</span>
    			</button>
    		</div>';
        }
    }

?>
<div class="wrap">
    <h1>Edit Event</h1>
    <div id="ajax-response"><?php echo $msg; ?></div>
    <form name="editevent" id="editevent" method="post">
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required">
        		    <th scope="row"><label for="er-title">Title</label></th>
        			<td><input name="er-title" id="er-title" type="text" value="<?php echo $er_title; ?>" aria-required="true" required></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-type">Type</label></th>
        			<td><input name="er-type" id="er-type" type="text" value="<?php echo $er_type; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-date">Date</label></th>
        			<td><input name="er-date" id="er-date" type="date" value="<?php echo $er_date; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-summary">Summary</label></th>
        			<td>
        			    <textarea name="er-summary" id="er-summary" rows="5" cols="40" spellcheck="false" required><?php echo $er_summary; ?>
        			    </textarea>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-description">Description</label></th>
        			<td>
        			    <textarea name="er-description" id="er-description" rows="5" cols="40" spellcheck="false" required><?php echo $er_description ; ?>
        			    </textarea>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-location">Location</label></th>
        			<td>
        			    <select name="er-location" id="er-location">
        			        <option>Select Event Location</option>
        			        <?php 
        			            $table_name = $wpdb->prefix . 'event_location';
        			            $locations = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY location_name ASC");
        				        foreach($locations as $location){
        				            if ($location->id == $er_location) {
        				                echo "<option value='".$location->id."' selected>".$location->location_name."</option>";
        				            }else{
        				                echo "<option value='".$location->id."'>".$location->location_name."</option>";
        				            }
                                }
                            ?>
        			    </select>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-capacity">Capacity (Max Registrants)</label></th>
        			<td><input name="er-capacity" id="er-capacity" type="number" value="<?php echo $er_capacity; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-category">Category</label></th>
        			<td>
        			    <select name="er-category" id="er-category">
        			        <option>Select Categories</option>
        			        <?php 
        			            $table_name = $wpdb->prefix . 'event_categories';
        			            $categories = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY name ASC");
                                foreach($categories as $category){
                                    if ( $category->id == $er_category ) {
                                        echo "<option value='".$category->id."' selected>".$category->name."</option>";	
                                    }else{
                                        echo "<option value='".$category->id."'>".$category->name."</option>";
                                    }	
                                }
                            ?>
        			    </select>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-price">Price</label></th>
        			<td><input name="er-price" id="er-price" type="number" value="<?php echo $er_price ; ?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-status">Status</label></th>
        			<td>
        			    <input type="radio" name="er-status" value="0" <?php if($er_status  == 0 ){ echo 'checked'; }?> >
        			        <label for="er-status">Draft</label>
                        <input type="radio" name="er-status" value="1" <?php if($er_status  == 1 ){ echo 'checked'; }?> >
                            <label for="er-status">Publish</label>
        			</td>
        		</tr>
        	</tbody>
        </table>
        <div class="edit-tag-actions">
            <input type="submit" class="button button-primary" value="Update" name="er-update" >
        </div>
    </form>
</div>