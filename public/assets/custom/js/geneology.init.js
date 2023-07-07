
$( document ).ready(function() {
    getClientGeneology(client_id);
    $('.loader-wrapper').remove();
});

$('.head-link').click(function(){
    let clientId = $(this).attr("data-id");
   var val =  $(this).attr("data-top");
    if (val != client_id) {
        if (clientId != "" ) {
            getClientGeneology(clientId);
        }
    }
    
});

$('#go-to-top').click(function(){
    getClientGeneology(client_id);
});

$('#client-addon').click(function(){
    clientId = $('#client').val();    
    getClientGeneology(clientId);
});



function getClientGeneology(client_id){
    
    invokeLoader();

    $.ajax({
        method:"GET",
        url:"/ajax/get-geneology", 
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"             : token,
            "client_id"          : client_id,
        },

        success:function(data){

           // console.log(data);

            client = data.data;

            var level_1 = '';
            var level_2_left = 'N/A';
            var level_2_right = 'N/A';
            var level_3_left_left = 'N/A';
            var level_3_left_right = 'N/A';
            var level_3_right_left = 'N/A';
            var level_3_right_right = 'N/A';

            $('#a-level-1').attr("data-id",'');
            $('#a-level-2-left').attr("data-id",'');
            $('#a-level-2-right').attr("data-id",'');
            $('#a-level-3-left-left').attr("data-id",'');
            $('#a-level-3-left-right').attr("data-id",'');
            $('#a-level-3-right-left').attr("data-id",'');
            $('#a-level-3-right-right').attr("data-id",'');

            if (true) {


                if (client.hasOwnProperty('get_parent') && client.get_parent!=null) {
                    $('#back-btn').attr("data-id",client.get_parent.id);
                    $('#back-btn').attr("data-top",client.id);
                    
                }

                var sponser_mno = "";
                if (client.hasOwnProperty('get_sponsor') && client.get_sponsor!=null) {
                    sponser_mno = client.get_sponsor.membership_no;
                }

                level_1 =   'User ID - '+client.membership_no+' ('+sponser_mno+')<br>\
                                '+client.first_name+' '+client.last_name+'<br>\
                                Registered Date - '+client.created_at+' '; 
                                $('#a-level-1').attr("data-id",client.id); 
                                
                                
                if (client.hasOwnProperty('left_child') && client.left_child!=null) {
                    level_2_left =     'User ID - '+client.left_child.membership_no+' ('+client.left_child.get_sponsor.membership_no+')<br>\
                                        '+client.left_child.first_name+' '+client.left_child.last_name+'<br>\
                                        Registered Date - '+client.left_child.created_at+' '; 
                                        $('#a-level-2-left').attr("data-id",client.left_child.id); 
                                        
                    if(client.left_child.hasOwnProperty('left_child') && client.left_child.left_child!=null){

                        level_3_left_left = 'User ID - '+client.left_child.left_child.membership_no+' ('+client.left_child.left_child.get_sponsor.membership_no+')<br>\
                                            '+client.left_child.left_child.first_name+' '+client.left_child.left_child.last_name+'<br>\
                                            Registered Date - '+client.left_child.left_child.created_at+' ';
                                            $('#a-level-3-left-left').attr("data-id",client.left_child.left_child.id);
                                            
                    }
                    
                    if(client.left_child.hasOwnProperty('right_child') && client.left_child.right_child!=null){
                        
                        level_3_left_right =    'User ID - '+client.left_child.right_child.membership_no+' ('+client.left_child.right_child.get_sponsor.membership_no+')<br>\
                                                '+client.left_child.right_child.first_name+' '+client.left_child.right_child.last_name+'<br>\
                                                Registered Date - '+client.left_child.right_child.created_at+' ';
                                                $('#a-level-3-left-right').attr("data-id",client.left_child.right_child.id);
                    }
                }
                
                if(client.hasOwnProperty('right_child') && client.right_child!=null){
                    level_2_right =     'User ID - '+client.right_child.membership_no+' ('+client.right_child.get_sponsor.membership_no+')<br>\
                                        '+client.right_child.first_name+' '+client.right_child.last_name+'<br>\
                                        Registered Date - '+client.right_child.created_at+' ';
                                        $('#a-level-2-right').attr("data-id",client.right_child.id);

                    if(client.right_child.hasOwnProperty('left_child') && client.right_child.left_child!=null){

                        level_3_right_left =    'User ID - '+client.right_child.left_child.membership_no+' ('+client.right_child.left_child.get_sponsor.membership_no+')<br>\
                                                '+client.right_child.left_child.first_name+' '+client.right_child.left_child.last_name+'<br>\
                                                Registered Date - '+client.right_child.left_child.created_at+' ';
                                                $('#a-level-3-right-left').attr("data-id",client.right_child.left_child.id);
                    }
                    
                    
                    if(client.right_child.hasOwnProperty('right_child') && client.right_child.right_child!=null){
                        
                        level_3_right_right =   'User ID - '+client.right_child.right_child.membership_no+' ('+client.right_child.right_child.get_sponsor.membership_no+')<br>\
                                                '+client.right_child.right_child.first_name+' '+client.right_child.right_child.last_name+'<br>\
                                                Registered Date - '+client.right_child.right_child.created_at+' ';
                                                $('#a-level-3-right-right').attr("data-id",client.right_child.right_child.id);
                    }
                }
                
            }
            
            $('#level-1').html(level_1);
            $('#level-2-left').html(level_2_left);
            $('#level-2-right').html(level_2_right);
            $('#level-3-left-left').html(level_3_left_left);
            $('#level-3-left-right').html(level_3_left_right);
            $('#level-3-right-left').html(level_3_right_left);
            $('#level-3-right-right').html(level_3_right_right);

            $('.loader-wrapper').remove();

            
                 
        },
        error: function (xhr, status, error) {
            response.success = false;
            response.msg = xhr.statusText;
        }
    });
}



 /*
 |--------------------------------------------------------------------------
 | Invoke Loader
 |--------------------------------------------------------------------------
 */ 
 function invokeLoader(){
    if($('.loader-wrapper').length=='0'){
    var svg = '<div class="loader-wrapper" ><?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><g transform="translate(50 50)"><g><animateTransform attributeName="transform" type="rotate" values="0;45" keyTimes="0;1" dur="0.2s" repeatCount="indefinite"></animateTransform><path d="M29.491524206117255 -5.5 L37.491524206117255 -5.5 L37.491524206117255 5.5 L29.491524206117255 5.5 A30 30 0 0 1 24.742744050198738 16.964569457146712 L24.742744050198738 16.964569457146712 L30.399598299691117 22.621423706639092 L22.621423706639096 30.399598299691114 L16.964569457146716 24.742744050198734 A30 30 0 0 1 5.5 29.491524206117255 L5.5 29.491524206117255 L5.5 37.491524206117255 L-5.499999999999997 37.491524206117255 L-5.499999999999997 29.491524206117255 A30 30 0 0 1 -16.964569457146705 24.742744050198738 L-16.964569457146705 24.742744050198738 L-22.621423706639085 30.399598299691117 L-30.399598299691117 22.621423706639092 L-24.742744050198738 16.964569457146712 A30 30 0 0 1 -29.491524206117255 5.500000000000009 L-29.491524206117255 5.500000000000009 L-37.491524206117255 5.50000000000001 L-37.491524206117255 -5.500000000000001 L-29.491524206117255 -5.500000000000002 A30 30 0 0 1 -24.742744050198738 -16.964569457146705 L-24.742744050198738 -16.964569457146705 L-30.399598299691117 -22.621423706639085 L-22.621423706639092 -30.399598299691117 L-16.964569457146712 -24.742744050198738 A30 30 0 0 1 -5.500000000000011 -29.491524206117255 L-5.500000000000011 -29.491524206117255 L-5.500000000000012 -37.491524206117255 L5.499999999999998 -37.491524206117255 L5.5 -29.491524206117255 A30 30 0 0 1 16.964569457146702 -24.74274405019874 L16.964569457146702 -24.74274405019874 L22.62142370663908 -30.39959829969112 L30.399598299691117 -22.6214237066391 L24.742744050198738 -16.964569457146716 A30 30 0 0 1 29.491524206117255 -5.500000000000013 M0 -20A20 20 0 1 0 0 20 A20 20 0 1 0 0 -20" fill="#bababa"></path></g></g></svg></div>';
    $(svg).appendTo('body');
    }
}

