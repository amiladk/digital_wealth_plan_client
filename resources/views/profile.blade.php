                    
<!-- App favicon -->
<link rel="shortcut icon" href="/assets/theam-default/assets/images/favicon.ico">


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
      
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
                            <div class="col-xl-4 col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                        <h5 class="card-title mb-3">Profile</h5>
                                            <div class="col-sm order-2 order-sm-1">
                                                <div class="d-flex align-items-start mt-3 mt-sm-0">
                                                <div class="col-sm order-2 order-sm-1">
                                                <div class="d-flex align-items-start mt-3 mt-sm-0">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar-xl me-3">
                                                            <img src="assets/theam-default/images/logo.png" alt="" class="img-fluid rounded-circle d-block">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="font-size-16 mb-1">{{$user->first_name}}</h5>
                                                            <p class="text-muted font-size-13">{{$user->Country->name}}</p>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Edit Photo</button>

                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                            </div>
                                            <div class="col-sm-auto order-1 order-sm-2">
                                                <div class="d-flex align-items-start justify-content-end gap-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
            <div class="col-xl-8 col-lg-8">
                <div class="card">
                <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Basic Information</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Login</span>    
                                </a>
                            </li>
                        
                        </ul> 
                            
                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home" role="tabpanel">
                        <p class="mb-0"><fieldset disabled>
                            <div class="mb-3">
                                <label for="first-name" class="form-label">First Name</label>
                                    <input type="first-name"  class="form-control" id="first-name" value="{{$user->first_name}}" placeholder="First Name" required>  
                            </div>

                            <div class="mb-3">
                                <label for="last-name" class="form-label">Last Name</label>
                                    <input type="last-name"  class="form-control" id="last-name" value="{{$user->last_name}}" placeholder="Last Name" required>  
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                    <input type="country"  class="form-control" id="country" value="{{$user->Country->name}}" placeholder="Country" required>  
                            </div>
                            </fieldset>
                        </p>
                    </div>


                        <div class="tab-pane" id="profile" role="tabpanel">
                            <form id="login-form" action="/action/update-password" method="POST">
                            @csrf
                            <p class="mb-0">
                                    <div class="mb-3 form-group">
                                        <label for="current_password" class="form-label">Existing Password</label>
                                        <input type="password"  class="form-control" id="current_password" name="current_password" placeholder="Enter Existing Password" required>  
                                    </div>

                                    <div class="mb-3 form-group">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required>   
                                    </div>

                                    <div class="mb-3 form-group">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password" required>      
                                    </div> 
                                    <div class="mb-3 form-group verify" style="display: none;">
                                        <label for="password_confirmation" class="form-label">OTP</label>
                                        <div class="input-group mb-3 ">
                                            <input type="text" class="form-control otp"  placeholder="Enter OTP From Your Email" id="otp" name="otp"  aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    
                                                    <button type="button" class="btn btn-primary waves-effect waves-light verify-button" onclick="verifyOtpByMail(this,'add')">Verify</button>
                                                </div>
                                        </div>
                                    </div>
                                </p>

                                <div class="mb-3 form-group" id="otp_row">
                                            <!-- <label for="password_confirmation" class="form-label">OTP</label> -->
                                            <button type="button" class="btn btn-success waves-effect waves-light send-otp" onclick="sendOtpMail()" >Send OTP</button>
                                </div>

                               









                                <button type="submit" class="btn btn-primary waves-effect waves-light pasword-change" style="display: none;">Submit</button>
                                
                            </form>
                        </div>
                              

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center p-3">

                    <h5 class="m-0 me-2">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Mode</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Width</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Topbar Color</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Direction</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> 
        </div>


        <!-- center modal -->
        
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Center modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
    
                                        <div>
                                            <form action="#" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                                    </div>
    
                                                    <h5>Drop profilre here or click to upload.</h5>
                                                </div>
                                            </form>
                                        </div>
    
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>


