<?php

session_start();

if($_SESSION['email']==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lab Test Results </title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

   <?php include_once '../include/header.php'; ?>
   
    <?php include_once '../include/sidebar.php'; ?>

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        
                        <div id="card-stats" class="pt-0">
                            <h5>Test Results Panel</h5>
                            <div class="row">
                                <div class="col s12">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>MrNo</th>
                                                <th>Name</th>
                                                <th>Suggested By</th>
                                                <th>Registered At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
    $(document).ready(function()
    {
        $.ajax({
            url:"../ajax/Results?case=GetPatients",
            success:function(resp)
            {
                $('tbody').html('')
                $('tbody').append(resp)
                $('table').dataTable()
            }
        })
    })

    function ManageResult(mr)
    {
        window.location.href='Results.php?mr='+mr.id
    }
   </script>
</body>
</html>