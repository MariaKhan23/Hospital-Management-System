<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lab Test Results Panel</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <?php include_once '../include/sidebar2.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <form method="POST">
                                <div class="row">
                                    <div class="col s12">
                                        <h5>Lab Test Results</h5>
                                    </div>
                                    <div class="col s9">
                                        <label>Enter MR No:</label>
                                        <input type="text" name="mrno" id="txtMrNo">
                                    </div>
                                    <div class="col s3">
                                        <input type="submit" name="btnSubmit" value="Generate Results" class="btn mt-5">
                                        <!-- <button class="btn mt-5" onclick="GenerateResults()">Generate Results</button> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-overlay">
            </div>
            <table id="tblResults">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Results</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    </div>

    <?php include_once '../include/scripts.php'; ?>
</body>

<?php
if (isset($_REQUEST['btnSubmit'])) {
    $str = '';
    require_once '../connection/connection.php';

    if ($_REQUEST['mrno'] == '') {
        echo "<script>swal('Error','MRNO is Required..','info')</script>";
    } else {
        $query = mysqli_query($con, "select * from lab_test where mrno='" . strtoupper($_REQUEST['mrno']) . "';");

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $str .= "<tr><td>" . $row['lab_test'] . "</td><td><a href='+'../test_files/" . $row['results'] . "'+'>Test Results</a></td></tr>";
            }
            
            echo "<script>$('tbody').append('" . $str . "')</script>";
            echo '<script>$("table").show()</script>';
        } else {
            echo '<script>swal("Sorry.","No Records Found.","error")</script>';
        }
    }
}

?>

</html>