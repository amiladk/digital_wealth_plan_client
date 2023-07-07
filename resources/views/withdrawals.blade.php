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

<form method='post' action="{{url('/action/withdrawal')}}" id="withdrawal-form">
@csrf
    <div class="row">
        <div class="col-md-7 ms-lg-auto mb-3">
            <div class="mt-4 mt-lg-0">
                    <div class="row mb-4">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">Available Balance</label>
                        <div class="col-sm-8">
                            <input type="hidden" id="available_balance" name="available_balance" value="<?php echo $user_details->wallet;?>">
                            <input type="text" class="form-control wallet_available_blance"  placeholder="0" value="<?php echo number_format( $user_details->wallet , 2, '.', ',');?>" readonly style="border: none;">
                        {{-- <label for="horizontal-firstname-input" class="col-sm-4 col-form-label" id="available_balance">{{ $user_details->wallet }}</label> --}}
                        </div>
                    </div>
                    
                    <div class="">
                        <div class="row mb-4">
                            <label for="withdraw_amount" class="col-sm-4 col-form-label">Withdraw Amount</label>
                            <div class="col-sm-8 form-group">
                                <input type="text" class="form-control" id="withdraw_amount" name="withdraw_amount" placeholder="Enter your Amount" required>
                            </div>
                            </div>
                        </div>
                    
                    <div class="row mb-4">
                        <label for="transaction_fee" class="col-sm-4 col-form-label">Transaction fee</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  placeholder="$2" value="{{ isset($client_wallets[0]) ? $client_wallets[0]->cyptoNetwork->withdrawal_fee : 0 }}" readonly id="transaction_fee" name="transaction_fee">
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
                    
            </div>

            <!-- <div class="row mb-4" id="otp_row"  >
                    <label for="recieving_amount" class="col-sm-4 col-form-label">OTP</label>
                  
                    <div class="col-sm-8 send-otp">
                        <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                    </div>
                    <div class="col-sm-8 verify custom-otp-wrap" style="display: none;">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp_submit" name="otp_submit"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light verify-button" onclick="verifyOtpByMail(this,'submit')">Verify</button>
                            </div>
                        </div>
                    </div>  
             </div>
             -->
            
            <div class="row">
                <label class="col-sm-4"></label>
                <div class="col-sm-8">
                <button type="submit" class="btn btn-primary waves-effect waves-light withdrewal-Submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
        <div class="col-md-1"></div>
        <div class="col-md-4 mb-3">
            <h5 class="font-size-20 mb-4"> Add/Edit Wallet</h5>
            @foreach($client_wallets as $key=>$client_wallet)
                <div class="col-lg-12">
                    <div class="card border border-secondary wallet">
                    <a href="#" class="btn btn-outline-light waves-effect wallet client_wallet">
                        <div class="card-body">
                            <input type="hidden" class="form-control wallet-input" required name="currency_type" value="{{$client_wallet->currencyType->id}}">
                            <input type="hidden" class="form-control wallet-input" required name="cypto_network" value="{{$client_wallet->cyptoNetwork->id}}">
                            <input type="hidden" class="form-control wallet-input" required name="wallet_address" value="{{$client_wallet->wallet_address}}">
                            <h5 class="card-title">
                                {{$client_wallet->currencyType->title}}<br>
                                {{$client_wallet->cyptoNetwork->title}} <br>
                                {{$client_wallet->wallet_address}}
                            </ul></h5>
                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="showViewModal({{ $key }})" data-bs-toggle="modal" data-bs-target="#editClientWallet">Edit</button>
                            <button type="button" class=" btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="button" onclick="deleteWallet( {{ $client_wallet->id }});" autocomplete="off">Delete</button>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- end col -->
            @endforeach
            @if($client_wallets->isEmpty())
            <div class="col-lg-12">
                <div class="card border border-secondary wallet">
                    <a href="#" class="btn btn-outline-light waves-effect waves-light wallet" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                        <div class="card-body">
                            <h4 class="card-title add-buuton-center" > <i class=" fas fa-plus-square" style="font-size:30px"></i> <br>
                                Add new
                                <br>
                            </h4>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            <!-- end col -->
        </div>
    </div>



<div class="row mt-3">
    <div class="col-md-12 col-lg-10 col-xl-7">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Withdrawal History</h4>
                <div class="">
                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#withdrawal-all-tab" role="tab">
                                All 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#withdrawal-pending-tab" role="tab">
                                Pending 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#withdrawal-approved-tab" role="tab">
                                Approved
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#withdrawal-not-approved-tab" role="tab">
                                Not Approved
                            </a>
                        </li>
                    </ul>
                    <!-- end nav tabs -->
                </div>
            </div><!-- end card header -->

            <div class="card-body px-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="withdrawal-all-tab" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                        <!--loader start from here-->
                        <div id="loader">
                        <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                        </div>
                        <!--loader end from here-->
                        <table class="table align-middle table-nowrap table-borderless">
                                <thead>
                                    <th></th>
                                    <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Created Date</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Withdraw Amount</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Recieved Amount</h5></th>
                                </thead>
                                <tbody id = "withdrawal-all-tbody" >

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane" id="withdrawal-pending-tab" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <thead>
                                    <th></th>
                                    <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Created Date</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Withdraw Amount</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Recieved Amount</h5></th>
                                </thead>
                                <tbody id = "withdrawal-pending-tbody">   

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane" id="withdrawal-approved-tab" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <thead>
                                    <th></th>
                                    <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Created Date</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Withdraw Amount</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Recieved Amount</h5></th>
                                </thead>
                                <tbody id = "withdrawal-approved-tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane" id="withdrawal-not-approved-tab" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <thead>
                                    <th></th>
                                    <th class="text-left"><h5 class="font-size-14 mb-0 text-muted">Created Date</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Withdraw Amount</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Transaction Fee</h5></th>
                                    <th class="text-center"><h5 class="font-size-14 mb-0 text-muted">Recieved Amount</h5></th>
                                </thead>
                                <tbody id = "withdrawal-not-approved-tbody">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end tab pane -->
                </div>
                <!-- end tab content -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
