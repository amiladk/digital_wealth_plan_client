function currentTime() {
    let date = new Date(); 
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    let session = "AM";
  
      
    if(hh > 12){
        session = "PM";
     }
  
     hh = (hh < 10) ? "0" + hh : hh;
     mm = (mm < 10) ? "0" + mm : mm;
     ss = (ss < 10) ? "0" + ss : ss;
      
     let time = hh + ":" + mm + ":" + ss + " " + session;
  
    document.getElementById("current-date").innerText = time; 
    let t = setTimeout(function(){ currentTime() }, 1000); 
  
  }
  

$( document ).ready(function() {

//     var radialchartColors = getChartColorsArray("#invested-overview"),
//     options = {
//         chart: {
//             height: 270,
//             type: "radialBar",
//             offsetY: -10
//         },
//         plotOptions: {
//             radialBar: {
//                 startAngle: -130,
//                 endAngle: 130,
//                 dataLabels: {
//                     name: {
//                         show: !1
//                     },
//                     value: {
//                         offsetY: 10,
//                         fontSize: "18px",
//                         color: void 0,
//                         formatter: function(r) {
//                             return r + "%"
//                         }
//                     }
//                 }
//             }
//         },
//         colors: [radialchartColors[0]],
//         fill: {
//             type: "gradient",
//             gradient: {
//                 shade: "dark",
//                 type: "horizontal",
//                 gradientToColors: [radialchartColors[1]],
//                 shadeIntensity: .15,
//                 inverseColors: !1,
//                 opacityFrom: 1,
//                 opacityTo: 1,
//                 stops: [20, 60]
//             }
//         },
//         stroke: {
//             dashArray: 4
//         },
//         legend: {
//             show: !1
//         },
//         series: [80],
//         labels: ["Series A"]
//     };
// (chart = new ApexCharts(document.querySelector("#invested-overview"), options)).render();

 currentTime();
 dataCount();
 rewardsCount();
 purchasedPlansCounts();
});

function getChartColorsArray(r) {
    r = $(r).attr("data-colors");
    return (r = JSON.parse(r)).map(function(r) {
        r = r.replace(" ", "");
        if (-1 == r.indexOf("--")) return r;
        r = getComputedStyle(document.documentElement).getPropertyValue(r);
        return r || void 0
    })
}


function dataCount(){
   

    $.ajax({
        method:"GET",
        url:"/ajax/dashbord-counts", 
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"          : token,
           
        },

        success:function(data){

            if (data.success == true) {
                    
                $('#holding-balance').html("$"+data.holding_wallet);
                $('#left-bv-rewards').html("$"+data.left_bv_rewards);
                $('#right-bv-rewards').html("$"+data.right_bv_rewards);
                $('#left-user-count').html(data.left_head_count);
                $('#right-user-count').html(data.right_head_count);
                $('#available-balance').html("$"+data.wallet);
                $('#left-bv-after_balance').html("$"+data.left_bv_after_balance);
                $('#right-bv-after_balance').html("$"+data.right_bv_after_balance);
                $('#left-user-direct-count').html(data.left_user_direct_count);
                $('#right-user-direct-count').html(data.right_user_direct_count);
                $('#p2p-sent').html("$"+data.p2p_sent);
                $('#p2p-received').html("$"+data.p2p_received);

            }else{
                showAlert('error','oops! Something went wrong.','error') 
            }
             
        },
        error: function (xhr, status, error) {
            response.success = false;
            response.msg = xhr.statusText;
        }
    });
    //return response;    
      
}


