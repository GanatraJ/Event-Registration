<?php 
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_categories';
    if(isset( $_POST['er-category'] ) )
	{	
		$er_name = $_POST['er-name'];
		$er_description = $_POST['er-description'];
		
		
		if( !empty($er_name) && !empty($er_description) ){
		    $wpdb->insert($table_name, array( 'name' => $er_name, 'description' => $er_description, ) );
            $insertID = $wpdb->insert_id;
            if(!empty($insertID)){
                $msg = '<div id="message" class="updated notice is-dismissible">
    				<p><strong>Event Category Added Successfully.</strong></p>
    				<button type="button" class="notice-dismiss">
    					<span class="screen-reader-text">Dismiss this notice.</span>
    				</button>
    			</div>';
            }
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
<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Categories</h1>
    <hr class="wp-header-end">
    <div id="ajax-response"><?php echo $msg; ?></div>
    
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h2>Add New Location</h2>
                    <form id="addloc" method="post">
                        <div class="form-field form-required term-name-wrap">
                            <label for="er-name">Name</label>
                            <input name="er-name" id="er-name" type="text" value="" aria-required="true" required="">
                        </div>
                        <div class="form-field term-description-wrap">
                        	<label for="er-description">Description</label>
                        	<textarea name="er-description" id="er-description" rows="5" cols="40" spellcheck="false" required></textarea>
                        </div>
                        <p class="submit"><input type="submit" name="er-category" id="submit" class="button button-primary" value="Add New Category"></p>
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
            	
                <h2 class="screen-reader-text">Category list</h2>
                <table class="wp-list-table widefat fixed striped tags">
                    <thead>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                                <input id="cb-select-all-1" type="checkbox">
                            </td>
                            <th scope="col" id="address" class="manage-column column-name column-primary sortable desc">
                                <a href="">
                                    <span>Name</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" id="city" class="manage-column column-description sortable desc">
                                <a href="">
                                    <span>Description</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="the-list" data-wp-lists="list:tag">
                        <?php 
                            $categories = $wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY id ASC LIMIT ${offset}, ${post_per_page}");
        				    foreach($categories as $category){
        				?>
                        <tr id="<?php echo $category->id; ?>">
                            <th scope="row" class="check-column">&nbsp;</th>
                            <td class="name column-name has-row-actions column-primary" data-colname="Name">
                                <strong>
                                    <a class="row-title" href="#" aria-label="“<?php echo $category->name; ?>” (Edit)"><?php echo $category->name; ?></a>
                                </strong>
                                <br>
                                <div class="row-actions">
                                    <span class="edit">
                                        <a href="<?php echo admin_url( 'admin.php?page=event_category_edit&id='.$category->id, 'https' ); ?>" aria-label="Edit “Uncategorised”">Edit</a>
                                    </span> | 
                                    <span class="delete">
                                        <a href="" class="delete-tag aria-button-if-js et-del-btn" data-id="<?php echo $category->id; ?>" data-table="<?php echo $table_name; ?>" data-etype="Category" role="button" aria-label="Delete">Delete</a>
                                    </span>
                                </div>
                            </td>
                            <td class="description column-description" data-colname="Description">
                                <span aria-hidden="true"><?php echo $category->description; ?></span>
                            </td>
                        </tr>	
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                                <input id="cb-select-all-2" type="checkbox">
                            </td>
                            <th scope="col" class="manage-column column-name column-primary sortable desc">
                                <a href="">
                                    <span>Name</span>
                                    <span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="manage-column column-description sortable desc">
                                <a href="">
                                    <span>Description</span>
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