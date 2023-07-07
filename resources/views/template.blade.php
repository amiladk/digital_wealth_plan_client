<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>{{$title}} | MyTrader</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/theam-default/images/logo-round.png">

        @foreach ($css as $path)
        <link href="{{ $path }}" rel="stylesheet">
        @endforeach

        <script>var token = "{{ csrf_token() }}";</script>

    </head>

    <body data-layout-mode="<?php if(auth()->user()->preffered_theme == 1){ echo 'dark'; }else{ echo 'light';} ?>" data-topbar="<?php if(auth()->user()->preffered_theme == 1){ echo 'dark'; }else{ echo 'light';} ?>" data-sidebar="<?php if(auth()->user()->preffered_theme == 1){ echo 'dark'; }else{ echo 'light';} ?>">
    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="/assets/theam-default/images/logo-sys.png" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="/assets/theam-default/images/logo-sys.png" alt="" height="24"> <span class="logo-txt">MyTrader</span>
                                </span>
                            </a>

                            <a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="/assets/theam-default/images/logo-sys.png" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="/assets/theam-default/images/logo-sys.png" alt="" height="24"> <span class="logo-txt">MyTrader</span>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-sm-inline-block">
                            <button type="button" class="btn header-item" id="mode-setting-btn" onclick="modeChange()">
                                <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                                <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                            </button>
                        </div>

                        <div class="dropdown d-sm-inline-block">
                            <button type="button" class="btn header-item mt-2">
                                <p><b>{{ $user_details->membership_no }}</b></p>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="/assets/theam-default/images/profile-default.png"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ $user_details->first_name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="/profile"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">Menu</li>

                            <li>
                                <a href="/">
                                    <!-- <i data-feather="home"></i> -->
                                    <i class="fas fa-home"></i>
                                    <span data-key="t-dashboard">Dashboard</span>
                                </a>
                            </li>
                            @if(Auth::user()->kyc_status != '' && Auth::user()->kyc_status != 2)
                                <li>
                                    <a href="/kyc-verified-details">
                                        <i class="fas fa-unlock-alt"></i>  
                                        <span data-key="t-dashboard">KYC Status</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="/kyc-verification">
                                        <i class="fas fa-unlock-alt"></i>  
                                        <span data-key="t-dashboard">KYC Verification</span>
                                    </a>
                                </li>
                            @endif

                            @if($exsist_funding_payment)
                                <li>
                                    <a href="/top-up">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                        <span data-key="t-dashboard">Top-Up</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="/top-up">
                                    <i class="fas fa-info-circle text-info"></i>
                                        <span data-key="t-dashboard">Start Funding</span>
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="/withdrawals">
                                    <i class="far fa-credit-card"></i> 
                                    <span data-key="t-dashboard">Withdrawals</span>
                                </a>
                            </li>

                            <li>
                                <a href="/p2p-transfer">
                                    <i class="fas fa-comments-dollar"></i>
                                    <span data-key="t-dashboard">P2P Tansfer</span>
                                </a>
                            </li>

                            <li>
                                <a href="/genealogy">
                                <i class="fas fa-project-diagram"></i>  
                                    <span data-key="t-dashboard">Genealogy</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="/my-funding">
                                    <i class="fas fa-hand-holding-usd"></i>  
                                    <span data-key="t-dashboard">My Docs</span>
                                </a>
                            </li>

                            <li>
                                <a href="/client-summary">
                                    <i class="fas fa-file-invoice"></i> 
                                    <span data-key="t-dashboard">User Summary</span>
                                </a>
                            </li>
{{-- 
                            <li>
                                <a href="mailto:support@mytrader.biz">
                                    <i class="far fa-envelope"></i>
                                    <span data-key="t-dashboard">support@mytrader.biz</span>
                                </a>
                            </li> --}}

                        </ul>

                        <div class="card border-0 text-center mb-0 mt-3 sidebar-social">
                            <div class="card-body">
                                <a id="sidebar_email" href="mailto:support@mytrader.biz">support@mytrader.biz</a><br>
                                <a id="sidebar_email_icon" href="mailto:support@mytrader.biz"><i class="far fa-envelope"></i></a>
                                <a href="https://www.facebook.com/profile.php?id=100089230621579&mibextid=ZbWKwL" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://t.me/+Igby3UrrJANjYWFl" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                                <a href="https://wa.me/message/FVYYKUPIRUY6G1" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://twitter.com/MyTraderbiz?t=gpxUq-wFm5KWVwVKaLrQ-Q&s=09" target="_blank"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            

            
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                        <div class="container-fluid">
                
                            @include($view) 

                        </div>

                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <script>document.write(new Date().getFullYear())</script> © MyTrader.
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        @foreach ($script as $path)
       <script src="{{ $path }}"></script>
         @endforeach
        
        @if(Session::has('success'))
            <script>
                $( document ).ready(function() {
                    showAlert('Success!','{{Session::get("success")}}','success');
                });
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $( document ).ready(function() {
                    showAlert('Ooops!','{{Session::get("error")}}','error');
                });
            </script>
        @endif

        <!-- showSuccessAlert -->

        <!-- JAVASCRIPT -->
        <!--!Auth::user()->email_verified && !Session::has('error') && !Session::has('success')-->
        @if(false)
            <script>
                $( document ).ready(function() {
                    $('#email-verified-modal').modal({backdrop: 'static', keyboard: false}, 'show');
                    $('#email-verified-modal').modal('show');
                });
            </script>
        @endif

    </body>

</html>



<!-- Modal -->
<div class="modal fade" id="email-verified-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="email-verified-modal-label">Required Email Verification</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body" style="text-align: center;">
      Your Email need to be verified. Do You want to send the verification Email.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeEmailVerifiedModal()">Close</button>
        <form id="verified-email-form" action="/action/get-verified-email-submit" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Verify Now</button>
        </form>
      </div>
    </div>
  </div>
</div>

