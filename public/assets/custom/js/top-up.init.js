// window.onload = function() {
//     var e = document.getElementById("top-up-form"),
//         a = new Pristine(e),
//         n = document.getElementById("funding-amount");
//     a.addValidator(n, function(e, t) {
//         return !(!e.length || e[0] !== e[0].toUpperCase())
//     }, "The first character must be capitalized", 2, !1), e.addEventListener("submit", function(e) {
//         e.preventDefault();
//         a.validate()
//     });



// $(function () {
//    $("#gfg").tabs({
//        active: false
//    });
// });

$( document ).ready(function() {
   $("#crypto-div").hide();
   $("#wallet-div").hide();
   $('#crypto-div').find('input, select, textarea, checkbox, radio, button').attr('disabled', true);
});

$("#wallet").click(function(){
   $("#crypto-div").hide();
   $("#wallet-div").show();
   $("#wallet").css({"color":"#ffffff","background-color":"#5156be","border-color":"#5156be"});
   $("#crypto").css({"color":"#5156be","background-color":"#fff","border-color":"#5156be"});
   $('#crypto-div').find('input, select, textarea, checkbox, radio, button').attr('disabled', true);
   $('#paymentmethod').val('2');
   $('#funding-amount').val(availableBalance);
   network_fee = 0;
   calculate();
});
$("#crypto").click(function(){
   $("#wallet-div").hide();
   $("#crypto-div").show();
   $("#crypto").css({"color":"#ffffff","background-color":"#5156be","border-color":"#5156be"});
   $("#wallet").css({"color":"#5156be","background-color":"#fff","border-color":"#5156be"});
   $('#crypto-div').find('input, select, textarea, checkbox, radio, button').attr('disabled', false);
   $('#paymentmethod').val('1');
   $('#funding-amount').val('');
   network_fee = $('#network').find(':selected').attr('data-network-fee');
   network_fee = parseFloat(network_fee) ? network_fee : 0;
   console.log(network_fee);
   calculate();
});



function calculate(){
   funding_amount  = parseFloat($('#funding-amount').val());
   
   $('#network_fee').html('$'+parseFloat(network_fee).toFixed(2));
   $('#service_charges').html('$'+parseFloat(service_charges).toFixed(2));
   if(isNaN(funding_amount)){
      $('#balance_funds_trade').html('-');
      $('#approximate_returns').html('-');
   } else{
      var balance_funds_trade = parseFloat(funding_amount -service_charges - network_fee).toFixed(2);
      var approximate_returns_trades	 = parseFloat(balance_funds_trade * 3 ).toFixed(2);
      $('#balance_funds_trade').html('$'+balance_funds_trade);
      $('#approximate_returns').html('$'+approximate_returns_trades);
   }     
}

$("#funding-amount").keyup(function(){
    var value = $(this).val();
  
    var funding_amount_val = $("#funding-amount").val()

    $('#fund_with_service_charges').html('$'+parseFloat(funding_amount_val).toFixed(2));

    if(isNaN(value)){
        if (!$(this).hasClass('is-invalid')) {
            $(this).addClass('is-invalid');
            $('#balance_funds_trade').html('-');
            $('#approximate_returns').html('-');
        }
    }else{
         $(this).removeClass('is-invalid');
         if ($('#paymentmethod').val()==2 && value>availableBalance) {
            showAlert('Ooops!','Funding amount cannot exceed your available balance.','warning');
            $(this).val(availableBalance);
         }
         calculate();
    }
});


//loading crypto networks when currency type changes
$('#currency_type').on('change', function() {
   $('#network').find('option').remove();
   $('#wallet_address').val('');

   var selected_currency = curency_types.find((currency_type) => currency_type.id == this.value);

   let firstOption = $('<option>', {value: '',text : 'Select a Network'});
   firstOption.attr('data-network-fee', 0);
   firstOption.attr('data-wallet-address', null);
   $('#network').append(firstOption);

   selected_currency.network_map.forEach(function(item, index, arr){
      let option = $('<option>', { value: item.crypto_network.id,text : item.crypto_network.title});
      option.attr('data-network-fee', item.crypto_network.network_fee);
      option.attr('data-wallet-address', item.crypto_network.company_wallet_address);
      $('#network').append(option);
   });
   network_fee = 0;
   calculate();
});

