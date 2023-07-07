
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

    <div class="col-md-4 text-center">
        <div class="alert alert-primary" role="alert">
            <h6 class="alert-heading">Current Date: {{ now()->format('Y-m-d') }} <span id="current-date"></span></h6>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="alert alert-info" role="alert">
            <h6 class="alert-heading">Registered Date: {{ $created_date->created_at }}</h6>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="alert alert-success" role="alert">
            <h6 class="alert-heading" >Total Fund : <span id = "total-fund">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
            </span></h6>
        </div>
    </div>

    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Earnings</span>
                        <h4 class="mb-3" id = "total-earnings">
                            <div class="spinner-border text-primary " role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                        </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-success text-success">+$20.9k</span> -->
                    <!-- <span class="ms-1 text-muted font-size-13">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Daily Rewards</span>
                        <h4 class="mb-3" id = "daily_rewards">
                            <div class="spinner-border text-primary " role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                        </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-danger text-danger">-29 Trades</span> -->
                    <!-- <span class="ms-1 text-muted font-size-13">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col-->

    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Referral Rewards</span>
                        <h4 class="mb-3" id ="referral-rewards">
                             <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                        </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-success text-success">+ $2.8k</span> -->
                    <!-- <span class="ms-1 text-muted font-size-1">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">BV Rewards</span>
                        <h4 class="mb-3" id = "bv-ewards">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                         </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-danger text-danger">-29 Trades</span> -->
                    <!-- <span class="ms-1 text-muted font-size-13">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col-->

    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Withdrawals</span>
                        <h4 class="mb-3" id = "withdrawals">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                         </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-danger text-danger">-29 Trades</span> -->
                    <!-- <span class="ms-1 text-muted font-size-13">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col-->

    


    <div class="col-xl-2 col-lg-3 col-md-6 rewards">
        <!-- card -->
        <div class="card card-h-100">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Top-Ups by wallet</span>
                        <h4 class="mb-3" id = "to-up-by-wallet">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> 
                        </h4>
                    </div>
                </div>
                <div class="text-nowrap">
                    <!-- <span class="badge bg-soft-success text-success" >+2.95%</span> -->
                    <!-- <span class="ms-1 text-muted font-size-13">Since last week</span> -->
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->   
     
</div><!-- end row-->


