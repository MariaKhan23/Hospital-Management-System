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
        <title>Manage Patient Dossage </title>
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
                        <h5>Patient Dosage  </h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                   <div class="col s12 p-3">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td>MR#</td>
                                                    <td>Name</td>
                                                    <td>Age</td>
                                                    <td>Patient Contact Info</td>
                                                    <td>Patient CNIC</td>
                                                    <td>Action</td>
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
            </div>
        </div>
    </div>

    <div id="modalDosage" class="modal">
        <div class="modal-content">
            <div class="container">
                <table id="tblData">
                    <thead>
                        <tr>
                            <th>Dosage</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="y">

                    </tbody>
                </table>
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
            GenerateAdmittedPatients()
        })

        function GenerateAdmittedPatients()
        {
            $.ajax({
                url:"../ajax/PatientDosage?case=GetAdmittedPatients",
                success:function(resp)
                {
                    $('tbody').html('')
                    $('tbody').append(resp)
                    $('table').dataTable()
                }
            })
        }


        function SetDossage(e){
            window.location.href='DossageIssuance.php?mr='+e.id
        }
    </script>
</body>
</html>