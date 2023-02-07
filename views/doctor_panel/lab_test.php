<?php

session_start();

require_once '../connection/connection.php';

if (isset($_SESSION['email']) == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    if (!isset($_GET['mr'])) {
        echo "<script>window.location.href='index.php'</script>";
    } else {
        $data = mysqli_query($con, "select * from patient where mrno='" . $_GET['mr'] . "';");
        $patient_data = mysqli_fetch_assoc($data);
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Lab Test</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar1.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5>Lab Test Recommendation</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s2">MR#</div>
                                <div class="col s1" id="lblMR"><?php echo $patient_data['mrno']; ?></div>
                                <br><br>
                                <div class="col s2">Name:</div>
                                <div class="col s3" id="lblName"><?php echo $patient_data['name']; ?></div>
                                <br><br>
                                <div class="col s2">Age: </div>
                                <div class="col s1"><?php echo $patient_data['age']; ?></div>
                                <div class="float-right"><button class="btn gradient-45deg-purple-amber" onclick="window.history.back()">Cancel</button></div>
                                <br><br><br>
                                <div class="col s6 input-field">
                                    <select name="test" id="slctTest" class="select2 browser-default">
                                        <option value="">-- Select Specified Test --</option>
                                        <?php

                                        $data_query = mysqli_query($con, "select name from test order by id;");
                                        while ($row = mysqli_fetch_assoc($data_query)) {
                                            echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col s2">
                                    <button onclick="AddTest()" class="btn magenta">ADD</button>
                                </div>
                                <div class="col s2">
                                    <button onclick="SaveTest()" id="btnPrint" class="btn cyan">Print</button>
                                </div>
                                <div class="col s10">
                                    <table id="list_test">
                                        <tbody>

                                        </tbody>
                                    </table>
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
    <script>
        $(document).ready(function() {
            $('select').select2()
            $('#btnPrint').hide()
        })

        function AddTest() {
            if ($('#slctTest').val() == '') {
                swal('Warning', 'Please Select The Test First..', 'error')
            } else {
                var ul_list = $('tbody')
                $('#btnPrint').show()
                ul_list.append('<tr style="border:none;"><td>' + $('#slctTest').val() + '</td><td> <button onclick="EraseTest(this)" class="btn red float-right">Remove</button></td></tr>')
            }
        }

        function SaveTest() {
            var test = document.getElementsByTagName('tr').length
            for (let index = 0; index < test; index++) {
                var test_name = ($('tr')[index].childNodes[0].innerHTML)
                console.log(test_name)
                $.ajax({
                    url: "../ajax/Test?case=SaveTest",
                    type: "GET",
                    data: {
                        mr: $('#lblMR').html(),
                        name: $('#lblName').html(),
                        test: $('tr')[index].childNodes[0].innerText
                    },
                    success: function(resp) {
                        swal('Success', 'Lab Test Successfully Submitted..', 'success')
                        window.location.href='../pages/LabTest.php?mr='+$('#lblMR').html()
                    }
                })
            }
        }

        function EraseTest(t) {
            (t.parentNode.parentNode.remove())
        }
    </script>
</body>

</html>