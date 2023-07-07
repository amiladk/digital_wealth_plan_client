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

<form method='post' action="{{url('/action/p2p-transfer')}}" id="p2ptransfer-form">
@csrf
<div class="row">
    <div class="col-md-12 ms-lg-auto mb-3">
        <div class="mt-4 mt-lg-0">
            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Send to</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="client_select" name="client_select" placeholder="Type the Client Id With Prefix. Ex: MTR099999" required>
                    <input type="hidden" class="form-control" id="membership_no" name="membership_no" value="">
                    <div id="client-list" class="mb-3 mt-3">
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="horizontal-firstname-input" id="receiver_name"class="col-sm- col-form-label"> </label>
                </div>
            </div>
            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Available Balance</label>
                <div class="col-sm-8">
                    <input type="hidden" id="available_balance" name="available_balance" value="<?php echo $user_details->wallet;?>">
                    <input type="text" class="form-control wallet_available_blance"  placeholder="0" value="<?php echo number_format( $user_details->wallet , 2, '.', ',');?>" readonly style="border: none;">
                </div>
            </div>
            <div class="">
                <div class="row mb-4">
                    <label for="transfer_amount" class="col-sm-4 col-form-label">Transfer Amount</label>
                    <div class="col-sm-8 form-group">
                        <input type="text" class="form-control" id="transfer_amount" name="transfer_amount" placeholder="Enter your Amount" required>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <label for="transaction_fee" class="col-sm-4 col-form-label">Transaction fee</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  placeholder="$2" value="{{ $p2p_transaction_fee }}" readonly id="transaction_fee" name="transaction_fee">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <hr style="height:2px;border-width:3px">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="recieving_amount" class="col-sm-4 col-form-label">Receiving Amount</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"  placeholder="" readonly id="recieving_amount" name="recieving_amount">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="recieving_amount" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agree_laws_check" name ="agree"  required>
                            <label class="form-check-label" for="agree_laws_check">This transaction is made at my sole discretion & the admins won't be responsible for this.</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="recieving_amount" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-8">
                        <!-- <div class="alert alert-primary alert-outline fade show mb-0 top-up-alert" role="alert">
                                    Once you made a P2P transaction it cannot be revised & the admins won't be liable to act as an intermediate party between me & the receiver.
                        </div> -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="made_a_p2p" name ="agree_p2p" ; required>
                            <label class="form-check-label" for="made_a_p2p">Once I made a P2P transaction it cannot be revised & the admins won't be liable to act as an intermediate party between me & the receiver. </label>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="row mb-4" id="otp_row" style="display: none;"  >
                    <label for="recieving_amount" class="col-sm-4 col-form-label">OTP</label>
                    <div class="col-sm-6 send-otp">
                        <label for="horizontal-firstname-input" id="receiver_name"class="col-sm- col-form-label"> To complete this transaction please verify your email by an One Time Password (OTP)</label>
                    </div>
                    <div class="col-sm-2 send-otp">
                        <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                    </div>
                    <div class="col-sm-8 verify custom-otp-wrap" style="display: none;">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp" name="otp"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light verify-button" onclick="verifyOtpByMail(this,'add')">Verify</button>
                            </div>
                        </div>
                    </div>  
                </div> -->

    
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4"></label>
                <div class="col-sm-8">
                    <button type="submit" id="p2p-submit" class="btn btn-primary waves-effect waves-light p2pSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<div class="row mt-3">

    <div class="col-md-12 col-lg-6 col-xl-6">
        <div class="card card-h-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">P2P Sent</h4>
            </div><!-- end card header -->
            <div class="card-body px-0">
                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                    <!--loader start from here-->
                    {{-- <div id="pradeep-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div> --}}
                    <!--loader end from here-->
                    <table class="table align-middle table-nowrap table-borderless">
                        <thead>
                            <tr>
                                <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Date</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Sent to</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Sent to Member ID</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transfer Amount</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Sent Amount</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($p2p_sent as $key => $data)
                                <tr>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->getTo->full_name }}</td>
                                    <td>{{ $data->getTo->membership_no }}</td>
                                    <td class="rigth-aligment"><?php echo number_format( $data->transfer_amount, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $data->transaction_fee, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $data->received_amount, 2, '.', ',');?></td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

    <div class="col-md-12 col-lg-6 col-xl-6">
        <div class="card card-h-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">P2P Received</h4>
            </div><!-- end card header -->
            <div class="card-body px-0">
                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                    <!--loader start from here-->
                    {{-- <div id="pradeep-loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div> --}}
                    <!--loader end from here-->
                    <table class="table align-middle table-nowrap table-borderless">
                        <thead>
                            <tr>
                                <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Date</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Received from</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Received from Member ID</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transfer Amount</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Received Amount</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($p2p_received as $key => $data)
                                <tr>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->getFrom->full_name }}</td>
                                    <td>{{ $data->getFrom->membership_no }}</td>
                                    <td class="rigth-aligment"><?php echo number_format( $data->transfer_amount, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"> <?php echo number_format( $data->transaction_fee, 2, '.', ',');?> </td>
                                    <td class="rigth-aligment"><?php echo number_format( $data->received_amount, 2, '.', ',');?></td>

                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

</div>




<!--  Model start-->                                                                       
<div class="modal fade" id="otp-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">OTP Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           
               
                <div class="modal-body">
                <div class="col-sm-12 verify custom-otp-wrap">
                        <div class="input-group ">
                            <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp" name="otp"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <!-- <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button> -->
                                <button type="button" class="btn btn-primary waves-effect waves-light verify-button" onclick="verifyOtpByMailP2p(this)">Verify</button>
                            </div>
                        </div>
                    </div>  
                    
                </div>
                
           
        </div>
        
    </div>
</div>



