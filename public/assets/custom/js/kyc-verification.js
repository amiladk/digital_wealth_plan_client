$( window ).on("load", function() {

    $('#country').val(user.country.name);

    var $validatorPersonalInfo = $("#kyc-personal-info-form").validate({
        rules: {
            first_name:{
                required: true,
            },
            last_name:{
                required: true,
            },
            full_name: {
                required: true,
            },
            dob:{
                required: true,
            },
            phone_number:{
                required: true,
                number: true
            },
            phone:{
                required: true,
                number: true
            },
            address:{
                required: true,
            },
            client_title:{
                required: true,
            },
            country:{
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if(error.text().length>0){
                $(element).filter(':not(.valid)').removeClass("is-valid").addClass("is-invalid");
            }
        },
        success: function(error) {
            //console.log(error);
            $("#kyc-personal-info-form").find('.valid').removeClass("is-invalid").addClass("is-valid");
        },
    });

    
    var $validatorFundSource = $("#source-of-funds-form").validate({
        rules: {
            "agree_laws_check[]": {
                required: true,
                minlength: 1
              },
              client_fund_source: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if(error.text().length>0){
                $(element).filter(':not(.valid)').removeClass("is-valid").addClass("is-invalid");
            }
        },
        success: function(error) {
            //console.log(error);
            $("#source-of-funds-form").find('.valid').removeClass("is-invalid").addClass("is-valid");
        },
    });



    var $validatorTermsAndCondition = $("#terms-and-condition-form").validate({
        rules: {
            "terms_and_condition[]": {
                required: true,
                minlength: 1
              }
        },
        errorPlacement: function(error, element) {
            if(error.text().length>0){
                $(element).filter(':not(.valid)').removeClass("is-valid").addClass("is-invalid");
            }
        },
        success: function(error) {
            //console.log(error);
            $("#terms-and-condition-form").find('.valid').removeClass("is-invalid").addClass("is-valid");
        },
    });

    

    var $validatorKycDocumentImageAndType = $("#kyc-document-image-and-type-form").validate({
        rules: {
            identity_doc_type: {
                required: true,
            },
            nic_no: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if(error.text().length>0){
                $(element).filter(':not(.valid)').removeClass("is-valid").addClass("is-invalid");
            }
        },
        success: function(error) {
            //console.log(error);
            $("#kyc-document-image-and-type-form").find('.valid').removeClass("is-invalid").addClass("is-valid");
        },
    });





   
    $("#progrss-wizard").bootstrapWizard({
        onTabShow: function(a, i, s) {
            i = (s + 1) / i.find("li").length * 100;
            $("#progrss-wizard").find(".progress-bar").css({
                width: i + "%"
            })
        },
        'onNext': function(tab, navigation, index) {
            if (index==1) {
                var $valid = $("#kyc-personal-info-form").valid();
        
                if (!$valid) {
                    $validatorPersonalInfo.focusInvalid();
                    return false;
                }
                else{
                    saveForm('kyc-personal-info-form','/ajax/update-kyc-personal-info');
                }
            }

            if (index==2) {
                var $valid = $("#kyc-document-image-and-type-form").valid();
                var $image_valid = imageValidation();
        
                if (!$valid || !$image_valid) {
                    if(!$valid){
                        $validatorKycDocumentImageAndType.focusInvalid();
                    }
                    return false;
                }
                else{
                    // saveForm('kyc-document-image-and-type-form','/ajax/update-kyc-personal-info');
                }
               
                console.log($image_valid);

            }

            if (index==3) {
                var $valid = $("#source-of-funds-form").valid();

                if (!$valid) {
                    $validatorFundSource.focusInvalid();
                    return false;
                }else{
                    saveForm('source-of-funds-form','/ajax/update-kyc-source-of-funds');
                }
            
            }

            if (index==4) {
                var $valid = $("#terms-and-condition-form").valid();

                if (!$valid) {
                    $validatorTermsAndCondition.focusInvalid();
                    return false;
                }else{
                    saveForm('terms-and-condition-form','/ajax/update-kyc-terms-and-condition');
                }
            }

            //console.log(index);
             
        },
    })


    function imageValidation(){

        var validate            = true;
        var identity_doc_type   = $('#identity_doc_type').val();

        if($('#upload-img-msg-fa-6').length === 0){
            validate = false;
            $('#upload-img-btn-6').removeClass("is-valid").addClass("is-invalid");
            $('#upload-img-msg-6').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
        }
        else{
            $('#upload-img-btn-6').removeClass("is-invalid").addClass("is-valid");
        }

        if(identity_doc_type == 1){

            if($('#upload-img-msg-fa-1').length === 0){
                validate = false;
                $('#upload-img-btn-1').removeClass("is-valid").addClass("is-invalid");
                $('#upload-img-msg-1').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
            }
            else{
                $('#upload-img-btn-1').removeClass("is-invalid").addClass("is-valid");
            }

            if($('#upload-img-msg-fa-2').length === 0){
                validate = false;
                $('#upload-img-btn-2').removeClass("is-valid").addClass("is-invalid");
                $('#upload-img-msg-2').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
            }
            else{
                $('#upload-img-btn-2').removeClass("is-invalid").addClass("is-valid");
            }
        }

        if(identity_doc_type == 2){

            if($('#upload-img-msg-fa-3').length === 0){
                validate = false;
                $('#upload-img-btn-3').removeClass("is-valid").addClass("is-invalid");
                $('#upload-img-msg-3').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
            }
            else{
                $('#upload-img-btn-3').removeClass("is-invalid").addClass("is-valid");
            }

            if($('#upload-img-msg-fa-4').length === 0){
                validate = false;
                $('#upload-img-btn-4').removeClass("is-valid").addClass("is-invalid");
                $('#upload-img-msg-4').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
            }
            else{
                $('#upload-img-btn-4').removeClass("is-invalid").addClass("is-valid");
            }

        }

        if(identity_doc_type == 3){

            if($('#upload-img-msg-fa-5').length === 0){
                validate = false;
                $('#upload-img-btn-5').removeClass("is-valid").addClass("is-invalid");
                $('#upload-img-msg-5').html('<i class="fa fa-exclamation text-danger" aria-hidden="true"></i>');
            }
            else{
                $('#upload-img-btn-5').removeClass("is-invalid").addClass("is-valid");
            }

        }

        return validate;
    }

    $("#identity_doc_type").change(function(){
        var value = $(this).val();
        if(value == 1){
            identityHtml();
        }

        if(value == 2){
            driversLicenseHtml();
        }

        if(value == 3){
            passportHtml();
        }

    });

    $('#image_crop_modal').modal({backdrop: 'static', keyboard: false}, 'show');

});



function identityHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                                <label class="form-label" for="default-input">Identity Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-1" onclick="showCropModal(1)" class="btn btn-primary" type="button">Upload Identity Front Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-1"></span>\
                                                </div>\
                                                <div id="result-row-1" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                               </div>\
                                               <div class="col-lg-6 mb-3">\
                                               <label class="form-label" for="default-input">Identity Back Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-2" onclick="showCropModal(2)" class="btn btn-primary" type="button">Upload Identity Back Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-2"></span>\
                                                </div>\
                                                <div id="result-row-2" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                               </div>'
                                               
                                               
                                               );
}


function driversLicenseHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                                <label class="form-label" for="default-input">License Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-3" onclick="showCropModal(3)" class="btn btn-primary" type="button">Upload License Front Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-3"></span>\
                                                    <div id="result-row-3" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                               </div>\
                                               <div class="col-lg-6 mb-3">\
                                               <label class="form-label" for="default-input">License Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                 <button id="upload-img-btn-4" onclick="showCropModal(4)" class="btn btn-primary" type="button">Upload License Back Image <span class="required-color">*</span> </button>\
                                                 <span id="upload-img-msg-4"></span>\
                                                 <div id="result-row-4" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                               </div>');
}

function passportHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                            <label class="form-label" for="default-input">Passport Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                <button id="upload-img-btn-5" onclick="showCropModal(5)" class="btn btn-primary" type="button">Upload Passport Image <span class="required-color">*</span> </button>\
                                                <span id="upload-img-msg-5"></span>\
                                                <div id="result-row-5" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                              </div>');
}


function saveForm(formname,url){
    response = new Object();
    var serFormData = $("#"+formname).serialize();
    var formData = {};

    // $.each(serFormData, function(i, field){
    //     formData[field.name] = field.value;
    // });

    $.ajax({
        method:"POST",
        url:url,
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:serFormData,
        // data:{
        //     "_token"            : token,
        //     formData            : serFormData
        // },
        success:function(data){
            response = data;

            if(formname == 'terms-and-condition-form'){
                showAlert('Done!',response.msg,'success');
                window.location.href = "/kyc-verified-details";
            }
        },
        error: function (xhr, status, error) {
            response.success = false;
            response.msg = xhr.statusText;
        }
    });
    return response;
}




    /*
    |--------------------------------------------------------------------------
    |Image cropper function
    |--------------------------------------------------------------------------
    */
    var  $model = $('#imagecrop');
    var  $image = document.getElementById('canvace_image');
    var  cropper;
    var  image_name = '';


    $(document).on('change', '#image_chooser', function(e) {
    
        if(cropper){
            $image.src = null;
            cropper.destroy(),
            cropper = null;
        }

        var files = e.target.files;

        var done = function(url){
            $image.src = url;
            if($('#canvace_image').show()){cropperInitialize();}
            //cropBtnAreaIDFrontHtml();
        }

        var reader;
        var file;
        var url;

      if(files && files.length>0){
          file = files[0];
          image_name = file.name;
          if(URL){
            done(URL.createObjectURL(file));
          }else if(FileReader){
            reader =  new FileReade();
            reder.onload = function(e){
              done(reader.result);
            }
            reader.readAsDataURL(file);
          }
      }

    });

    function cropperInitialize(){
        cropper = new Cropper($image,{
            dragMode: 'move',
            // aspectRatio:1,
            // autoCropArea: 1,
            restore: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            autoCropArea: 1
          

            // viewMode: 1,
            // aspectRatio: 1,
            // maxContainerWidth: 100,
            // maxContainerHeight: 100,
            // maxCropBoxWidth: 100,
            // maxCropBoxHeight: 100,
            // maxCanvasHeight:100,
            // maxCanvasWidth:100,
            // movable: true,
            // maxWidth:100,
            // maxHeight:100,
            // minCropBoxWidth: 100,
            // minCropBoxHeight: 100,
         });

        //  cropper.initialCanvasData.maxWidth = 100;
        // cropper.initialCanvasData.maxHeight = 100;

        
    }


    function showCropModal(index){

        var title = '';
        if(index == 1){
            title = 'Identity Front Image';
        }

        if(index == 2){
            title = 'Identity Back Image';
        }

        if(index == 3){
            title = 'Drivers License Front Image';
        }

        if(index == 4){
            title = 'Drivers License Back Image';
        }

        if(index == 5){
            title = 'Passport Image';
        }

        if(index == 6){
            title = 'Selfie Image';
        }


        $('#image_crop_modal_title').html(title);
        $('#image_crop_modal_footer').html('<button type="button" class="btn btn-secondary" onclick="closeCrop()">Close</button>\
                                            <button type="button" class="btn btn-primary" onclick="cropImage('+index+');">Upload</button>');
        
        $('#image_crop_modal').modal('show');
    
    }

    function closeCrop(){
        if(cropper){
            $image.src = null;
            cropper.destroy(),
            cropper = null;
        }
        image_name = '';
        $("#image_chooser" ).val(null);
        $('#canvace_image').hide();
        $('#crop-btn-area').html('');
        $('#image_crop_modal').modal('hide');
    }



    function cropImage(index){

        if($("#image_chooser").val()){

            canvas = cropper.getCroppedCanvas({
                width:350,
                height:350,
                });

            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onload = function(e){
                    var base64data = reader.result;
                    $model.modal('hide');
                    sendFromData(base64data,index);
                    var base64data = reader.result;
                    
                    
                }

            });

        }
        else{
            Swal.fire('','image requierd','error');
        }

    };




    function sendFromData(base64data,index){

        var base_url            = window.location.origin;
        var identity_doc_type   = $('#identity_doc_type').val();
        var nic_no              = $('#nic_no').val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url:  base_url+"/ajax/upload-kyc-crop-images",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
                },
            data: {
                '_token'            : token,
                'image'             : base64data,
                'index'             : index,
                'image_name'        : image_name,
                'identity_doc_type' : identity_doc_type,
                'nic_no'            : nic_no,
            },
            success: function(response){
                
                console.log(response);
              

                if(response.success==true){
                    $('#result-row-'+index).html('<img class="img-fluid pad" src="'+base64data+'" alt="">');
                     
                    $('#upload-img-msg-'+index).html('<i id="upload-img-msg-fa-'+index+'" class="fa fa-check text-success" aria-hidden="true"></i>');
                    $('#upload-img-btn-'+index).removeClass("is-invalid").addClass("is-valid");
                    if (index==1) {
                        $('#upload-img-btn-'+index).html("Uploaded  Identity Front Image");  
                    }
                    if (index==2) {
                        $('#upload-img-btn-'+index).html("Uploaded Identity Back Image");  
                    }
                    if (index==3) {
                        $('#upload-img-btn-'+index).html("Uploaded License Front Image");  
                    }
                    if (index==4) {
                        $('#upload-img-btn-'+index).html("Uploaded  License Back Image");  
                    }
                    if (index==5) {
                        $('#upload-img-btn-'+index).html("Uploaded  Passport Image");  
                    }
                    if (index==6) {
                        $('#upload-img-btn-'+index).html("Uploaded Selfie Photo");  
                    }
                     
                    closeCrop();
                    Swal.fire('Done','Image Uploaded','success');
                }
                else{
                    closeCrop();
                    Swal.fire('Opps',response.msg,'error');
                }
            
            }
            
        
        });

    }