//loading wallet address and service charge when network changes
$('#network').on('change', function() {
   let wallet_address = $(this).find(':selected').attr('data-wallet-address');
   network_fee = $(this).find(':selected').attr('data-network-fee');
   $('#wallet_address').val(wallet_address);

   if( $('#network').val() == 1){
      $('.address_lable').html("Binance ID");
   }else{
    $('.address_lable').html("Wallet Address");
   }

   calculate();
});

//copy wallet address to clipboard
$('#copy_address').click(function() {
   if ($('#wallet_address').val()=='') {
      showAlert('Warning!','Please select a network first..','warning');
   }else{
      navigator.clipboard.writeText($('#wallet_address').val());
      showAlert('Success!','Address copied to clipboard successfully..','success');
   }
});



     /*
    |--------------------------------------------------------------------------
    |Image cropper function
    |--------------------------------------------------------------------------
    */
    var  $model = $('#imagecrop');
    var  $image = document.getElementById('canvace_image');
    var  cropper;
    var  image_name = '';


    $(document).on('change', '#image-chooser-top-up', function(e) {
    
        if(cropper){
            $image.src = null;
            cropper.destroy(),
            cropper = null;
        }
        removeImage();
        var files = e.target.files;

        var done = function(url){
            $image.src = url;
            if($('#canvace_image').show()){cropperInitialize();}
           
        }
        $('#image_crop_btn').html('<button type="button" class="btn btn-secondary" onclick="closeCrop()">Close</button>\
        <button type="button" class="btn btn-primary" onclick="cropImage();">Crop</button>');


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

         console.log(cropper);
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
      $('#image_crop_btn').html('');
      $('#crop-btn-area').html('');
      $('#image_crop_modal').modal('hide');
  }

  function removeImage(){
   $('#product-image-cropped').remove();
   }




  function cropImage(){

      if($("#image-chooser-top-up").val()){

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
                  $('#result-row').html(
                     '<div class="col-lg-3 product-image-cropped" id="product-image-cropped">\
                     <div class="card card-widget product-card">\
                     <div>\
                       <button type="button" class="btn btn-danger btn-sm float-right" style="width: 15%;" onclick="removeImage()"><i class="fa fa-times" aria-hidden="true"></i></button>\
                     </div>\
                     <div class="custom card-body">\
                       <div class="img-parent">\
                           <div class="imag-wrapper">\
                             <img class="img-fluid pad" src="'+base64data+'" alt="">\
                           </div>\
                       </div>\
                     </div>\
                   </div>\
                     <input type="hidden" name="image" value="'+base64data+'">\
                     <input type="hidden" name="image_name" value="'+image_name+'">'
                  );
                  // invokeLoader();
                  closeCrop();
                
                  // $model.modal('hide');
                  // sendFromData(base64data,index);
                  
              }
              

          });


      }
      else{
          Swal.fire('','image requierd','error');
      }

  };



  
//   function imageCrop(){

//    if($("#img_file").val()){

//        canvas = cropper.getCroppedCanvas({
//            width:350,
//            height:350,
//            });

//        canvas.toBlob(function(blob){
//            url = URL.createObjectURL(blob);
//            reader = new FileReader();
//            reader.readAsDataURL(blob);
//            reader.onload = function(e){
//                var base64data = reader.result;
//                //$('#result-row').append($('<img>').attr('src', base64data));
//               // $('#result-row').append('<div class="col-lg-3"><img src="'+base64data+'"/></div>');
//                $('#result-row').html('<input type="hidden" name="image" value="'+base64data+'">\
//                <input type="hidden" name="image_name" value="'+file_name+'">');
//               invokeLoader();
//               document.getElementById("profile-change-from").submit();
//            }

//        });

//    }
//    else{
//        toastr.error( "image requierd");
//    }

// };
   
    