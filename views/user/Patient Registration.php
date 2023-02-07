<?php

session_start();


if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
   <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->
   <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/userbar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Patient Registration</span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!-- <div class="row">
                            <div class="col s6">
                                <div class="form-group">
                                    <input type="text" placeholder="Patient Name" id="txtPatientName">
                                </div>
                            </div>
                            <div class="col s6">
                                <input type="number" placeholder="Patient Age" id="txtPatientAge">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s6">
                                <input type="number" placeholder="Contact Info" name="contact" id="txtPatientContactInfo">
                            </div>
                            <div class="col s6">
                                <input type="number" placeholder="Patient CNIC" name="cnic" id="txtPatientCNIC">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s12">
                                <input type="text" placeholder="Aliment" name="aliment" id="txtPatientAliment">
                            </div>
                        </div>
                        <br>
                        <button class="mb-6 btn waves-effect waves-light green">Save</button>
                    </div> -->

                    <div class="row">
      <div class="col s12">
        <ul class="tabs">
          <li class="tab col m3"><a href="#test1">Patient Registration</a></li>
          <li class="tab col m3"><a class="active" href="#test2">Online Approve Appointments</a></li>
          <li class="tab col m3"><a href="#test4">Peding Appointments</a></li>
        </ul>
      </div>
      <div id="test1" class="col s12">
      <div class="row">
                            <div class="col s6">
                                <div class="form-group">
                                    <input type="text" placeholder="Patient Name" id="txtPatientName">
                                </div>
                            </div>
                            <div class="col s6">
                                <input type="number" placeholder="Patient Age" id="txtPatientAge">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s6">
                                <input type="number" placeholder="Contact Info" name="contact" id="txtPatientContactInfo">
                            </div>
                            <div class="col s6">
                                <input type="number" placeholder="Patient CNIC" name="cnic" id="txtPatientCNIC">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s12">
                                <input type="text" placeholder="Aliment" name="aliment" id="txtPatientAliment">
                            </div>
                        </div>
                        <br>
                        <button class="mb-6 btn waves-effect waves-light green">Save</button>
      </div>
      <div id="test2" class="col s12">Test 2</div>
      <div id="test3" class="col s12">Test 3</div>
      <div id="test4" class="col s12">Test 4</div>
    </div>
</div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <footer class="page-footer footer footer-static footer-light white navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function()
        {
            $('.tabs').tabs()
        })
    </script>
</body>
</html>