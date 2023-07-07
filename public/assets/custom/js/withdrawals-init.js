var  sentOtp = 0
$( document ).ready(function() {
    withdrawalsPlansCounts();
    //$(".wallet-submit").hide();
    
});

// function sendOtpMail() {
//     sendOtp();
//   };

function withdrawalsPlansCounts(){
   
    $.ajax({
        method:"GET",
        url:"/ajax/withdrawals-plans-counts",
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"          : token,
           
        },
        success:function(data){
            
            if ((data.success == true)) {
                
                $("#loader").html(null);
                if (data.data.length === 0) { 
                    var tr = '<tr>\
                                <td style="width: 50px;">\ No Data </td>\
                             </tr>';
                    $( "#withdrawal-all-tbody" ).append( tr );
                    $( "#withdrawal-pending-tbody" ).append( tr );
                    $( "#withdrawal-approved-tbody" ).append( tr );
                    $( "#withdrawal-not-approved-tbody" ).append( tr );
                }

                $.each(data.data, function(index, value) {

                    //console.log(value);

                    var status_icon = '';

                    if(value.status == 0){
                        status_icon = '<div class="font-size-22 text-warning"><i class="bx bx-down-arrow-circle d-block"></i></div>';
                    }else if(value.status == 1){
                        status_icon = '<div class="font-size-22 text-success"><i class="bx bx-up-arrow-circle d-block"></i></div>';
                    }else{
                        status_icon = '<div class="font-size-22 text-danger"><i class="bx bx-down-arrow-circle d-block"></i></div>';
                    }

                    var tr = '<tr>\
                                <td style="width: 50px;">\
                                    '+status_icon+'\
                                </td>\
                                <td>\
                                    <div>\
                                    <h5 class="font-size-14 mb-0 text-muted">'+value.created_at+'</h5>\
                                    </div>\
                                </td>\
                                <td>\
                                    <div class="text-end">\
                                    <h5 class="font-size-14 text-muted mb-0">'+ '$'+parseFloat(value.withdraw_amount).toFixed(2)+'</h5>\
                                    </div>\
                                </td>\
                                <td>\
                                    <div class="text-end">\
                                    <h5 class="font-size-14 text-muted mb-0">'+ '$'+parseFloat(value.transaction_fee).toFixed(2)+'</h5>\
                                    </div>\
                                </td>\
                                <td>\
                                    <div class="text-end">\
                                    <h5 class="font-size-14 text-muted mb-0">'+ '$'+parseFloat(value.recieving_amount).toFixed(2)+'</h5>\
                                    </div>\
                                </td>\
                            </tr>';
                            
                    $( "#withdrawal-all-tbody" ).append( tr );

                    if(value.status == 0){
                        $( "#withdrawal-pending-tbody" ).append( tr );
                    }else if(value.status == 1){
                        $( "#withdrawal-approved-tbody" ).append( tr );
                    }else{
                        $( "#withdrawal-not-approved-tbody" ).append( tr );
                    }

                });  
            }else{
                $("#loader").html(null);
                var tr = '<tr>\
                                <td style="width: 50px;">\ No Data </td>\
                             </tr>';
                $( "#withdrawal-all-tbody" ).append( tr );
                $( "#withdrawal-pending-tbody" ).append( tr );
                $( "#withdrawal-approved-tbody" ).append( tr );
                $( "#withdrawal-not-approved-tbody" ).append( tr );
            }
           
        },
        
        error: function (xhr, status, error) {
            $("#loader").html(null);
            var tr = '<tr>\
                            <td style="width: 50px;">\ No Data </td>\
                            </tr>';
            $( "#withdrawal-all-tbody" ).append( tr );
            $( "#withdrawal-pending-tbody" ).append( tr );
            $( "#withdrawal-approved-tbody" ).append( tr );
            $( "#withdrawal-not-approved-tbody" ).append( tr );
        }
    });
   // return response;    
} 

function verifyOtpByMailwithdrawal(ele,type) {   
    if(type=='submit'){
        var inputOtp = $('#withdrawal-otp').val();
    }
    if(type =='edit'){
        var inputOtp = $('#otp-edit').val();
        //console.log(inputOtp);
    }
    if(type =='add'){
        var inputOtp = $('#otp-add').val();
        //console.log(inputOtp);
    }
  
    $(ele).closest('.custom-otp-wrap-otp').find('#otp-error').remove();
    if(inputOtp == ''){
      $(ele).closest('.custom-otp-wrap-otp').append('<label id="otp-error" class="text-danger" for="otp">This field is required.</label>');
    }
    else{
        //$("#withdrawal-form").unbind('submit').submit(); 
        verifyOtpWithdrawal(inputOtp,type);
    }
  };


  function verifyOtpWithdrawal(inputOtp, type){
    // var inputOtp = $('#otp').val();
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
                if (type=='submit') {
                    $("#withdrawal-form").unbind('submit').submit();   
                }
                if (type=='edit') {
                    $("#edit-wallet-form").unbind('submit').submit();   
                }
                if (type=='add') {
                    $("#add-wallet-form").unbind('submit').submit();   
                }
                

            }else{ 
                $('.custom-otp-wrap-otp').append('<label id="otp-error" class="text-danger" for="otp">'+data.msg+'.</label>');
                //showAlert('error',data.msg,'error') 
            } 
        },
        error: function (xhr, status, error) {
            response.success = false;
            response.msg = xhr.statusText;
  
        }
    });
  
  }