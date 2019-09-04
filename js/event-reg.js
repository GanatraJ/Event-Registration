jQuery(document).ready( function(){         
    jQuery('#content').on('click', 'a.rml_bttn', function(e) { 
        e.preventDefault();
        var rml_post_id = jQuery(this).data( 'id' );    
        jQuery.ajax({
            url : readmelater_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'read_me_later',
                post_id : rml_post_id
            },
            success : function( response ) {
                jQuery('.rml_contents').html(response);
            }
        });
        jQuery(this).hide();            
    });     

    jQuery('.er_register_action').click(function(e) {
        e.preventDefault();
        var event_id = jQuery(this).data('id');
        console.log('js event: '+event_id);
        $.ajax({
            type: "POST",
            url : event_ajax.ajax_url,
            data: { "event_id" : event_id,"action":"er_detail" },
            success: function(data){
                console.log("js success!" + data);
                jQuery('.show-event-detail').show();
                jQuery('html, body').animate({
                    scrollTop: jQuery("div.show-event-detail").offset().top
                }, 1000);
                jQuery('.show-event-detail').addClass('event-show-container');
                jQuery('.show-event-detail').html(data);
            }
        });
    }); 

});