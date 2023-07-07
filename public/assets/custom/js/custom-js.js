
    $( document ).ready(function() {

        var countDecimals = function (value) {
            if(Math.floor(value) === value) return 0;
            return value.toString().split(".")[1].length || 0; 
        }
     
        // withdrawals recive amount
        $("#withdraw_amount").keyup(function() {

            var withdraw_amount     = parseFloat($('#withdraw_amount').val());
            var available_balance   = parseFloat($('#available_balance').val());

            //console.log(withdraw_amount);
            //console.log(available_balance);

            if(withdraw_amount > available_balance){
                showAlert('Ooops!','Withdrawal amount should be less than available balance.');
                $('#recieving_amount').val("");
            }else{
              if(withdraw_amount){
                var transaction_fee    = $('#transaction_fee').val();;
                var recieving_amount   = withdraw_amount - transaction_fee;

                if(Number(recieving_amount) === recieving_amount && recieving_amount % 1 !== 0){
                  if(countDecimals(recieving_amount) == 1){
                    recieving_amount = recieving_amount.toFixed(1);
                  }
                  else{
                    recieving_amount = recieving_amount.toFixed(2);
                  } 
                }
                $('#recieving_amount').val(recieving_amount);
              }else{
                $('#recieving_amount').val("");
              }
            }
            
        });

        function countDecimals (value) {
          if(Math.floor(value) === value) return 0;
          return value.toString().split(".")[1].length || 0; 
        }
  });

/*
|--------------------------------------------------------------------------
| Delete Wallet
|--------------------------------------------------------------------------
*/

function deleteWallet(id){

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want delete this?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes!'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        'Success!',
        'Your wallet has been deleted.',
        'success',
      )

      var base_url = window.location.origin;

      $.ajax({  
          type: "POST",
          url: base_url+'/action/withdrawal-delete',
          headers: {
              'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
          },
          data: {
             '_token': token,
              'id'    : id,  
          },
          cache:false,     
          success: function(response) {   
            location.reload();
            
          }
      });

    }
  })
}

// selected wallet
$(".client_wallet").on("click", function () {
    $('.client_wallet').removeClass("active");
    $(this).addClass("active");
    $(".wallet-input").prop('disabled', true);
    $('a.active .wallet-input').prop('disabled', false);
});


function showAlert(title,msg,type) {
  Swal.fire({
    title: title,
    text: msg,
    icon: type,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok'
  })
}



function showViewModal(index){

//
console.log(client_wallets[index]); 
 var single_wallet = client_wallets[index];
  
  $('#id-1').val(single_wallet.id);
  $('#currency_type-1').val(single_wallet.currency_type.id);
  $('#cypto_network-1').val(single_wallet.cypto_network.id);
  $('#wallet_address-1').val(single_wallet.wallet_address);

}


function closeEmailVerifiedModal(){
  $('#email-verified-modal').modal('hide');
}


function modeChange(){

  var base_url = window.location.origin;

    $.ajax({  
        type: "POST",
        url: base_url+'/ajax/change-auth-user-theme-mode',
        headers: {
            'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
        },
        data: {
            '_token': token,
        },
        cache:false,     
        success: function(response) {   
          //location.reload();
        }
    });
}

/*
|--------------------------------------------------------------------------
|Send OTP
|--------------------------------------------------------------------------
*/

function sendOtpMail() {
 
  sendOtp();
};

function sendOtp(){
  
  $.ajax({
      method:"POST",
      url:"/ajax/send-otp",
      cache:false,
      async: false,
      headers: {
          'X-CSRF-TOKEN': token
      },
      data:{
          "_token"         : token,
          
      },
      
      success:function(data){
        
          if ((data.success == true)) {
            
              showAlert('Success!','OTP has been sent to your email & phone.','success') 
              $(".send-otp").hide();
              $(".verify").show();
          }else{ 
              showAlert('error','oops! Something went wrong.','error') 
          } 
      },
      error: function (xhr, status, error) {
          response.success = false;
          response.msg = xhr.statusText;

      }
  });

}


function verifyOtpByMail(ele,type) {
  if(type=='add'){
    var inputOtp = $('#otp').val();
  }
  if(type=='edit'){
    var inputOtp = $('#otp-edit').val();
  }
  if(type=='submit'){
    var inputOtp = $('#otp_submit').val();
    
  }
  $(ele).closest('.custom-otp-wrap').find('#otp-error').remove();
  if(inputOtp == ''){
    $(ele).closest('.custom-otp-wrap').append('<label id="otp-error" class="text-danger" for="otp">This field is required.</label>');
  }
  else{
    verifyOtp(inputOtp);
  }
};

function verifyOtp(inputOtp){
  
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
        console.log(data);

          if ((data.success == true)) {
              showAlert('success',data.msg,'success') 
              $(".wallet-submit").show();
              $(".pasword-change").css('display','block');
              $(".send-otp").hide();
              $(".verify-button").removeClass("btn-primary");
              $(".verify-button").addClass("btn-success");
              $(".verify-button").html('verified');
              $('.otp').prop('readonly', true);
              //$('.verify').css('display','block');
          }else{ 
              showAlert('error',data.msg,'error') 
          } 
      },
      error: function (xhr, status, error) {
          response.success = false;
          response.msg = xhr.statusText;

      }
  });

}















