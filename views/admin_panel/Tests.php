<?php

session_start();

require_once '../connection/connection.php';

if (isset($_GET['id'])) {
    $query = mysqli_query($con, "select * from test where id=" . $_GET['id'] . ";");

    if(mysqli_num_rows($query)>0)
    {
        $data = mysqli_fetch_assoc($query);
    }

    else
    {
        echo '<script>window.history.back()</script>';
    }

}

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
    <title>Lab Test Management Panel</title>
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
                            <h5 class="p-2">Lab Test Panel</h5>
                            <div class="row">
                                <div class="col s6 p-4">
                                    <div class="container">
                                        <input placeholder="Enter Laboratory Test Name" value="<?php
                                                                                            if (isset($data)) {
                                                                                                echo $data['name'];
                                                                                            }
                                                                                            ?>" type="text" id="txtName">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="container">
                                        <input type="text" value="<?php
                                                                    if (isset($data)) {
                                                                        echo $data['description'];
                                                                    }
                                                                    ?>" name="detail" placeholder="Enter Laboratory Test Description" id="txtDetails">
                                    </div>
                                </div>
                                <div class="col s6 container">
                                    <button onclick="Submit()" class="btn green mt-3">Submit</button>
                                    <a href="lab_test.php" class="btn mt-3 red">Cancel</a>
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

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <script>
        const params = new URLSearchParams(window.location.search)

        function Submit() {
            if (!params.has('id')) {
                //Insert Code\
                if($('#txtName').val()=='')
                {
                    swal('Error','Test Name is Required...','warning')
                }

                else
                {
                    
                $.ajax({
                    url: "../ajax/Test?case=SetTest",
                    type: "GET",
                    data: {
                        name: $('#txtName').val(),
                        details: $('#txtDetails').val(),
                    },
                    success: function(resp) {
                        if (resp == 1) {
                            swal({
                                title: "Success",
                                text: "Laboratory Test Registered Successfully..",
                                icon: 'success',
                                timer: 3000,
                                buttons: true
                            });
                        }
                    }
                })
                }

            } else {
                //Update Code
                $.ajax({
                    url: "../ajax/Test?case=UpdateTest",
                    type: "GET",
                    data: {
                        name: $('#txtName').val(),
                        details: $('#txtDetails').val(),
                        id: params.get('id')
                    },
                    success: function(resp) {
                        if (resp == 1) {
                            swal({
                                title: "Success",
                                text: "Laboratory Test Updated Successfully..",
                                icon: 'info',
                                timer: 3000,
                                buttons: true
                            });
                        }
                    }
                })
            }
        }
    </script>
    <!-- END PAGE LEVEL JS-->
</body>

</html>