</div>
</div>


<!-- Add Client Wallet Model start-->                                                                       
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <form method='post' action="{{url('/action/client-wallet')}}" id="add-wallet-form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Currency Type</label>
                        <select class="form-select" id="currency_type" name="currency_type" required>
                        <option value="">Select Currency Type</option>
                            @foreach($currency_type as $key=>$data)
                                <option value="{{$data->id}}">{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Network</label>
                        <select class="form-select" id="cypto_network" name="cypto_network" required>
                        <option value="">Select Crypto Network</option>
                            @foreach($crypto_network as $key=>$data)
                                <option value="{{$data->id}}">{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" placeholder ="Address" id="wallet_address" name="wallet_address" required>
                    </div>
                    <div class="form-group">
                        <!-- <label class="form-label">OTP</label> -->
                        <!-- <input class="form-control" type="text" placeholder ="Enter OTP" id="otp" name="otp" required> -->
                    </div>
                    
                    <div class="form-group custom-otp-wrap">
                        <!-- <div class="input-group" >
                            <div class="col-sm-9 send-otp">
                                <label for="horizontal-firstname-input" id="receiver_name"class="col-sm- col-form-label"> To complete this transaction please verify your email by an One Time Password (OTP)</label>
                            </div>
                            <div class="col-sm-3 send-otp text-end">
                                <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                            </div>
                        </div> -->
                        <div class="form-group verify custom-otp-wrap-otp" style="display: none;">
                            <label class="form-label">OTP</label>
                            <div class="input-group ">
                                <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp-add" name="otp"  aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                <button type="button" class="btn btn-primary waves-effect waves-light " onclick="verifyOtpByMailwithdrawal(this,'add')">Verify</button>
                                </div>
                            </div>
                        </div> 
                    </div>  
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-success send-otp"  onclick="sendOtpMail()">Send OTP</button> -->
                    <button type="submit"  class="btn btn-primary wallet-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model End-->  


<!-- Edit Client Wallet Model start-->                                                                       
<div class="modal fade" id="editClientWallet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Client Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method='post' action="{{url('/action/client-wallet-edit')}}" id="edit-wallet-form" >
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id-1" value="6">
                    <div class="form-group">
                        <label class="form-label">Currency Type</label>
                        <select class="form-select" id="currency_type-1" name="currency_type" required>
                            <option value="">Select Currency Type</option>
                            @foreach($currency_type as $key=>$data)
                                <option value="{{$data->id}}">{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Network</label>
                        <select class="form-select" id="cypto_network-1" name="cypto_network" required>
                            <option value="">Select Crypto Network</option>
                            @foreach($crypto_network as $key=>$data)
                                <option value="{{$data->id}}">{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" placeholder ="Address" id="wallet_address-1" name="wallet_address" value="" required>
                    </div>
                    <!-- <div class="form-group">
                        <label class="form-label">OTP</label> -->
                        <!-- <input class="form-control" type="text" placeholder ="Enter OTP" id="otp" name="otp" required> -->
                    <!-- </div> -->
                    <div class="form-group custom-otp-wrap">
                        <!-- <div class="input-group" >
                            <div class="col-sm-9 send-otp">
                                <label for="horizontal-firstname-input" id="receiver_name"class="col-sm- col-form-label"> To complete this transaction please verify your email by an One Time Password (OTP)</label>
                            </div>
                            <div class="col-sm-3 send-otp text-end">
                                <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                            </div>
                        </div> -->
                        <div class="form-group verify custom-otp-wrap-otp" style="display: none;">
                            <label class="form-label">OTP</label>
                            <div class="input-group ">
                                <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp-edit" name="otp"  aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                
                                <button type="button" class="btn btn-primary waves-effect waves-light " onclick="verifyOtpByMailwithdrawal(this,'edit')">Verify</button>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary wallet-submit ">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Model End-->

<!--  Model start-->                                                                       
<div class="modal fade" id="otp-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">OTP Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           
               
                <div class="modal-body">
                    <div class="col-sm-12  custom-otp-wrap-otp">
                        <div class="input-group ">
                            <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="withdrawal-otp" name="otp"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <!-- <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button> -->
                                <button type="button" class="btn btn-primary waves-effect waves-light verify-button" onclick="verifyOtpByMailwithdrawal(this,'submit')">Verify</button>
                            </div>
                        </div>
                    </div>  
                    
                </div>
                
           
        </div>
        
    </div>
</div>

                               

<script>
    var client_wallets   = <?php echo json_encode($client_wallets); ?>;
</script>