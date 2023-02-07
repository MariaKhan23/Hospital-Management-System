<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Patient Invoice Management </title>
    <?php include_once '../include/style.php'; ?>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

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
                        <h5>Invoice Management</h5>
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12">
                                    <a href="CreateInvoice.php" class="btn green float-right">Create Receipt</a>
                                    <br><br>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Invoice#</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
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
        $(document).ready(function() {

            GenerateReciepts()

        })
        
        function GenerateReciepts()
        {
            $.ajax({
                url:'../ajax/Invoice/?case=GetInvoices',
                success:function(resp)
                {
                    $('tbody').append(resp)
                    $('tbody').css('background-color','red')
                    $('table').DataTable()
                }
            })
        }

        function ShowReciept(a)
        {
            // alert(a.id)
            window.location.href='../pages/Invoice.php?inv='+a.id
        }

        function EditReciept(e)
        {
            window.location.href='EditInvoice.php?inv='+e.id
        }
    </script>
</body>

</html>