// phone number with country
    
    // var code = "+91"; // Assigning value from model.
    if($('#phone').val()==''){
        $('#phone').val('+94');
    }
    $('#phone').intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        dropdownContainer: document.body,
        formatOnDisplay: true,
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: true,
        placeholderNumberType: "+91123456789",
        preferredCountries: ['US'],
        separateDialCode: true,
    }).on('countrychange', function (e, countryData) {
        validatePhone();
    });

    $("#phone").keyup(function(){
        validatePhone();
    });

function validatePhone(){
    var country_code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
    var phoneNumber = $('#phone').val();
    if (phoneNumber.charAt( 0 ) == '0') {
        $('#phone').val(phoneNumber.substring(1));
    }
    if (!/^[0-9]{9,10}$/.test(phoneNumber)) {
        $("#phone_number_error").html("Please enter a valid phone number").addClass("required-color");
        $('#phone_number').val('')
        return false;
    }
    $("#phone_number_error").html("");
    var phone = '+' + country_code + phoneNumber;
    $('#phone_number').val(phone);
    return true;
}



// country select
mobiscroll.setOptions({
    locale: mobiscroll.localeEn,   // Specify language like: locale: mobiscroll.localePl or omit setting to use default
    theme: 'ios',                  // Specify theme like: theme: 'ios' or omit setting to use default
    themeVariant: 'light'          // More info about themeVariant: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-themeVariant
});

var inst = mobiscroll.select('#country', {
    display: 'anchored',           // Specify display mode like: display: 'bottom' or omit setting to use default
    filter: true,                  // More info about filter: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-filter
    itemHeight: 40,                // More info about itemHeight: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-itemHeight
    renderItem: function (item) {  // More info about renderItem: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-renderItem
        return '<div class="md-country-picker-item">' +
            '<img class="md-country-picker-flag" src="https://img.mobiscroll.com/demos/flags/' + item.data.value + '.png" />' +
            item.display + '</div>';
    }
});

mobiscroll.util.http.getJson('https://trial.mobiscroll.com/content/countries.json', function (resp) {
    var countries = [];
    for (var i = 0; i < resp.length; ++i) {
        var country = resp[i];
        countries.push({ text: country.text, value: country.value });
    }
    inst.setOptions({ data: countries });
});
