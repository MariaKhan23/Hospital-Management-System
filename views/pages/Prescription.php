<?php

session_start();

if (isset($_SESSION['email']) == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

else
{
    require_once '../connection/connection.php';
    $query = mysqli_query($con,"select *,patient.name as PName,doctor.name as DocName from prescriptions left join patient on prescriptions.mrno=patient.mrno left join doctor on prescriptions.doctor=doctor.emp_code where prescriptions.mrno='".$_GET['mr']."';");
    $patient = mysqli_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome - Hospital Management System</title>
    <?php include_once '../include/style.php'; ?>
    <style>
        
    </style>
</head>
<!-- END: Head-->

<body onafterprint="window.history.back()" class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s2">
                                            <img src="../images/nobg.png" height="100" width="120" alt="">
                                        </div>
                                        
                                        <div class="col s8">
                                            <h3 class="blue-text">Patient Prescription Slip</h3>
                                        </div>
                                    </div>
                                </div>

    </div>
        <div class="row">
                <div class="col s3">Patient MR:</div>
                <div class="col s5"><?php echo $_GET['mr']; ?></div>
    </div>
    <br>
    <div class="row">
        <div class="col s3">Patient Name: </div>
        <div class="col s5"><?php echo $patient['PName']; ?></div>
</div>
<br>
<div class="row">
    <div class="col s3">Suggested By: </div>
    <div class="col s5"><?php echo 'DR-'.$patient['DocName']; ?></div>
                                <div class="col s10">
                                    <hr>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Schedule</th>
                                                <th>Follow Up Days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            require_once '../connection/connection.php';

                                            $query = mysqli_query($con, "select * from prescriptions where mrno='" . $_GET['mr'] . "';");

                                            while ($row = mysqli_fetch_assoc($query)) {
                                                echo '<tr>
                                                <td>' . $row['item'] . '</td>
                                                <td>' . $row['med_time'] . '</td>
                                                <td>' . $row['days'] . '</td>
                                                </tr>';
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <?php echo '<span class="float-right">'.date('Y-m-d').'</span>'; ?>
                                    <span class="float-right mr-2">Date:</span>&nbsp;&nbsp;
                                    <br><br><br>
                                    <span class="float-right">_______________________</span>
                                    <span class="float-right" class="mr-4">Signature: </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>

    <footer class="footer">
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function(){
            window.print()
        })
    </script>
</body>

</html>