<div class="row">

    <div class="col-lg-3">

        <div class="card border border-info text-center">
            <div class="card-header bg-transparent">
                <h5 class="my-0 text-info"></i>Left BV Rewards</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total BV</span>
                        <h5  class="card-title bv-rewards-heder" id ="left-bv-rewards">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">After Balance</span>
                        <h5  class="card-title  bv-rewards-heder" id ="left-bv-after_balance">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card left-card text-center border-info">
            <div class="card-header bg-transparent">
                <h5 class="my-0 text-info"></i>Right BV Rewards</h5>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total BV</span>
                        <h5 class="card-title bv-rewards-heder" id ="right-bv-rewards">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">After Balance</span>
                        <h5  class="card-title  bv-rewards-heder" id ="right-bv-after_balance">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card right-card text-center border-success">
            <div class="card-header bg-transparent">
                <h5 class="my-0 text-success"></i>Left User Count</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total</span>
                        <h5 class="card-title bv-rewards-heder" id ="left-user-count">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Direct</span>
                        <h5  class="card-title  bv-rewards-heder" id ="left-user-direct-count">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card right-card text-center border-success">
            <div class="card-header bg-transparent">
                <h5 class="my-0 text-success"></i>Right User Count</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Total</span>
                        <h5 class="card-title bv-rewards-heder" id ="right-user-count">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                    <div class="col-6 text-center">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Direct</span>
                        <h5  class="card-title  bv-rewards-heder" id ="right-user-direct-count">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>        
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-6">
                        <!-- card -->
                        <div class="card border-primary">
                            <!-- card body -->
                            <div class="card-body mb-3">
                                    <div class="row align-items-center">
                                    <div class="col-md-12 align-self-center">
                                        <div class="mt-4 mt-sm-0">
                                            <h5 class="my-0 mb-2 text-success">Available Balance</h5>
                                            <h3 class="mb-3" id = "available-balance">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div> 
                                            </h3>
                                            {{--<div class="mt-2">
                                                <a href="/top-up" class="btn btn-primary btn-sm btn-success">Top-Up <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                <a href="/withdrawals" class="btn btn-primary btn-sm btn-light">Withdraw <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <!-- card -->
                        <div class="card border-primary">
                            <div class="card-body mb-3">
                                <h5 class="my-0 mb-2 text-primary"></i>Holding Balance</h5>
                                <h3 class="mb-3" id = "holding-balance">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div> 
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card right-card text-center">
                            <div class="card-header bg-transparent">
                                <h5 class="my-0 text-primary"></i>P2P Transfers</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">P2P Sent</span>
                                        <h5 class="card-title bv-rewards-heder" id ="p2p-sent">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>        
                                        </h5>
                                    </div>
                                    <div class="col-6 text-center">
                                        <span class="text-muted mb-3 lh-1 d-block text-truncate">P2P Received</span>
                                        <h5  class="card-title  bv-rewards-heder" id ="p2p-received">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>        
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex purchase_plans_tab">
                        <h4 class="card-title mb-0 flex-grow-1">Purchased Plans</h4>
                        <div class="">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#transactions-all-tab" role="tab">
                                        All 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">
                                        Active 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-sell-tab" role="tab">
                                        Completed
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#transactions-pending-tab" role="tab">
                                        Pending Approvals
                                    </a>
                                </li>
                            </ul>
                            <!-- end nav tabs -->
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body px-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                <!--loader start from here-->
                                <div id="loader">
                                <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                </div>
                                <!--loader end from here-->
                                <table class="table align-middle table-nowrap table-borderless">
                                        <tbody id = "purchased-plans-tbody" >
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-buy-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">

                                        <tbody id = "purchased-plans-tbody-active">
                                            
                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-sell-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">
                                        <tbody id = "purchased-plans-tbody-completed">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane" id="transactions-pending-tab" role="tabpanel">
                                <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                                    <table class="table align-middle table-nowrap table-borderless">
                                        <tbody id = "purchased-plans-tbody-pending">
                                            
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
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Left Referral Link</h3>
                <p class="card-text">Use below buttons to copy or share your link</p>
                <div class="row">   
                        <div class="col-md-6" onclick="copyReferralLink({{Auth::user()->id}}, 0)" id = "copy-link-1">
                        <a  class="btn btn-primary waves-effect btn btn-primary w-md w-100" > <i class=" fas fa-copy"></i>  Copy</a> 

                        </div>
                        <div class="col-md-6">
                        <a href="" class="btn btn-primary waves-effect btn btn-success w-md w-100" onclick="openModal(event,0)" data-bs-target=".bs-example-modal-center"></i>  Whatsapp</a>

                        </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Right Referral Link </h3>
                <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                <p class="card-text">Use below buttons to copy or share your link</p>
                <div class="row">   
                    <div class="col-md-6 swalDefaultSuccess" onclick="copyReferralLink({{Auth::user()->id}}, 1)" id = "copy-link-2">
                        <!--<a href="" class="btn btn-primary waves-effect waves-light  w-md w-100"> <i class="fab fa-whatsapp fa-1x">Copy</a>  -->
                            <a class="btn btn-primary waves-effect btn btn-primary w-md w-100"> <i class=" fas fa-copy"></i>  Copy</a>
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn btn-primary waves-effect btn btn-success w-md w-100" onclick="openModal(event,1)" data-bs-target=".bs-example-modal-center"></i>  Whatsapp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end col -->
    
    <!-- end col -->

</div><!-- end row -->


<div class="card-body">
    <div>
        <!-- center modal -->  
       
        <div class="modal fade bs-example-modal-center" id ="share-link-model" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title share-link-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="send-link" >
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="phone_number">Contact No <span class="required-color">*</span></label>
                                <input type="hidden" name="phone_number" id="phone_number" required value="">
                                <input type="tel" class="form-control" id="phone" name="phone"placeholder="Enter your Phone No" value="">
                            </div>
                            <p id="phone_number_error"></p>
                        </div>
                           </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id = "send-link-btn" onclick="senReferralLink({{Auth::user()->id}} )" >Send</button>
                            </div>
                        </div>
                        </form>
                    </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
     </div>
    </div><!-- end card body -->
</div><!-- end card -->
<input type="hidden" id="hidden-data" value=""/>



