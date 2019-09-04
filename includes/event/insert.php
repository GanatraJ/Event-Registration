<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event';
    if(isset( $_POST['er-add'] ) )
	{
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
	    
	    /*echo "INSERT INTO $table_name (`title`, `type`, `date`, `summary`, `description`, `location`, `status`, `capacity`, `event_category`, `price`) 
                    VALUES ('$er_title', '$er_type', '$er_date', '$er_summary', '$er_description', $er_location, $er_status, $er_capacity, $er_category, $er_price)";
	    */
	    if( !empty($er_title) ){
		   
            $sql = "INSERT INTO $table_name (`title`, `type`, `date`, `summary`, `description`, `location`, `status`, `capacity`, `event_category`, `price`) 
                    VALUES ('$er_title', '$er_type', '$er_date', '$er_summary', '$er_description', $er_location, $er_status, $er_capacity, $er_category, $er_price)";
	        $wpdb->query($sql);
            
            
            //if(!empty($insertID)){
                $msg = '<div id="message" class="updated notice is-dismissible">
    				<p><strong>Event Added Successfully.</strong></p>
    				<button type="button" class="notice-dismiss">
    					<span class="screen-reader-text">Dismiss this notice.</span>
    				</button>
    			</div>';
            //}
		}else{
		    $msg = '<div id="message" class="updated notice is-dismissible">
				<p><strong>All Fields are Required.</strong></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text">Dismiss this notice.</span>
				</button>
			</div>';
		}
	}
?>
<div class="wrap">
    <h1>Add New Event</h1>
    <div id="ajax-response"><?php echo $msg; ?></div>
    <p>Create a brand new event and add them to this site.</p>
    <form name="createevent" id="createevent" method="post">
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required">
        		    <th scope="row"><label for="er-title">Title</label></th>
        			<td><input name="er-title" id="er-title" type="text" value="<?php if(isset( $_POST['er-title'] )){ echo $_POST['er-title']; }?>" aria-required="true" required></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-type">Type</label></th>
        			<td><input name="er-type" id="er-type" type="text" value="<?php if(isset( $_POST['er-type'] )){ echo $_POST['er-type']; }?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-date">Date</label></th>
        			<td><input name="er-date" id="er-date" type="date" value="<?php if(isset( $_POST['er-date'] )){ echo $_POST['er-date']; }?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-summary">Summary</label></th>
        			<td>
        			    <textarea name="er-summary" id="er-summary" rows="5" cols="40" spellcheck="false" required><?php if(isset($_POST['er-summary'])){ echo $_POST['er-summary']; }?></textarea>
        			</td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-description">Description</label></th>
        			<td>
        			    <textarea name="er-description" id="er-description" rows="5" cols="40" spellcheck="false" required><?php if(isset( $_POST['er-description'] )){ echo $_POST['er-description']; }?></textarea>
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
        				            if ( isset( $_POST['er-location'] ) && ($location->id == $_POST['er-location'])) {
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
        			<td><input name="er-capacity" id="er-capacity" type="number" value="<?php if(isset( $_POST['er-capacity'] )){ echo $_POST['er-capacity']; }?>"></td>
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
                                    if ( isset( $_POST['er-category'] ) && ($category->id == $_POST['er-category']) ) {
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
        			<td><input name="er-price" id="er-price" type="number" value="<?php if(isset( $_POST['er-price'] )){ echo $_POST['er-price']; }?>"></td>
        		</tr>
        		<tr class="form-field">
        			<th scope="row"><label for="er-status">Status</label></th>
        			<td>
        			    <input type="radio" name="er-status" value="0" <?php if(isset( $_POST['er-status'] ) && ($_POST['er-status'] == 0) ){ echo 'checked'; }?> >
        			        <label for="er-status">Draft</label>
                        <input type="radio" name="er-status" value="1" <?php if(isset( $_POST['er-status'] ) && ($_POST['er-status'] == 1) ){ echo 'checked'; }?> >
                            <label for="er-status">Publish</label>
        			</td>
        		</tr>
        	</tbody>
        </table>
        <div class="edit-tag-actions">
            <input type="submit" class="button button-primary" value="Add New Event" name="er-add" >
        </div>
    </form>
</div>