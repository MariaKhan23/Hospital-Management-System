<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>User Registration | Hospital Management System</title>
    <link rel="apple-touch-icon" href="../app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/vertical-dark-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/vertical-dark-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/login.css">
    <link rel="stylesheet" href="../app-assets/vendors/sweetalert/sweetalert.css" />
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/custom/custom.css">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-dark-menu" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form class="login-form">
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4">Sign Up</h5>
                                </div>
                            </div>
                            <div id="data_panel">
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-2">lock_outline</i>
                                        <input type="email" id="txtEmail">
                                        <label>Email Address: </label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-2">person_outline</i>
                                        <input id="cnic" type="text">
                                        <label for="username" class="center-align">CNIC Number</label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-2">lock_outline</i>
                                        <input id="contact" type="number">
                                        <label>Contact Info</label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <a href="#" id="btnCheckData" class="btn waves-effect waves-light border-round blue col s12">Check Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6 m6 l6">
                                    <p class="margin medium-small"><a style="cursor:pointer;" onclick="window.history.back()">Go Back</a></p>
                                </div>
                            <div id="pass_panel">
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-2">lock_outline</i>
                                        <input id="password" type="password">
                                        <label>Password</label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix pt-2">lock_outline</i>
                                        <input id="conpassword" type="password">
                                        <label for="password">Confirm Password </label>
                                    </div>
                                </div>
                                <div class="row margin">
                                    <div class="input-field col s12">
                                        <a href="#" id="btnRegister" class="btn waves-effect waves-light border-round green col s12">Register Account</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <!-- BEGIN VENDOR JS-->
    <script src="../app-assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="../app-assets/js/plugins.js"></script>
    <script src="../app-assets/js/search.js"></script>
    <script src="../app-assets/js/custom/custom-script.js"></script>
    <script src="../app-assets/vendors/sweetalert/sweetalert.min.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->

    <script>
        $(document).ready(function() {
            $('#pass_panel').hide()
            $('#btnRegister').hide()

            $('#btnCheckData').click(function() {
                if ($('#cnic').val() == '' || $('#contact').val() == '' || $('#txtEmail').val() == '') {
                    swal('Error', 'All Fields Are Required..', 'warning')
                } else {
                    $.ajax({
                        url: "ajax/user?case=CheckData",
                        type: "GET",
                        data: {
                            email: $('#txtEmail').val(),
                            cnic: $("#cnic").val(),
                            contact: $('#contact').val()
                        },
                        success: function(resp) {
                            if (resp == 1) {
                                swal('Success', 'Kindly Set Your Password.', 'success')
                                $('#pass_panel').show()
                                $('#data_panel').hide()
                                $('#btnRegister').show()
                            }

                            if (resp == 0) {
                                swal('Invalid Data', "Sorry! Detail Not Found For This Record.", 'error')
                            }
                        }
                    })
                }
            })

            $('#btnRegister').click(function() {
            //    alert($('#txtEmail').val())
                if ($('#password').val() == '' || $('#conpassword').val() == '') {
                    swal('Error', 'Both Fields Are Required..', 'error')
                } else if ($('#password').val() != $('#conpassword').val()) {
                    swal('Warning', 'Password Mismatch.', 'warning')
                } else if ($('#password').val().length < 8) {
                    swal('Error', 'Password Should Be Atleat 8 Characters Long..', 'error')
                } else {
                    $.ajax({
                        url: "ajax/user?case=SetPassword",
                        type: "GET",
                        data: {
                            pass: $('#password').val(),
                            email:$('#txtEmail').val()
                        },
                        success: function(resp) {
                            console.log(resp)
                            if (resp == 1) {
                                swal('Success','Account Created Successfully..','success')
                                    setTimeout(() => {
                                        window.location.href="login.php"
                                    }, 2500);
                            }
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>