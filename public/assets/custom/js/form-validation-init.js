/*
|--------------------------------------------------------------------------
| Document ready
|--------------------------------------------------------------------------
*/
$( document ).ready(function() {
    formValidation();
    addWithdrawalsValidation();
    editWithdrawalsValidation();
    withdrawalValidation();
    loginFormValidation();
});



/*
|--------------------------------------------------------------------------
| Member Profile
|--------------------------------------------------------------------------
*/
function formValidation(){  
    
    $("#top-up-form").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            element.closest( ".form-group" ).append( error);
        },
        submitHandler: function (form) {
            invokeLoader();
            form.submit();
        }
    })
  }

  function loginFormValidation(){   
    
    $("#login-form").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            element.closest( ".form-group" ).append( error);
        },
        submitHandler: function (form) {
            invokeLoader();
            form.submit();
        }
       
    })
  }

 /*
|--------------------------------------------------------------------------
| Withdrawals 
|--------------------------------------------------------------------------
*/

  function addWithdrawalsValidation(){    
  var addWalletOtp = 0
    $("#add-wallet-form").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            element.closest( ".form-group" ).append( error);
        },
        submitHandler: function (form) {
            invokeLoader();
            var delayInMilliseconds = 1000; // second
            setTimeout(function() {
                $('.loader-wrapper').remove()
            if (addWalletOtp == 0) {
                $(".verify").show();
                sendOtpMail();
                // invokeLoader();
                addWalletOtp = 1
                $(".wallet-submit").hide();
            } 
        }, delayInMilliseconds);
        }
    })
  }
 
 

  function editWithdrawalsValidation(){    
    var editWalletOtp = 0;
    $("#edit-wallet-form").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            element.closest( ".form-group" ).append( error);
        },
        submitHandler: function (form) {

            invokeLoader();

            var delayInMilliseconds = 1000; // second

            setTimeout(function() {
                $('.loader-wrapper').remove()
                if (editWalletOtp == 0) {
                    $(".verify").show();
                    sendOtpMail();
                    editWalletOtp = 1
                    $(".wallet-submit").hide();
                } 
            }, delayInMilliseconds);
           
           
        }
       
    })
  }

  function withdrawalValidation(){    
  var withdrawalOtp = 0;
    $("#withdrawal-form").validate({
        // ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            element.closest( ".form-group" ).append( error);
        },
        submitHandler: function (form) {
            invokeLoader();
            var delayInMilliseconds = 1000; // second
            setTimeout(function() {
                $('.loader-wrapper').remove()
                if (withdrawalOtp == 0) {
                    sendOtpMail();
                    withdrawalOtp = 1;
                } 
                $('#otp-modal').modal('show');  
            }, delayInMilliseconds);
        }
       
    })
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

 



 