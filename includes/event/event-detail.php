<?php
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'event';
    $table_cat = $wpdb->prefix . 'event_categories';
    $table_loc = $wpdb->prefix . 'event_location';
    
    if(isset( $event_id ) ){
	    $id = $event_id;
	    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name." WHERE id = $id " );
        foreach ( $result as $event ){
            $categories = $wpdb->get_results("SELECT name FROM ".$table_cat." WHERE id = $event->event_category");
            $locations = $wpdb->get_results("SELECT location_name FROM ".$table_loc." WHERE id = $event->location");
            
            $er_title = $event->title;
	        $er_type = $event->type;
	        $er_date = $event->date;
    	    $er_summary = $event->summary;
    	    $er_description = $event->description;
    	    $er_location = $locations[0]->location_name;;
    	    $er_capacity = $event->capacity;
    	    $er_category = $categories[0]->name;
    	    $er_price = $event->price;
    	    $er_status = $event->status;
    	    
    	    $er_date = date_create($er_date); 
    	    $er_date = date_format($er_date,"j F Y");
    	    
    	   
        }   
    }
?>
<div class="event-row">
    <div class="eventBox" data-event="<?php echo $event_id; ?>">
        <h1 class="entry-title event-name"><?php echo $er_title; ?></h1><hr/>
        <span class="cat-links">
            <strong>Date: </strong><span class="screen-reader-text1"><?php echo $er_date; ?> </span>
        </span>
        <span class="cat-links">
            <strong>Category: </strong><span class="screen-reader-text1"><?php echo $er_category; ?> </span>
        </span>
        <span class="cat-links">
            <strong>Price: </strong><span class="screen-reader-text1">$<?php echo $er_price; ?> </span>
        </span>
        <span class="cat-links">
            <strong>Location: </strong><span class="screen-reader-text1"><?php echo $er_location; ?> </span>
        </span>
		<div class="event-description">
    		<p><strong>Description:</strong><br><?php echo $er_description; ?></p>
    	</div>
    </div>
</div>