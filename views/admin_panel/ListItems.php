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
                            <h5 class="p-2">Pharmacy Items</h5>
                            <div class="row">
                                <div class="col s12 p4">
                                    <a href="Items.php" class="btn btn-sm float-right cyan">ADD</a> <br> <br>
                                    <table class="table small table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Strength</th>
                                                <th>Generic</th>
                                                <th>Unit Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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
        FetchItems()
    })

    function FetchItems()
    {
        $.ajax({
            url:"../ajax/Items?case=FetchItems",
            success:function(resp)
            {
                $('tbody').html('')
                $('tbody').append(resp)
                $('table').dataTable()
            }
        })
    }

    function DeleteItem(e)
    {
        $.ajax({
            url:"../ajax/Items?case=DeleteItem",
            type:"GET",
            data:{
                id:e.id
            },
            success:function(resp)
            {
                swal('success','Selected Meidcine Items Deleted Successfully..','success')
                FetchItems()
            }
        })
    }
</script>
</html>