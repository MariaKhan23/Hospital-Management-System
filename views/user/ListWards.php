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
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5 class="p-2">Wards List</h5>
                            <div class="row">
                                <div class="col s12 p4">
            <a href="Wards.php" class="btn btn-sm float-right cyan">ADD</a> <br> <br>
                        <table class="table table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>No. of Bed(s)</th>
                                    <th>Department</th>
                                    <th>One Day Rent</th>
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
            
            <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
                <div class="footer-copyright">
                    </div>
                </footer>
                
                <?php include_once '../include/scripts.php'; ?>
                <!-- END PAGE LEVEL JS-->
                <script>
                    //$(document).ready(function(){
                        function FetchDepartments()
                        {
                            $.ajax({
                            url:"../ajax/Ward?case=FetchWard",
                            type:"GET",
                            success:function(resp)
                            {
                              //  console.clear()
                                $('tbody').append(resp)
                                $('table').DataTable()
                            }
                        })
                        }

                        FetchDepartments()
                    

                    function DeleteThis(e)
                        {
                            swal({
    title: "Are you sure?",
    text: "You will not be able to recover this",
    icon: 'warning',
    dangerMode: true,
    buttons: {
      cancel: 'No',
      delete: 'Yes'
    }
  }).then(function (willDelete) {
    if (willDelete) {
        $.ajax({
            url:"../ajax/Ward?case=DeleteWard",
            type:"GET",
            data:{
                id:e.id
            },
            success:function(resp)
            {
                if(resp==1)
                {
                    swal("Your Data has been deleted!", {
                      icon: "success",
                    });

                    $('table tbody').empty()
                    FetchDepartments()
                }
            }
        })
    } else {
      swal("Your Data is safe", {
        title: 'Cancelled',
        icon: "error",
      });
    }
  });
                        }
                </script>
            </body>
            </html>
            <!-- END: Head-->