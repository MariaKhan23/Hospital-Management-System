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
                                    <h5 class="ml-4">Forgot Password</h5>
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
                                        <a href="#modalPass" onclick="CheckEmail()" id="btnCheckData" class="btn modal-trigger waves-effect waves-light border-round blue col s12">Check Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6 m6 l6">
                                    <p class="margin medium-small"><a style="cursor:pointer;" onclick="window.history.back()">Go Back</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <div class="modal" id="modalPass">
        <div class="modal-content">
            <div class="row" id="rowData">
                <div class="col s10">
                    <label>Enter Verification Code: </label>
                    <input type="number" name="verfication_code" id="txtVerificationCode">
                </div>
                <div class="col s2">
                    <button class="btn green" onclick="VerifyCode()" id="txtSubmit">Check.</button>
                </div>
            </div>
            <br>
            <div class="row" id="passData">
                <div class="col s12">
                    <label>Password: </label>
                    <input type="password" name="pass" id="txtPass" />
                </div>
                <div class="col s12">
                    <label>Confirm Password: </label>
                    <input type="password" name="con_pass" id="txtConfirmPass" />
                </div>
                <div class="col s5"><button class="btn blue" onclick="ChangePassword()" id="txtChangePass">Change Password</button></div>
            </div>
        </div>
    </div>

    <script src="../app-assets/js/vendors.min.js"></script>
    <script src="../app-assets/js/plugins.js"></script>
    <script src="../app-assets/js/scripts/advance-ui-modals.js"></script>
    <script src="../app-assets/js/search.js"></script>
    <script src="../app-assets/js/custom/custom-script.js"></script>
    <script src="../app-assets/vendors/sweetalert/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#row_verify').hide()
            $('#rowData').hide()
            $('#passData').hide()
        })

        function ChangePassword() {
            if ($('#txtPass').val() != $('#txtConfirmPass').val()) {
                swal('Warning', 'Password MisMatch', 'warning')
            } else if ($('#txtPass').val() == '') {
                swal('Warning', 'New Password is Required..', 'warning')
            } else if ($('#txtConfirmPass').val() == '') {
                swal('Warning', 'Password Confirmation is Required..', 'warning')
            } else if ($('#txtPass').val().length < 8) {
                swal('Warning', 'Password Must Be Atleast 8 Characters Long..', 'warning')
            } else {
                $.ajax({
                    url: "ajax/ForgotPassword/?case=ChangePass",
                    type: "GET",
                    data: {
                        email: $('#txtEmail').val(),
                        pass: $('#txtPass').val()
                    },
                    success: function(resp) {
                        if (resp == 1) {
                            setTimeout(() => {
                                swal('Success', 'Your Password Have Successfully Updated..', 'success')
                                window.location.href = 'login.php';
                            }, 3000)
                        }
                    }
                })
            }
        }

        function VerifyCode() {
            $.ajax({
                url: "ajax/ForgotPassword/?case=VerifyCode",
                type: "GET",
                data: {
                    code: $('#txtVerificationCode').val()
                },
                success: function(resp) {
                    if (resp == 1) {
                        $('#passData').show()
                        $('#rowData').hide()
                    } else {
                        swal('Error', 'Invalid Verification Code', 'info');
                    }
                }
            })
        }

        function CheckEmail() {
            $.ajax({
                url: "ajax/ForgotPassword/?case=CheckEmail",
                type: "GET",
                data: {
                    email: $('#txtEmail').val()
                },
                success: function(resp) {
                    if (resp == 2) {
                        $('.modal-content').append('<h5>This Email Doesn\'t Exist In The Database..</h5>')
                    } else {
                        $('#rowData').show()
                    }
                }
            })
        }
    </script>
</body>

</html>