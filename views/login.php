<?php
session_start();
?>
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
    <title>User Login | Hospital Management System</title>
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
                        <form action="#" method="get">
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4">Sign in</h5>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input required name="email" type="email">
                                    <label class="center-align">Email</label>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input required name="pass" type="password">
                                    <label>Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" name="btn2" class="container btn blue col s12" value="Log In">
                            </div>
                            <div class="row">
                                <div class="input-field col s6 m6 l6">
                                    <p class="margin medium-small"><a href="user-register.php">Register Now!</a></p>
                                </div>

                                <div class="input-field ml- col s6 m6 l6">
                                    <p class="margin medium-small"><a href="fpass.php">Forgot Password!</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <script src="../app-assets/js/vendors.min.js"></script>

    <script src="../app-assets/js/plugins.js"></script>
    <script src="../app-assets/js/search.js"></script>
    <script src="../app-assets/js/custom/custom-script.js"></script>
    <script src="../app-assets/vendors/sweetalert/sweetalert.min.js"></script>
 
    <script>
        $(document).ready(function() {

        })
    </script>
</body>

</html>
<?php
if (isset($_GET['btn2'])) {
    require_once 'connection/connection.php';
    
    $login_query = mysqli_query($con, "select * from staff where email='".$_GET['email']."' or cnic='".$_GET['email']."' and pasword='".$_GET['pass']."';");
    
    if (mysqli_num_rows($login_query) == 1) {
        
        $_SESSION['email'] = $_REQUEST['email'];

        $ID_QUERY = mysqli_query($con,"select emp_code,stats from staff where email='".$_GET['email']."' or cnic='".$_GET['email']."';");
        $data_id = mysqli_fetch_array($ID_QUERY);
        $id = $data_id[0];

        $designation_query = mysqli_query($con,"select designation from staff_roles where emp_code='".$id."';");
        $designation_data = mysqli_fetch_assoc($designation_query);
    
        if($data_id[1]=='0')
        {
            echo '<script>swal("Warning","This Account Is Inactivated, Contact Super Admin.","warning")</script>';
        }

        else
        {
            if($designation_data['designation']=='Doctor')
            {
                echo "<script>window.location.href='doctor_panel/'</script>";
            }
    
            else if($designation_data['designation']=='SUPER ADMIN')
            {
                echo "<script>window.location.href='admin_panel/'</script>";
            }
    
            else
            {
                echo '<script>window.location.href="user/"</script>';
            }
        }


    } else {
        echo "<script> swal('Error','Invalid Email or Password..','error') </script>";
    }
}

?>