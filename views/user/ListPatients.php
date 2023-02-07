<?php

session_start();


if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include_once '../include/style.php'; ?>
</head>

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <?php include_once '../include/userbar.php'; ?>
    <!-- END: SideNav-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5 class="p-2">Patient Registration Panel</h5>
                            <div class="row">
                                <div class="col s12 p4">
                                    <a href="Patients.php" class="btn btn-sm float-right cyan">ADD</a> <br> <br>
                                    <small>
                                        <small>

                                            <table class="table small table-hover table-striped w-100">
                                                <thead>
                                            <tr>
                                                <th>MR#</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
</small>
</small>
</div>
                                <div class="col s2 container">
                                </div>
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                    <!-- END RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <div class="modal" id="modalStaffRoles">
        <div class="modal-content">
           
        </div>
    </div>

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <!-- END PAGE LEVEL JS-->
    <script>

    </script>
</body>
<script>
   $(document).ready(function()
   {
        FetchPatients();
   })

   function FetchPatients()
   {
    $.ajax({
        url:"../ajax/patient?case=FetchPatients",
        success:function(resp)
        {
            $('tbody').html('')
            $('tbody').append(resp)
            $('table').DataTable({
                dom: 'Bfrtip',
        buttons: [
            {
                text: 'My button',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ]
            })
        }
    })
   }
</script>

</html>
<!-- END: Head-->