function rewardsCount(){
   

    $.ajax({
        method:"GET",
        url:"/ajax/rewards-counts",
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"          : token,
           
        },
        success:function(data){
            if (data.success == true) {
                
                $('#bv-ewards').html("$"+data.bv_rewards);
                $('#referral-rewards').html("$"+data.referral_rewards);
                $('#daily_rewards').html("$"+data.daily_rewards);
                $('#total-earnings').html("$"+data.total_earnings);
                $('#withdrawals').html("$"+data.withdrawals);
                $('#to-up-by-wallet').html("$"+data.to_up_by_wallet);
                $('#total-fund').html("$"+data.total_fund);
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



function purchasedPlansCounts(){
   
    $.ajax({
        method:"GET",
        url:"/ajax/purchased-plans-counts",
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
                    $( "#purchased-plans-tbody" ).append( tr );
                    $( "#purchased-plans-tbody-active" ).append( tr );
                    $( "#purchased-plans-tbody-completed" ).append( tr );
                    $( "#purchased-plans-tbody-pending" ).append( tr );
                }

                $.each(data.data, function(index, value) {
                    //console.log(value);
                    var  funding_type ='';
                    var funding_icon = '';
                    var trading_amount = value.trading_amount; 
                    var created_at = value.created_at;
                    if (value.funding_type == 1) {
                        funding_type = 'Initial Fund';  
                    
                    }else if (value.funding_type == 2) {
                        funding_type = 'Top-Up';
                        
                    }

                    if(value.status == 0){
                        funding_icon = '<div class="font-size-22 text-warning"><i class="bx bx-down-arrow-circle d-block"></i></div>';
                        active_status = 'Pending';
                    }else{
                        if (value.other_rewards_completed == 0) {
                            funding_icon = '<div class="font-size-22 text-success"><i class="bx bx-up-arrow-circle d-block"></i></div>';
                            active_status = 'Active';
                        }else if (value.other_rewards_completed == 1) {
                            funding_icon = '<div class="font-size-22 text-danger"><i class="bx bx-down-arrow-circle d-block"></i></div>';
                            active_status = 'Inactive';
                        }
                    }

                    var tr = '<tr>\
                                <td style="width: 50px;">\
                                    '+funding_icon+'\
                                </td>\
                                <td>\
                                    <div>\
                                        <h5 class="font-size-14 mb-1" id = "initial-funding">'+funding_type+' - '+value.funding_payment_method+' ( '+active_status+' )</h5>\
                                        <p class="text-muted mb-0 font-size-12">'+created_at+'</p>\
                                    </div>\
                                </td>\
                                    <td>\
                                    <div class="text-end">\
                                        <h5 class="font-size-14 text-muted mb-0">'+ '$'+trading_amount+'</h5>\
                                        <p class="text-muted mb-0 font-size-12">Amount</p>\
                                    </div>\
                                </td>\
                            </tr>';

                    $( "#purchased-plans-tbody" ).append( tr );
                    

                    if (value.status == 0) {
                        $( "#purchased-plans-tbody-pending" ).append( tr );
                    }else{
                        if (value.other_rewards_completed == 0) {

                            $( "#purchased-plans-tbody-active" ).append( tr );
                        
                        }else if (value.other_rewards_completed == 1) {
                            
                            $( "#purchased-plans-tbody-completed" ).append( tr );
     
                        }
                    }

                    });  
            }else{
                $("#loader").html(null);
                var tr = '<tr>\
                                <td style="width: 50px;">\ No Data </td>\
                             </tr>';
                $( "#purchased-plans-tbody" ).append( tr );
                $( "#purchased-plans-tbody-active" ).append( tr );
                $( "#purchased-plans-tbody-completed" ).append( tr );
                $( "#purchased-plans-tbody-pending" ).append( tr );
            }
           
        },
        
        error: function (xhr, status, error) {
            $("#loader").html(null);
            var tr = '<tr>\
                            <td style="width: 50px;">\ No Data </td>\
                            </tr>';
            $( "#purchased-plans-tbody" ).append( tr );
            $( "#purchased-plans-tbody-active" ).append( tr );
            $( "#purchased-plans-tbody-completed" ).append( tr );
            $( "#purchased-plans-tbody-pending" ).append( tr );
        }
    });
   // return response;    
      
}


function copyReferralLink(id , value) {
    
    var base_url = window.location.origin;
    navigator.clipboard.writeText
        (base_url+"/sign-up?ref="+id+"&ref_s="+value);

       
        var side;
        if (value===0) {
            side ='Left';
         }else{
            side= "Right ";
         }

        Swal.fire(
            'Good job!',
            'Your  ' +side+ ' Referral link Copied !',
            'success'
          )
                
} 


function senReferralLink(id) {
        var inputString = $("#phone_number").val();
        var base_url = window.location.origin
        var referral_link = 'https://wa.me/'+inputString+'?text'+base_url+"/sign-up?ref="+id+"&ref_s="+$("#hidden-data").val();
        window.open(referral_link);
   
}

function openModal(event,id){
event.preventDefault();
    $("#hidden-data").val(id);
    $("#share-link-model").modal("toggle");
    if(id==0){
        $(".share-link-title").html('Sharing your LEFT Chain Link');
    }else{
        $(".share-link-title").html('Sharing your RIGHT Chain Link');
    }
}



// phone number with country
$(function () {
    var code = "+94"; // Assigning value from model.
    $('#phone').val(code);
    $('#phone').intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        dropdownContainer: document.body,
        formatOnDisplay: true,
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: true,
        placeholderNumberType: "+94123456789",
        preferredCountries: ['US'],
        separateDialCode: true
    }).on('countrychange', function (e, countryData) {
        validatePhone();
    });

    $("#phone").keyup(function(){
        validatePhone();
    });

});

function validatePhone(){
    var country_code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
    var phoneNumber = $('#phone').val();
    if (phoneNumber.charAt( 0 ) == '0') {
        $('#phone').val(phoneNumber.substring(1));
    }
    if (!/^[0-9]{9}$/.test(phoneNumber)) {
        $("#phone_number_error").html("Please enter a valid phone number").addClass("required-color");
        $('#phone_number').val('')
        return false;
    }
    $("#phone_number_error").html("");
    var phone = '+' + country_code + phoneNumber;
    $('#phone_number').val(phone);
    return true;
}

