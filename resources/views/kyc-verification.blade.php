<style>
   .img-container.cropper-custom > img {
  display: block;

  /* This rule is very important, please don't ignore this */
  max-width: 100%; 
  max-height: 300px;  
}

.btn.btn-primary.is-invalid{
    border-color: #f44336;
}

.btn.btn-primary.is-valid{
    border-color: #2ab57d;
}

/*
|--------------------------------------------------------------------------
| Image ratio.
|--------------------------------------------------------------------------
|
*/
.img-parent {
    width: 100%;
  }
  
  .imag-wrapper {
    display: block;
    width: 100%;
    height: auto;
    position: relative;
    overflow: hidden;
    padding: 80.37% 0 0 0;
    /* 34.37% = 100 / (w / h) = 100 / (640 / 220) */
  }
  
  .imag-wrapper img {
    display: block;
    max-width: 100%;
    max-height: 100%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
  }

</style>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18 text-uppercase">{{$title}} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{$title}} </li>
                </ol>
            </div>

        </div>
    </div>
    @if(Auth::user()->kyc_status == 2)
    <div class="col-12">
        <div class="alert alert-warning alert-dismissible alert-outline fade show" role="alert">
            <strong>Warning</strong> - Your KYC was not approved. Please resubmit KYC form or contact administrator for additional information. 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <div id="progrss-wizard" class="twitter-bs-wizard">
                    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a href="#personal-details" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Personal Details">
                                    <i class="bx bx-list-ul"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#verification-document" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Verification Document">
                                    <i class="bx bx-book-bookmark"></i>
                                </div>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="#source" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Source Details">
                                    <i class="bx bxs-bank"></i>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#terms-and-condition" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Terms and Conditions">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <!-- wizard-nav -->

                    <div id="bar" class="progress mt-4">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                    </div>
                    <div class="tab-content twitter-bs-wizard-tab-content">
                        <div class="tab-pane" id="personal-details">
                            <div class="text-center mb-4">
                                <h5>Personal Details</h5>
                            </div>
                            <form id="kyc-personal-info-form" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="progresspill-lastname-input" class="required-color">*</label>
                                        <div class="mb-3 radio-custom">
                                            @foreach($client_titles as $key=>$client_title)
                                                <div class="form-check mb-1">
                                                    <input <?php if($client_title->id == $user->client_title){ echo 'checked';} ?> class="form-check-input" type="radio" name="client_title" id="client-title-{{$key}}" value="{{ $client_title->id }}">
                                                    <label class="form-check-label" for="client-title-{{$key}}">
                                                        {{ $client_title->title }}
                                                    </label>
                                                </div>
                                                
                                            @endforeach
                                            <!-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="formRadios" id="ms">
                                                <label class="form-check-label" for="ms">
                                                    Ms
                                                </label>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="first_name">First Name <span class="required-color">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your Full Name" value="{{$user->first_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="last_name">Last Name <span class="required-color">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your Full Name" value="{{$user->last_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="full_name">Full Name <span class="required-color">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your Full Name" value="{{$user->full_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="dob">Date of Birth <span class="required-color">*</span></label>
                                            <input class="form-control" type="date" name="dob" id="dob" value="{{$user->dob}}">
                                            <!-- <input type="text" class="form-control" id="progresspill-phoneno-input" placeholder="Enter your date of birth"> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3 form-group">
                                            <label for="country" class="form-label"> Country </label>
                                            <input class="form-control"  id="country" data-dropdown="true" name="country" placeholder="Please select..." value="{{$user->Country->name}}"/>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-6">
                                        <div class="form-group">
                                            <label for="phone_number">Contact No <span class="required-color">*</span></label>
                                            <input type="hidden" name="phone_number" id="phone_number" required value="{{$user->phone_number}}"><br>
                                            <input type="tel" class="form-control" id="phone" name="phone"  placeholder="Enter your Phone No" value="{{$user->phone_number}}">
                                        </div>
                                        <p id="phone_number_error"></p>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="address">Postal Address (As per the Identity Verification Document) <span class="required-color">*</span></label>
                                            <textarea id="address" class="form-control" rows="2" name="address"placeholder="Enter your address">{{$user->address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="next"><a id="personal-info-nxt-btn" href="javascript: void(0);" class="btn btn-primary">Next <i
                                            class="bx bx-chevron-right ms-1"></i></a></li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="verification-document">
                          <div>
                            <div class="text-center mb-4">
                                <h5>Verification Document</h5>
                            </div>
                            <form id="kyc-document-image-and-type-form" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="nic_no">Identity Document Number<span class="required-color">*</span></label>
                                            <input type="text" class="form-control" id="nic_no" name="nic_no" placeholder="Enter your NIC Number" value="{{$user->nic_no}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-3 mb-5">
                                        <div class="mb-3">
                                            <label class="form-label">Document Type</label>
                                            <select class="form-select" id="identity_doc_type" name="identity_doc_type">
                                                <option value="">Please Select</option>
                                                @foreach($identity_doc_types as $key=>$data)
                                                    <option <?php if($user->identity_doc_type == $data->id){ echo 'selected'; } ?> value="{{$data->id}}">{{$data->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>         
 
                                    <div class="row col-lg-6" id="identity_doc_type_chooser_area">

                                        @if($user->identity_doc_type == 1)
                                            <div class="col-lg-6 mb-3">
                                            <label class="form-label" for="default-input">Identity Front Image <span class="required-color">*</span></label>
                                                <div>
                                                <button id="upload-img-btn-1" onclick="showCropModal(1)" class="btn btn-primary @if($user->id_front != null) is-valid @endif" type="button">@if($user->id_front != null) Uploaded @else Upload @endif  Identity Front Image <span class="required-color">*</span> </button>
                                                <span id="upload-img-msg-1"> @if($user->id_front != null) <i id="upload-img-msg-fa-1" class="fa fa-check text-success" aria-hidden="true"></i> @endif </span>
                                                </div>
                                                
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                            <label class="form-label" for="default-input">Identity Back Image <span class="required-color">*</span></label>
                                                <div>
                                                <button id="upload-img-btn-2" onclick="showCropModal(2)" class="btn btn-primary @if($user->id_back != null) is-valid @endif" type="button">@if($user->id_back != null) Uploaded @else Upload  @endif Identity Back Image <span class="required-color">*</span> </button>
                                                <span id="upload-img-msg-2"> @if($user->id_back != null) <i id="upload-img-msg-fa-2" class="fa fa-check text-success" aria-hidden="true"></i> @endif </span>
                                                </div>
                                            </div>
                                        @endif

                                        @if($user->identity_doc_type == 2)
                                            <div class="col-lg-6 mb-3">
                                            <label class="form-label" for="default-input">License Front Image <span class="required-color">*</span></label>
                                                <div>
                                                <button id="upload-img-btn-3" onclick="showCropModal(3)" class="btn btn-primary @if($user->id_front != null) is-valid @endif" type="button">@if($user->id_front != null) Uploaded @else Upload  @endif License Front Image <span class="required-color">*</span> </button>
                                                <span id="upload-img-msg-3"> @if($user->id_front != null) <i id="upload-img-msg-fa-3" class="fa fa-check text-success" aria-hidden="true"></i> @endif </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                            <label class="form-label" for="default-input">License Front Image <span class="required-color">*</span></label>
                                                <div>
                                                <button id="upload-img-btn-4" onclick="showCropModal(4)" class="btn btn-primary @if($user->id_back != null) is-valid @endif" type="button">@if($user->id_back != null) Uploaded @else Upload  @endif License Back Image <span class="required-color">*</span> </button>
                                                <span id="upload-img-msg-4"> @if($user->id_back != null) <i id="upload-img-msg-fa-4" class="fa fa-check text-success" aria-hidden="true"></i> @endif </span>
                                                </div>
                                            </div>
                                        @endif

                                        @if($user->identity_doc_type == 3)
                                            <div class="col-lg-6 mb-3">
                                            <label class="form-label" for="default-input">Passport Image <span class="required-color">*</span></label>
                                                <div>
                                                <button id="upload-img-btn-5" onclick="showCropModal(5)" class="btn btn-primary @if($user->id_front != null) is-valid @endif" type="button">@if($user->id_front != null) Uploaded @else Upload  @endif Passport Image <span class="required-color">*</span> </button>
                                                <span id="upload-img-msg-5"> @if($user->id_front != null) <i id="upload-img-msg-fa-5" class="fa fa-check text-success" aria-hidden="true"></i> @endif </span>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    
                                    <div class="col-lg-3 mb-3">
                                        <label class="form-label" for="default-input">Selfie Photo <span class="required-color">*</span></label>
                                        <div>    
                                            <button id="upload-img-btn-6" onclick="showCropModal(6)" class="btn btn-primary @if($user->selfie != null) is-valid @endif" type="button">@if($user->selfie != null) Uploaded @else Upload @endif Selfie Image <span class="required-color">*</span> </button>
                                            <span id="upload-img-msg-6">@if($user->selfie != null) <i id="upload-img-msg-fa-6" class="fa fa-check text-success" aria-hidden="true"></i>  @endif</span>
                                            <div id="result-row-6" class="mt-2" style="padding-right: 30px;">
                                                </div>
                                                
                                        </div>  
                                    </div>

                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-3 offset-md-4">
                                        <div class="img-container cropper-custom">
                                            <img id="canvace_image" src="">
                                            <span id="crop-btn-area">
                                                <button class="btn btn-warning mt-2"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                <button class="btn btn-success mt-2">crop</button>
                                            </span>
                                        </div>
                                    </div>
                                </div> -->
                            </form>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                            class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Next <i
                                            class="bx bx-chevron-right ms-1"></i></a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="tab-pane" id="source">
                            <div>
                                <div class="text-center mb-4">
                                    <h5>Source  of Funds</h5>
                                </div>
                                <form id="source-of-funds-form" action="/kyc-verificatio-action" method="POST">
                                @csrf
                                <!-- <form id ="source-of-funds-form"> -->
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="mb-3">
                                              <label for="progresspill-namecard-input" class="form-label">Source of Funds <span class="required-color">*</span>
                                            </label>
                                            <div class="mb-3 radio-custom">
                                        @foreach($client_fund_sources as $key=>$client_fund_source)
                                                <div class="form-check mb-1">
                                                    <input <?php if($client_fund_source->id == $user->client_fund_source){ echo 'checked';} ?> class="form-check-input" type="radio" name="client_fund_source" id="fund_source-{{$key}}" value="{{$client_fund_source->id}}">
                                                    <label class="form-check-label" for="fund_source-{{$key}}">
                                                        {{ $client_fund_source->title }}
                                                    </label>
                                                </div>
                                        @endforeach
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                     
                                  <div class="row">
                                        <div class="col-lg-12">
                                          <div class="mb-3">
                                            <div class="form-group">                          
                                                <div class="form-check">
                                                    <input <?php if($user->client_fund_source != null || $user->client_fund_source != ''){ echo 'checked';} ?> type="checkbox" class="form-check-input" id="agree_laws_check" name ="agree_laws_check[]" >
                                                    <label class="form-check-label" for="agree_laws_check">I assure that these funds aren't from any illegal activities according to the body of laws of my country.</label>
                                                </div>
                                                
                                            </div>
                                          </div>
                                        </div>
                                  </div>
                                
                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                    <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                                class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                    <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Next <i
                                                class="bx bx-chevron-right ms-1"></i></a></li>
                                </ul>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="terms-and-condition">
                            <div class="text-center mb-4">
                                <h5>Terms and Condition</h5>
                            </div>
                            <form id="terms-and-condition-form" action="/kyc-verificatio-action" method="POST">
                            @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            Trading of International Stock Markets, Forex, Commodities & Crypto Currencies carries a high-level risk and at the same time, it is 
                                            gaining high profits and may not be suitable for all kinds of investors. Before deciding to invest you should carefully consider your 
                                            investment objectives, level of experience and risk appetite.
                                            <br><br>
                                            The possibility exists that you could have a loss of some or all of your initial investment and therefore you shouldn't invest funds 
                                            that you cannot afford to lose. You should be aware of the all risks associated with high-level risk investments, and seek advice from an 
                                            independent financial advisor if you have any doubts.
                                            <br><br>
                                            Any opinions, news, chats, research, analysis, prices or other information on this website is provided as general market information 
                                            for educational purposes only and do not constitute investment advice. Www.mytrader.biz should not be relied upon as a substitute for 
                                            extensive independent market research. Before making or getting your actual investment decisions, opinions, market data, recommendations 
                                            or any other content is should be researched on your own.
                                            <br><br>
                                            According to the global market fluctuations due to recessions, inflations, market manipulations, wars, natural disasters & more such 
                                            things, your gains & losses also will be changed as same. Maybe totally you could lose your entire funds. Moreover, you should always 
                                            understand that past performance is not necessarily indicative of future results.
                                            <br><br>
                                            Www.mytrader.biz assure that it will provide security for personal information that we provide to www.mytrader.biz when funding. 
                                            The personal information that mytrader.biz has given by you will not be linked with any other party. Also, your data will be protected 
                                            by the rules if you follow the project engagement procedure accurately.
                                            <br><br>
                                            I/We/The Company/Our group assure that funding in this www.mytrader.biz project is my/our independent discretion & any of the other 
                                            parties including mytrader.biz will not be responsible.
                                            <br><br>
                                            Moreover, I/We/The Company/Our group confirm that have read all the facts and understand the disclaimer here and that will abide by 
                                            all those rules and regulations as stated by mytrader.biz.
                                        </p>
                                        <div class="mb-3">
                                            <div class="form-group"> 
                                                                         
                                                <div class="form-check">
                                                    <input <?php if($user->kyc_status != null || $user->kyc_status != ''){ echo 'checked';} ?> type="checkbox" class="form-check-input" id="terms_and_condition" name="terms_and_condition[]">
                                                    <label class="form-check-label" for="terms_and_condition">I assure that these funds aren't from any illegal activities according to the body of laws of my country.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                            class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                <li class="next"><a href="javascript: void(0);" class="btn btn-primary">Save
                                        Changes</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<!-- Modal -->
<div class="modal fade" id="image_crop_modal" tabindex="-1" role="dialog" aria-labelledby="image_crop_modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="image_crop_modal_title">Modal title</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">

      <div class="form-group">
         <div>
            <div class="fallback">
                <input name="file" type="file" id="image_chooser">
            </div>  
         </div>
        
        <div class="img-container cropper-custom mt-3">
            <img id="canvace_image" src="">
        </div>
      </div>
        
      </div>
      
      <div class="modal-footer" id="image_crop_modal_footer">
        <button type="button" class="btn btn-secondary" onclick="closeCrop()">Close</button>
        <button type="button" class="btn btn-primary" onclick="cropImage(this)">Upload</button>
      </div>
    </div>
  </div>
</div>


<script>
     var user   = <?php echo json_encode($user); ?>;
</script>







