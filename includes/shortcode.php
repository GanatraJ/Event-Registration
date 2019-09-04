<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event';
    $table_cat = $wpdb->prefix . 'event_categories';
    $table_loc = $wpdb->prefix . 'event_location';
    
    $total = $wpdb->get_var("SELECT COUNT(*) FROM (SELECT * FROM ".$table_name." WHERE status = 1 LIMIT 0,50) AS a");
    $items_per_page = 30;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    
    $offset = ( $page * $items_per_page ) - $items_per_page;
    
    //$events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE `date` >= NOW() AND `date` < NOW() + INTERVAL 30 DAY ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
    //$totalevents = $wpdb->num_rows;
    
    if(isset( $_POST['er_filter_action'] ) )
	{
	    $filter_erloc = $_POST['erloc'];
	    $filter_ercat = $_POST['ercat'];
	    
	    if( !empty($filter_erloc) && !empty($filter_ercat) ) {
	        $events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE location = $filter_erloc AND event_category = $filter_ercat AND status = 1 ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
        }elseif( empty($filter_erloc) ){
            $events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE event_category = $filter_ercat AND `date` >= NOW() AND status = 1 ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
        }elseif( empty($filter_ercat) ){
            $events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE location = $filter_erloc AND `date` >= NOW() AND status = 1 ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
        }else{
            //$events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE `date` >= NOW() AND `date` < NOW() + INTERVAL 30 DAY AND status = 1 ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
        }
	}else{
	    $events = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE status = 1 ORDER BY id ASC LIMIT ${offset}, ${items_per_page}");
	}
	
    $totalevents = $wpdb->num_rows;
    
    
    
?>
<div class="event-filter">
    <form id="posts-filter" method="post">
        <label class="screen-reader-text1" for="cat">Filter by </label>
        <select name="erloc" id="erloc" class="postform">
            <option value="0">All Locations</option>
             <?php 
        	    $table_name = $wpdb->prefix . 'event_location';
        		$locations = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY location_name ASC");
        		foreach($locations as $location){
        		    if ( isset( $_POST['erloc'] ) && $location->id == $_POST['erloc']) {
        			    echo "<option value='".$location->id."' selected>".$location->location_name."</option>";
        			}else{
        			    echo "<option value='".$location->id."'>".$location->location_name."</option>";
        			}	
                }
            ?>
        </select>
        <select name="ercat" id="ercat" class="postform">
        <option value="0">All Categories</option>
        <?php 
        	$table_name = $wpdb->prefix . 'event_categories';
        	$categories = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY name ASC");
            foreach($categories as $category){
                if ( isset( $_POST['ercat'] ) &&  $category->id == $_POST['ercat']) {
                    echo "<option value='".$category->id."'  selected>".$category->name."</option>";	
                }else{
                    echo "<option value='".$category->id."'>".$category->name."</option>";	
                }	
            }
        ?>
        </select>
        <input type="submit" name="er_filter_action" id="er-query-submit" class="button" value="Filter">
    </form>
</div>
<div class="event-pagination" style="text-align:right;">
    <?php echo '<span class="pagination-links" style="display:inline-block;">';
        echo paginate_links( array(
            'base'               => add_query_arg( 'cpage', '%#%' ),
        	'format'             => '',
            'total'              =>  ceil($total / $items_per_page),
            'current'            => $page,
            'show_all'           => false,
            'end_size'           => 1,
            'mid_size'           => 2,
            'prev_next'          => true,
            //'prev_text' => __('&laquo;'),
            //'next_text' => __('&raquo;'),
            'prev_text'          => __('« Previous'),
	        'next_text'          => __('Read More »'),
            'type'               => 'plain',
            'add_args'           => false,
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => ''
        ));
        echo '</span>'; 
    ?>
</div>

<div class="event-deatil listContainer">
    <!-- loop start -->
    <?php 
        foreach($events as $event){
            if($event->status == 1){
                $categories = $wpdb->get_results("SELECT name FROM ".$table_cat." WHERE id = $event->event_category");
                $locations = $wpdb->get_results("SELECT location_name FROM ".$table_loc." WHERE id = $event->location");
    ?>
	<div class="event-list-item listDivider">
	    <div class="eventlist wrapper-<?php echo $event->id; ?>">
			<div class="event-item">
				<div class="event-date">
					<div class="listHeaderTitle" style="width: 108px;">
						<div class="ev-date" data-hook="ev-date-month-day"><?php 
						    $date = date_create($event->date);
						    echo date_format($date,"j"); ?></div>
						<div class="ev-date-section">
							<div class="ev-date-weekday" data-hook="ev-date-weekday">Mon</div>
							<div class="ev-date-month" data-hook="ev-date-month"><?php 
						    $date = date_create($event->date); //echo date_format($date,"j F Y");
						    echo date_format($date,"F Y"); ?></div>
						</div>
					</div>
				</div>
				<div class="event-details-section">
					<div class="event-details">
						<div class="ev-list-item-title listHeaderTitle" data-hook="ev-list-item-title"><?php echo $event->title; ?></div>
						<div class="listHeaderTitle">&nbsp;/&nbsp;</div>
						<div class="listHeaderLocation ev-list-item-location" data-hook="ev-list-item-location"><?php echo $locations[0]->location_name; ?></div>
						<div class="ev-down-arrow" >
							<svg viewBox="0 0 18 10" fill="currentColor" width="18" height="10"><path transform="rotate(-180 134.062 82)" d="M251 163L259.689655 155 268.123535 163" stroke="currentColor" fill="none" fill-rule="evenodd"></path></svg>
						</div>
					</div>
				</div>
			</div>
			<div class="ev-rsvp-section">
				<button data-hook="ev-rsvp-button" class="er_register_action" data-id="<?php echo $event->id; ?>" style="min-width: 100px;">Register Now</button>
			</div>
		</div>
		<div></div>
    </div>
    <?php } } ?>
    <!-- loop end -->
</div>
<div class="show-event-detail"></div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.show-event-detail').hide();
	$('.er_register_action').click(function(e) {
	    e.preventDefault();
	    var event_id = $(this).data('id');
	    //console.log('event: '+event_id);
        $.ajax({
            type: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: { "event_id" : event_id,"action":"er_detail" },
            success: function(data){
                //console.log("success!" + data);
                $('.show-event-detail').show();
                $('html, body').animate({
                    scrollTop: $("div.show-event-detail").offset().top
                }, 1000);
                $('.show-event-detail').addClass('event-show-container');
                $('.show-event-detail').html(data);
            }
        });
	});	
	
});
</script>