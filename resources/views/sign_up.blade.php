<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Register | MyTrader</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <link rel="stylesheet" href="/assets/custom/css/mobiscroll.javascript.min.css">
       <script src="/assets/custom/js/mobiscroll.javascript.min.js"></script>
        <!-- App favicon -->
        <link rel="shortcut icon" href="/assets/theam-default/images/logo-round.png">

        <!-- preloader css -->
        <link rel="stylesheet" href="/assets/theam-default/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="/assets/theam-default/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/assets/theam-default/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert -->
        <link href="/assets/theam-default/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/assets/theam-default/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

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
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Register Account</h5>
                                            <p class="text-muted mt-1">Get your free MyTrader account now.</p>
                                        </div>
                                    <form id="sign-up" action="register" method="POST">
                                        @csrf
                                            <div class="mb-1">
                                                <label for="first_name" class="form-label">First Name </label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name " required>
                                                <div class="invalid-feedback">
                                                    Please Enter First Name
                                                </div>
                                            </div>
                                            <div class="mb-1">
                                                <label for="last_name" class="form-label">Last Name </label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name " required>
                                                <div class="invalid-feedback">
                                                    Please Enter Last Name
                                                </div>
                                            </div>


                                            <div class="mb-1">
                                                    <label for="country" class="form-label"> Country </label>
                                                    <input class="form-control"  id="country" data-dropdown="true"   name="country" placeholder="Please select..." />
                                            </div>


                                            <div class="mb-1">
                                                <label for="useremail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Email
                                                </div>
                                            </div>
                                            <div class="mb-1">
                                                <label for="userpassword" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Password
                                                </div>
                                            </div>

                                            <div class="mb-1">
                                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter password" required>
                                                <div class="invalid-feedback">
                                                    Please Enter Password
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <p class="mb-0">By registering you agree to the MyTrader <a href="/terms-condition" class="text-primary">Terms of Use</a></p>
                                            </div>
                                            <div class="mb-1">
                                                <input type="hidden" name="sponsor" value="{{$sponsor}}">
                                                <input type="hidden" name="sponsor_side" value="{{$sponsor_side}}">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Register</button>
                                            </div>
                                    </form>

                                        <div class="mt-2 text-center">
                                            <p class="text-muted mb-0">Already have an account ? <a href="/login"
                                                    class="text-primary fw-semibold"> Login </a> </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> MyTrader</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <script>

            mobiscroll.setOptions({
                locale: mobiscroll.localeEn,   // Specify language like: locale: mobiscroll.localePl or omit setting to use default
                theme: 'ios',                  // Specify theme like: theme: 'ios' or omit setting to use default
                themeVariant: 'light'          // More info about themeVariant: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-themeVariant
            });

            var inst = mobiscroll.select('#country', {
                display: 'anchored',           // Specify display mode like: display: 'bottom' or omit setting to use default
                filter: true,                  // More info about filter: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-filter
                itemHeight: 40,                // More info about itemHeight: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-itemHeight
                renderItem: function (item) {  // More info about renderItem: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-renderItem
                    return '<div class="md-country-picker-item">' +
                        '<img class="md-country-picker-flag" src="https://img.mobiscroll.com/demos/flags/' + item.data.value + '.png" />' +
                        item.display + '</div>';
                }
            });

            mobiscroll.util.http.getJson('https://trial.mobiscroll.com/content/countries.json', function (resp) {
                var countries = [];
                for (var i = 0; i < resp.length; ++i) {
                    var country = resp[i];
                    countries.push({ text: country.text, value: country.value });
                }
                countries.push({ text: 'Canada', value: 'CA' });//Adding Countries Not In the List
                inst.setOptions({ data: countries });
            });
        </script>

    </body>

</html>
