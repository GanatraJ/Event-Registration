<div class="wrap registrationform">
    
    <h1>Register for this event</h1>
    <div id="ajax-response"></div>
    <form name="addregistration" id="addregistration" method="post">
        <div class="form-table">
            <div>
                <input name="erID" id="erID" type="hidden" value="<?php if(isset( $event_id )){ echo $event_id; }?>">
                <div class="form-field form-required">
        		    <label for="er-fname">First Name</label>
        			<input name="er-fname" id="er-fname" type="text" value="<?php if(isset( $_POST['er-fname'] )){ echo $_POST['er-fname']; }?>" aria-required="true" required>
        		</div>
        		<div class="form-field">
        			<label for="er-lname">Last Name</label>
        			<input name="er-lname" id="er-lname" type="text" value="<?php if(isset( $_POST['er-lname'] )){ echo $_POST['er-lname']; }?>">
        		</div>
        		<div class="form-field">
        			<label for="er-email">E-mail</label>
        			<input name="er-email" id="er-email" type="text" value="<?php if(isset( $_POST['er-email'] )){ echo $_POST['er-email']; }?>">
        		</div>
        		<div class="form-field">
        			<label for="er-phone">Phone Number</label>
        			<input name="er-phone" id="er-phone" type="text" value="<?php if(isset( $_POST['er-phone'] )){ echo $_POST['er-phone']; }?>">
        		</div>
        		<div class="form-field">
        			<label for="er-address">Address</label>
        			<textarea name="er-address" id="er-address" rows="5" cols="40" spellcheck="false" required><?php if(isset($_POST['er-address'])){ echo $_POST['er-address']; }?></textarea>
        		</div>
        		<div class="form-field">
        			<label for="er-city">City</label>
        			<input name="er-city" id="er-city" type="text" value="<?php if(isset( $_POST['er-city'] )){ echo $_POST['er-city']; }?>">
        		</div>
        		<div class="form-field">
        			<label for="er-state">State\Province</label>
        			<input name="er-state" id="er-state" type="text" value="<?php if(isset( $_POST['er-state'] )){ echo $_POST['er-state']; }?>">
        		</div>
        		<div class="form-field">
        			<label for="er-country">Country</label>
        			<input name="er-country" id="er-country" type="text" value="<?php if(isset( $_POST['er-country'] )){ echo $_POST['er-country']; }?>">
        		</div>
        	</div>
        </div>
        <div class="edit-tag-actions" style="padding-top: 25px;">
            <input type="submit" class="button button-primary register-btn" value="Register" name="er-add" >
        </div>
    </form>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    
	$('.register-btn').click(function(e) {
	    e.preventDefault();
	    
	    var eventid = $("#erID").val();
	    var fname = $("#er-fname").val();
	    var lname = $("#er-lname").val();
	    var email = $("#er-email").val();
	    var phone = $("#er-phone").val();
	    var address = $("#er-address").val();
	    var city = $("#er-city").val();
	    var state = $("#er-state").val();
	    var country = $("#er-country").val();
        
        console.log('hi '+eventid+'fname: '+fname+'lname: '+lname+'email: '+email+'phone: '+phone+'address: '+address+'city: '+city+'state: '+state+'country: '+country);
        $.ajax({
            type: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: { "eventid" : eventid,"fname" : fname,"lname" : lname,"email" : email,"phone" : phone,"address" : address,
                    "city" : city,"state" : state,"country" : country,"action":"er_register" },
            success: function(html){
                //console.log("success!" + html);
                $('#addregistration').hide();
                $('#ajax-response').html(html);
            }
        });
	});	
});
</script>