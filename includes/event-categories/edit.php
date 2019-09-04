<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_categories';
    if(isset( $_GET['id'] ) ){
	    $id = $_GET['id'];
	    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE id = $id " );
        foreach ( $result as $category ){
            $er_name = $category->name;
            $er_description = $category->description;
        }   
        
        if(isset( $_POST["er-update"] ) ){	
	        $er_name = $_POST['er-name'];
		    $er_description = $_POST['er-description'];
		    
		    $wpdb->update( 
            	$table_name,
            	array( 
            		'name' => $er_name,	
            		'description' => $er_description	
            	), 
            	array( 'id' => $id ), 
            	array( '%s', '%s' ), 
            	array( '%d' ) 
            );
            
            $msg = '<div id="message" class="updated notice is-dismissible">
    			<p><strong>Event Category Updated Successfully.</strong></p>
    			<button type="button" class="notice-dismiss">
    				<span class="screen-reader-text">Dismiss this notice.</span>
    			</button>
    		</div>';
        }
    }

?>
<div class="wrap">
    <h1>Edit Categories</h1>
    <div id="ajax-response"><?php echo $msg; ?></div>
    <form name="editcat" id="editcat" method="post">
        <table class="form-table">
            <tbody>
                <tr class="form-field form-required term-name-wrap">
        		    <th scope="row"><label for="er-name">Name</label></th>
        			<td><input name="er-name" id="er-name" type="text" value="<?php echo $er_name; ?>" aria-required="true"></td>
        		</tr>
        		<tr class="form-field term-description-wrap">
        			<th scope="row"><label for="er-description">Description</label></th>
        			<td><textarea name="er-description" id="er-description" rows="5" cols="50" class="large-text" spellcheck="false"><?php echo $er_description; ?></textarea>
        		</tr>
        	</tbody>
        </table>
        <div class="edit-tag-actions">
            <input type="submit" class="button button-primary" value="Update" name="er-update" >
        </div>
    </form>
</div>