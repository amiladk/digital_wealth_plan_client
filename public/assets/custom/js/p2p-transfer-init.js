var sentOtp = 0;
var otpVerified =0;
$( document ).ready(function() {
   // $(".p2pSubmit").css("display", "none");
    // $(".verify").css("display", "none");
    

    // p2p trasfer recived amount
    $("#transfer_amount").keyup(function() {

        var transfer_amount     = parseFloat($('#transfer_amount').val());
        var available_balance   = parseFloat($('#available_balance').val());

        if(transfer_amount > available_balance){
            showAlert('Ooops!','Tansfer amount should be less than available balance.');
            $('#recieving_amount').val("");
        }else{
          if(transfer_amount){
            var transaction_fee    = $('#transaction_fee').val();;
            var recieving_amount   = (transfer_amount - transaction_fee).toFixed(2);
            $('#recieving_amount').val(recieving_amount);
          }else{
            $('#recieving_amount').val("");
          }
        }
    });

});

// function showOtpSend(ele){
//     if($(ele).is(":checked")){ 
//         $('#otp_row').show(); 
//     }else{
         
//     }
// }


// search send client

$("#client_select").keyup(function(){
  $("#client_select").removeClass("is-valid");
  $("#client_select").addClass("is-invalid");
  var value = $(this).val();
  if(value.length >= 7){
      searchClient();
  }
  else{
      $('#client-list').html('');
  }
})

function searchClient(){
  var inputData = $('#client_select').val();
  $.ajax({
      method:"GET",
      url:"/ajax/search-client",
      cache:false,
      async: false,
      headers: {
          'X-CSRF-TOKEN': token
      },
      data:{
          "_token"         : token,
          'input_data'     : inputData,
      },
      success:function(data){

        var html = "";
        $.each( data, function( key, value ) {

            html += '<button data-mno="'+value.membership_no+'" data-name="'+value.full_name+'" type="button" onclick="setClient(this);" class="btn btn-info btn-sm mb-1">\
                        <i class="fa fa-plus">\
                        </i></button> <a> '+value.membership_no+'-'+value.full_name+'</a>\
                    <br>';

        });
        $('#client-list').html(html);
      },
      error: function (xhr, status, error) {
          response.success = false;
          response.msg = xhr.statusText;

      }
  });

}


function setClient(ele){

  var membership_no = $(ele).attr("data-mno");

  $('#client_select').val(membership_no);
  $('#membership_no').val(membership_no);

  $("#client_select").removeClass("is-invalid");
  $("#client_select").addClass("is-valid");

  $('#client-list').html('');

  $("#receiver_name").html('Receiver Name : '+ $(ele).attr("data-name"));

}


$("#p2ptransfer-form" ).submit(function( event ) {
    
    var transfer_amount  = parseFloat($('#transfer_amount').val());
    var transfer_fee     = parseFloat($('#transaction_fee').val());

    if($("#client_select").hasClass("is-valid")){
        if(transfer_fee >= transfer_amount){
            showAlert('Ooops!','Sending amount should be greater than transaction fee!');
            event.preventDefault();
        }
        else{
            event.preventDefault();
            invokeLoader();
            var delayInMilliseconds = 1000; // second
                setTimeout(function() {
                    $('.loader-wrapper').remove()
                if (sentOtp == 0) {
                sendOtpMail();
                    sentOtp = 1
                }
            $('#otp-modal').modal('show');
            }, delayInMilliseconds);
        }
       
    }
    else{
        showAlert('Ooops!','Member Was Not Found');
        event.preventDefault();
    }
});



// var form = '';
// $(document).on("submit", "#p2ptransfer-form", function(event){
//     event.preventDefault();    
//     if (sentOtp == 0) {
//         sendOtpMail();
//         sentOtp = 1
//     }
//     form = this;
//     $('#otp-modal').modal('show');
// });


function verifyOtpByMailP2p(ele,) {
    
    var inputOtp = $('#otp').val();
  
    $(ele).closest('.custom-otp-wrap').find('#otp-error').remove();
    if(inputOtp == ''){
      $(ele).closest('.custom-otp-wrap').append('<label id="otp-error" class="text-danger" for="otp">This field is required.</label>');
    }
    else{
        verifyOtpP2p(inputOtp);
    }
  };


function verifyOtpP2p(){
    var inputOtp = $('#otp').val();
    $.ajax({
        method:"GET",
        url:"/ajax/verify-otp",
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"         : token,
            "input_otp"      : inputOtp,
            
        },
        success:function(data){
            if ((data.success == true)) {
                $("#p2ptransfer-form").unbind('submit').submit(); 
            }else{ 
                $('.custom-otp-wrap').append('<label id="otp-error" class="text-danger" for="otp">'+data.msg+'.</label>');
                //showAlert('error',data.msg,'error') 
            } 
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

