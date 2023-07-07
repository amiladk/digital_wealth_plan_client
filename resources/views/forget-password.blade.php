<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Frogot PASSWORD | MyTrader</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="MyTrader" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/theam-default/images/logo-round.png">

        <!-- preloader css -->
        <link rel="stylesheet" href="/assets/theam-default/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="/assets/theam-default/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/assets/theam-default/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/assets/theam-default/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert -->
        <link href="/assets/theam-default/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <style>
            @media only screen and (min-width: 768px) {
                .left-row{
                position: relative;
                }
                .center-img-column{
                    top: 50%;
                    position: absolute;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }
            }
        </style>

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="/" class="d-block auth-logo">
                                            <img src="/assets/theam-default/images/logo-round.png" alt=""><span class="logo-txt">MyTrader</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Reset Password</h5>
                                            <p class="text-muted mt-2">Reset Password with MyTrader.</p>
                                        </div>
                                        <div class="alert alert-success text-center my-4" role="alert">
                                            Enter your Email and instructions will be sent to you!
                                        </div>
                                        <form class="mt-4" action="/froget-password-submit" method="POST">
                                        @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                                            </div>
                                            <div class="mb-3 mt-4">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset</button>
                                            </div>
                                        </form>

                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">Remember It ?  <a href="/"
                                                    class="text-primary fw-semibold"> Sign In </a> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <script>document.write(new Date().getFullYear())</script> © MyTrader.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex left-row">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center center-img-column">
                                <div class="col-md-12">
                                    <img class="img-fluid" src="/assets/theam-default/images/logo.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        <!-- JAVASCRIPT -->
        <script src="/assets/theam-default/libs/jquery/jquery.min.js"></script>
        <script src="/assets/theam-default/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/theam-default/libs/metismenu/metisMenu.min.js"></script>
        <script src="/assets/theam-default/libs/simplebar/simplebar.min.js"></script>
        <script src="/assets/theam-default/libs/node-waves/waves.min.js"></script>
        <script src="/assets/theam-default/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="/assets/theam-default/libs/pace-js/pace.min.js"></script>
        <!-- password addon init -->
        <script src="/assets/theam-default/js/pages/pass-addon.init.js"></script>
        <!-- sweet alert -->
        <script src="/assets/theam-default/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="/assets/custom/js/custom-js.js"></script>

        @if(Session::has('error'))
            <script>
                $( document ).ready(function() {
                    showAlert('Ooops!','{{Session::get("error")}}','error');
                });
            </script>
        @endif

        @if(Session::has('warning'))
            <script>
                $( document ).ready(function() {
                    showAlert('Ooops..','{{Session::get("warning")}}','warning');
                });
            </script>
        @endif

        @if(Session::has('success'))
            <script>
                $( document ).ready(function() {
                    showAlert('Success!','{{Session::get("success")}}','success');
                });
            </script>
        @endif

    </body>

</html>