
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
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-12">
        <div class="card border border-primary kyc-details">
            <div class="pricing-badge">
                <span class="badge @if($user_details->kyc_status == 0) bg-warning @elseif($user_details->kyc_status == 1)bg-success @elseif($user_details->kyc_status == 2) bg-danger @endif  "> @if($user_details->kyc_status == 0) Pending @elseif($user_details->kyc_status == 1)Approved @elseif($user_details->kyc_status == 2) Not Approved  @endif</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> First Name </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->first_name }} </label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Last Name </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label"> {{ $user_details->last_name }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Full Name </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ isset($user_details->getClientTitle) ? $user_details->getClientTitle->title : '' }} {{ $user_details->full_name }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Date of Birth </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->dob }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Contact Number </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->phone_number }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Country </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->Country->name }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Postal Address </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->address }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Source of Funds </b></label>
                    <div class="col-sm-9">
                    <label for="horizontal-firstname-input" class="col-form-label">{{ isset($user_details->getClientFundSource) ? $user_details->getClientFundSource->title : '' }}</label>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> NIC Number </b></label>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->nic_no }}</label>
                    </div>
                </div>
                <div class="row mb-4">

                    <h5 class="col-sm-3 col-form-label">Document Type</h5>
                    <div class="col-sm-9">
                        <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->getIdentityDocType->title }}</label>
                    </div>

                    <div class="row mb-2 mt-4">
                            <div class="col-md-3">
                                <div class="card border border-success">
                                    <div class="card-body text-center doc_type">
                                        @if($user_details->selfie)
                                            <!-- <i class="fas fa-check-double mb-2"></i> -->
                                            <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getSelfieImage->image_name); echo "src='$img'";?>>
                                        @endif
                                        <h6 class="mt-2">Selfie Image Uploaded</h6>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        @if($user_details->identity_doc_type == 1 || $user_details->identity_doc_type == 2)
                            <div class="col-md-3">
                                <div class="card border border-success">
                                    <div class="card-body text-center doc_type">
                                        @if($user_details->id_front)
                                            <!-- <i class="fas fa-check-double mb-2"></i>     -->
                                        @endif
                                        @if($user_details->identity_doc_type == 1)
                                            <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getFrontImage->image_name); echo "src='$img'";?>>
                                            <h6 class="mt-2">Identity Front Image Uploaded</h6>
                                        @else
                                            <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getFrontImage->image_name); echo "src='$img'";?>>
                                            <h6 class="mt-2">Drivers License Front Image Uploaded</h6>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-md-3">
                                <div class="card border border-success">
                                    <div class="card-body text-center doc_type">
                                        @if($user_details->id_back)
                                            <!-- <i class="fas fa-check-double mb-2"></i> -->
                                        @endif
                                        @if($user_details->identity_doc_type == 1)
                                        <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getBackImage->image_name); echo "src='$img'";?>>
                                            <h6 class="mt-2">Identity Back Image Uploaded</h6>
                                        @else
                                        <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getBackImage->image_name); echo "src='$img'";?>>
                                            <h6 class="mt-2">Drivers License Front Image Uploaded</h6>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- end col -->
                        @else
                            <div class="col-md-3">
                                <div class="card border border-success">
                                    <div class="card-body text-center doc_type">
                                        @if($user_details->id_front)
                                            <!-- <i class="fas fa-check-double mb-2"></i> -->
                                            <img alt="Avatar" class="img-fluid" <?php $img = route('image.displayImage',$user_details->getFrontImage->image_name); echo "src='$img'";?>>
                                        @endif
                                        <h6 class="mt-2">Passport Image Uploaded</h6>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        @endif

                    </div>


                </div>
            </div>
        </div>
    </div><!-- end col -->
</div>