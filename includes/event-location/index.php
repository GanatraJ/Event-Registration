<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_location';
    if(isset( $_POST['er-location'] ) )
	{	
		$er_address = $_POST['er-address'];
		$er_city = $_POST['er-city'];
		$er_phno = $_POST['er-phno'];
		$er_loc = $_POST['er-loc'];
		
		if( !empty($er_loc) ){
		    $wpdb->insert($table_name, array( 'address' => $er_address, 'city' => $er_city, 'phone_number' => $er_phno, 'location_name' => $er_loc, ) );
            $insertID = $wpdb->insert_id;
            if(!empty($insertID)){
                $msg = '<div id="message" class="updated notice is-dismissible">
    				<p><strong>Event Location Added Successfully.</strong></p>
    				<button type="button" class="notice-dismiss">
    					<span class="screen-reader-text">Dismiss this notice.</span>
    				</button>
    			</div>';
            }
		}else{
		    $msg = '<div id="message" class="updated notice is-dismissible">
				<p><strong>Event Location Name Fields are Required.</strong></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text">Dismiss this notice.</span>
				</button>
			</div>';
		}
		
	}
	
?>
<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Locations</h1>
    <hr class="wp-header-end">
    <div id="ajax-response"><?php echo $msg; ?></div>
    
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2>Add New Location</h2>
                    <form id="addloc" method="post">
                        <div class="form-field form-required term-name-wrap">
                            <label for="er-address">Address</label>
                            <input name="er-address" id="er-address" type="text" value="" aria-required="true">
                        </div>
                        <div class="form-field term-slug-wrap">
                            <label for="er-city">City</label>
                            <input name="er-city" id="er-city" type="text" value="">
                        </div>
                        <div class="form-field term-parent-wrap">
                            <label for="er-phno">Phone Number</label>
                            <input name="er-phno" id="er-phno" type="text" value="" aria-required="true">
                        </div>
                        <div class="form-field term-description-wrap">
                            <label for="er-loc">Name of Location</label>
                            <input name="er-loc" id="er-loc" type="text" value="" required="" aria-required="true">
                        </div>
                        <p class="submit"><input type="submit" name="er-location" id="submit" class="button button-primary" value="Add New Location"></p>
                    </form>
                </div>
            </div>
        </div><!-- /col-left -->
        <div id="col-right">
            <div class="col-wrap">
                <?php 
                    $total = $wpdb->get_var("SELECT COUNT(*) FROM (SELECT * FROM ".$table_name." LIMIT 0,150) AS a");
                    $post_per_page = 20;
                    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
                    $offset = ( $page * $post_per_page ) - $post_per_page;
                    
                ?>
                <div class="tablenav top">
                    <div class="alignleft actions bulkactions"></div>
            		<div class="tablenav-pages one-page">
            		    <span class="displaying-num"><?php echo $total; ?> item</span>
                        <!--<span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                            <span class="paging-input">
                                <label for="current-page-selector" class="screen-reader-text">Current Page</label>
                                <input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging">
                                <span class="tablenav-paging-text"> of <span class="total-pages">1</span></span>
                            </span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
                        </span>-->
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
            	</div>
            	
                <h2 class="screen-reader-text">Location list</h2>
                <table class="wp-list-table widefat fixed striped tags">
                    <thead>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                                <input id="cb-select-all-1" type="checkbox">
                            </td>
                            <th scope="col" id="address" class="manage-column column-address column-primary sortable desc">
                                <a href="">
                                    <span>Address</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" id="city" class="manage-column column-city sortable desc">
                                <a href="">
                                    <span>City</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" id="phone_number" class="manage-column column-phone-number sortable desc">
                                <a href="">
                                    <span>Phone Number</span>
                                    <span class="sorting-indicator"></span></a>
                            </th>
                            <th scope="col" id="location_name" class="manage-column column-location-name sortable desc">
                                <a href="">
                                    <span>Name of Location</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="the-list" data-wp-lists="list:tag">
                        <?php 
                            $locations = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY id ASC LIMIT ${offset}, ${post_per_page}");
        				    foreach($locations as $location){
        				?>
                        <tr id="<?php echo $location->id; ?>">
                            <th scope="row" class="check-column">&nbsp;</th>
                            <td class="name column-address has-row-actions column-primary" data-colname="Name">
                                <strong>
                                    <a class="row-title" href="#" aria-label="“<?php echo $location->address; ?>” (Edit)"><?php echo $location->address; ?></a>
                                </strong>
                                <br>
                                <div class="row-actions">
                                    <span class="edit">
                                        <a href="<?php echo admin_url( 'admin.php?page=event_location_edit&id='.$location->id, 'https' ); ?>" aria-label="Edit “<?php echo $location->address; ?>”">Edit</a>
                                    </span> | 
                                    <span class="delete">
                                        <a href="" class="delete-tag aria-button-if-js et-del-btn" data-id="<?php echo $location->id; ?>" data-table="<?php echo $table_name; ?>" data-etype="Location" role="button" aria-label="Delete">Delete</a>
                                    </span>
                                </div>
                            </td>
                            <td class="description column-city" data-colname="Description">
                                <span aria-hidden="true"><?php echo $location->city; ?></span>
                            </td>
                            <td class="slug column-phone-number" data-colname="Slug"><?php echo $location->phone_number; ?></td>
                            <td class="posts column-location-name" data-colname="Count"><?php echo $location->location_name; ?></td>
                        </tr>	
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                                <input id="cb-select-all-2" type="checkbox">
                            </td>
                            <th scope="col" class="manage-column column-address column-primary sortable desc">
                                <a href="">
                                    <span>Address</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="manage-column column-city sortable desc">
                                <a href="">
                                    <span>City</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="manage-column column-phone-number sortable desc">
                                <a href="">
                                    <span>Phone Number</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="manage-column column-location-name sortable desc">
                                <a href="">
                                    <span>Name of Location</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>	
                        </tr>
                    </tfoot>
                </table>
                <div class="tablenav bottom">
                    <div class="alignleft actions bulkactions"></div>
            		<div class="tablenav-pages one-page"><span class="displaying-num"><?php echo $total; ?> item</span>
                        <!-- <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                            <span class="screen-reader-text">Current Page</span>
                            <span id="table-paging" class="paging-input">
                                <span class="tablenav-paging-text">1 of <span class="total-pages">1</span></span>
                            </span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
                        </span> -->
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
            	</div>
            </div>
        </div><!-- /col-right -->
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.et-del-btn').click(function(e) {
	    e.preventDefault();
	    var del_id = $(this).data('id');
	    var del_tbl = $(this).data('table');
	    var event_type = $(this).data('etype');
        console.log('hi '+del_id+'tbl: '+del_tbl+'type: '+event_type);
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