<?php

session_start();

if($_SESSION['email']==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

else
{
    require_once '../connection/connection.php';
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
    <?php include_once '../include/sidebar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5 class="p-2">Staff List</h5>
                            <div class="row">
                                <div class="col s12 p4">
                                    <a href="Staff.php" class="btn btn-sm float-right cyan">ADD</a> <br> <br>
                                    <small>
                                        <small>

                                            <table class="table small table-hover table-striped w-100">
                                                <thead>
                                            <tr>
                                                <th>EMP ID</th>
                                                <th>Name</th>
                                                <th>Father Name</th>
                                                <th>Gender</th>
                                                <th>Contact#</th>
                                                <th>CNIC</th>
                                                <th>Status</th>
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
    $(document).ready(function(params) {
        RenderStaff()
    })

    function RenderStaff() {
        $.ajax({
            url: "../ajax/Staff?case=FetchStaff",
            success: function(resp) {
                $('table tbody').empty()
                $('tbody').append(resp)
                $('table').DataTable()
                $('tbody').css('background-color', 'transparent')
            }
        })
    }


    function DeleteStaff(staff_id) {
        $.ajax({
            url: "../ajax/Staff?case=DeleteStaff",
            type: "GET",
            data: {
                id: staff_id.id
            },
            success: function(resp) {
                if (resp == 1) {
                    $('table tbody').empty()
                  $('table').DataTable()
                }
            }
        })
    }

    function GenerateRoles(id)
    {
        $('.modal-content').load('../pages/Roles.php?uid='+id.id)
    }
</script>

</html>
<!-- END: Head-->