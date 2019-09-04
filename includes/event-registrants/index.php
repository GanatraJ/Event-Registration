<?php
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_registrants';
    
    if(isset( $_GET['eid'] ) ){
        $eventID = $_GET['eid'];
    
        $total = $wpdb->get_var("SELECT COUNT(*) FROM (SELECT * FROM ".$table_name." WHERE event_id = $eventID LIMIT 0,150) AS a");
        $post_per_page = 20;
        $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
        $offset = ( $page * $post_per_page ) - $post_per_page;
        
        $event_registrants = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE event_id = $eventID ORDER BY id ASC LIMIT ${offset}, ${post_per_page}");
        $totalregistrants = $wpdb->num_rows;
    
    }
    
?>
<div id="wpbody" role="main">
	<div id="wpbody-content" aria-label="Main content" tabindex="0">
		<div class="wrap">
		    <div class="msg">
		        <div id="message" class="updated notice is-dismissible" style="display:none;">
                    <p></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
		    </div>
			<h1 class="wp-heading-inline">Event Registrations</h1>
			<hr class="wp-header-end">
			<h2 class="screen-reader-text">Filter posts list</h2>
			<ul class="subsubsub">
            	<li class="all"><a href="edit.php?post_type=post" class="current" aria-current="page">All <span class="count">(<?php echo $totalregistrants;?>)</span></a> |</li>
            </ul>
            <form id="posts-filter" method="get">
                <div class="tablenav top">
                    <div class="tablenav-pages one-page">
                        <span class="displaying-num"><?php echo $total; ?> item</span>
                        <?php echo '<span class="pagination-links" style="display:inline-block;">';
                                echo paginate_links( array(
                                    'base'               => add_query_arg( 'cpage', '%#%' ),
                                	'format'             => '',
                                	'total'              =>  ceil($total / $post_per_page),
                                	'current'            => $page,
                                	'show_all'           => false,
                                	'end_size'           => 1,
                                	'mid_size'           => 2,
                                	'prev_next'          => true,
                                    'prev_text' => __('&laquo;'),
                                    'next_text' => __('&raquo;'),
                                	'type'               => 'plain',
                                	'add_args'           => false,
                                	'add_fragment'       => '',
                                	'before_page_number' => '',
                                	'after_page_number'  => ''
                                ));
                            echo '</span>'; ?>
                    </div>
		            <br class="clear">
                </div><!-- tablenav top -->
                <h2 class="screen-reader-text">Events Registrations list</h2>
                <table class="wp-list-table widefat fixed striped posts">
				    <thead>
				        <tr>
						    <td id="cb" class="manage-column column-cb check-column">
						        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
						        <input id="cb-select-all-1" type="checkbox">
						    </td>
						    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
						        <a href=""><span>Name</span><span class="sorting-indicator"></span></a>
						    </th>
						    <th scope="col" id="address" class="manage-column column-address">Address</th>
						    <th scope="col" id="city" class="manage-column column-city">City</th>
						    <th scope="col" id="state" class="manage-column column-state">State\Province</th>
						    <th scope="col" id="country" class="manage-column column-country sortable asc">
						        <a href=""><span>Country</span><span class="sorting-indicator"></span></a>
						    </th>	
				        </tr>
				    </thead>
				    <tbody id="the-list">
				        <?php 
                            foreach($event_registrants as $event_registrant){
                        ?>
        				<tr id="<?php echo $event_registrant->id; ?>" class="iedit author-self level-0 post-<?php echo $event_registrant->id; ?> format-standard hentry entry">
        				    <th scope="row" class="check-column">			
        						<label class="screen-reader-text" for="cb-select-<?php echo $event_registrant->id; ?>">Select <?php echo $event_registrant->first_name.' '.$event_registrant->last_name; ?></label>
        						<input id="cb-select-<?php echo $event_registrant->id; ?>" type="checkbox" name="post[]" value="<?php echo $event_registrant->id; ?>">
        						<div class="locked-indicator">
        							<span class="locked-indicator-icon" aria-hidden="true"></span>
        							<span class="screen-reader-text">“<?php echo $event_registrant->first_name.' '.$event_registrant->last_name; ?>” is locked</span>
        						</div>
        					</th>
        					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
        						<div class="locked-info">
        							<span class="locked-avatar"></span> <span class="locked-text"></span>
        						</div>
        						<strong>
        							<a class="row-title" href="<?php echo admin_url( 'admin.php?page=event_registrant_edit&id='.$event_registrant->id, 'https' ); ?>" aria-label="“<?php echo $event_registrant->first_name; ?>” (Edit)"><?php echo $event_registrant->first_name.' '.$event_registrant->last_name; ?></a>
        						</strong>
        						<div class="row-actions">
        							<span class="edit">
        								<a href="<?php echo admin_url( 'admin.php?page=event_registrant_edit&id='.$event_registrant->id, 'https' ); ?>" aria-label="Edit “<?php echo $event_registrant->first_name.' '.$event_registrant->last_name; ?>”">Edit</a> | 
        							</span>
        							<span class="trash">
        								<a href="" class="submitdelete et-del-btn" data-id="<?php echo $event_registrant->id; ?>" data-table="<?php echo $table_name; ?>" data-etype="Event Registration" aria-label="Move “<?php echo $event_registrant->first_name.' '.$event_registrant->last_name; ?>” to the Trash">Move to Trash</a> | 
        							</span>
        						</div>
    						</td>
        					<td class="address column-address" data-colname="address">
        						<a href=""><?php echo $event_registrant->address; ?></a>
        					</td>
        					<td class="city column-email" data-colname="city">
        						<a href=""><?php echo $event_registrant->city; ?></a>
        					</td>
        					<td class="state column-state" data-colname="state">
        						<a href=""><?php echo $event_registrant->state_province; ?></a>
        					</td>
        					<td class="country column-country" data-colname="country">
        						<abbr title="<?php echo $event_registrant->country; ?>"><?php echo $event_registrant->country; ?></abbr>
        					</td>	
        				</tr>
        				<?php } ?>
				    </tbody>
				    <tfoot>
				        <tr>
						    <td id="cb" class="manage-column column-cb check-column">
						        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
						        <input id="cb-select-all-1" type="checkbox">
						    </td>
						    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
						        <a href=""><span>Name</span><span class="sorting-indicator"></span></a>
						    </th>
						    <th scope="col" id="address" class="manage-column column-address">Address</th>
						    <th scope="col" id="city" class="manage-column column-city">City</th>
						    <th scope="col" id="state" class="manage-column column-state">State\Province</th>
						    <th scope="col" id="country" class="manage-column column-country sortable asc">
						        <a href=""><span>Country</span><span class="sorting-indicator"></span></a>
						    </th>	
				        </tr>
				    </tfoot>
				</table>
                <div class="tablenav bottom">
                    <div class="tablenav-pages one-page">
                        <span class="displaying-num"><?php echo $total; ?> item</span>
                        <?php echo '<span class="pagination-links" style="display:inline-block;">';
                                echo paginate_links( array(
                                    'base'               => add_query_arg( 'cpage', '%#%' ),
                                	'format'             => '',
                                	'total'              =>  ceil($total / $post_per_page),
                                	'current'            => $page,
                                	'show_all'           => false,
                                	'end_size'           => 1,
                                	'mid_size'           => 2,
                                	'prev_next'          => true,
                                    'prev_text' => __('&laquo;'),
                                    'next_text' => __('&raquo;'),
                                	'type'               => 'plain',
                                	'add_args'           => false,
                                	'add_fragment'       => '',
                                	'before_page_number' => '',
                                	'after_page_number'  => ''
                                ));
                            echo '</span>'; ?>
                    </div>
		            <br class="clear">
                </div><!-- tablenav bottom -->
            </form>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.et-del-btn').click(function(e) {
	    e.preventDefault();
	    var del_id = $(this).data('id');
	    var del_tbl = $(this).data('table');
	    var event_type = $(this).data('etype');
        //console.log('hi '+del_id+'tbl: '+del_tbl+'type: '+event_type);
        $.ajax({
            type: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: { "del_id" : del_id,"del_tbl" : del_tbl,"event_type" : event_type,"action":"er_delaction" },
            success: function(data){
                //console.log("success!" + data);
                $('#ajax-response').html(data);
                setTimeout(function(){
                   location.reload(); 
                }, 2000); 
            }
        });
	});	
});
</script>