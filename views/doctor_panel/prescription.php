<?php

session_start();

require_once '../connection/connection.php';

if (isset($_SESSION['email']) == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

if (!isset($_GET['mr'])) {
    echo "<script>window.location.href='index.php'</script>";
} else {
    $data = mysqli_query($con, "select * from patient where mrno='" . $_GET['mr'] . "';");
    $patient_data = mysqli_fetch_assoc($data);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome - Doctor Panel</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar1.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-1">
                            <H5>Medicine Recommendation</H5>

                            <div class="row">
                                <div class="col s2">MR#</div>
                                <div class="col s1"><?php echo $patient_data['mrno']; ?></div>
                                <br><br>
                                <div class="col s2">Name:</div>
                                <div class="col s3"><?php echo $patient_data['name']; ?></div>
                                <br><br>
                                <div class="col s2">Age: </div>
                                <div class="col s1"><?php echo $patient_data['age']; ?></div>
                                <div class="float-right"><button class="btn red" onclick="window.history.back()">Cancel</button></div>
                                <br><br>
                                <div class="col s6">
                                    <div class="input-field">
                                        <select name="items" class="select2 browser-default" id="slctItems">
                                            <option value="" selected>-- Select Medicine --</option>
                                            <?php

                                            $q = mysqli_query($con, "select name from items;");
                                            while ($data = mysqli_fetch_assoc($q)) {
                                                echo "<option value='" . $data['name'] . "'>" . $data['name'] . "</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col s2">
                                    <input type="text" name="med_time" placeholder="Med Time" id="txtMedTime">
                                </div>
                                <div class="col s2">
                                    <input type="number" name="day" placeholder="Enter Days" id="txtDays">
                                </div>
                                <div class="col s1"><button onclick="AddMed(this)" class="btn blue">ADD</button></div>
                                <div class="col s11 container">

                                    <table class="ml-3">
                                </div>
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Prescription Schedule</th>
                                        <th>Follow Up Days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                </table>
                                <br>
                                <button id="btnPrint" class="btn cyan float-right">Print</button>
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
        $(document).ready(function() {



            $('#btnPrint').hide()
            $('table').hide()
            $('#slctItems').select2({
                dropdownAutoWidth: true,
                width: '100%'
            })
        })

        $('#btnPrint').click(function() {
            var med_rows = (document.getElementsByTagName('tr').length)

            for (let index = 1; index < med_rows; index++) {

                $.ajax({
                    url: "../ajax/Prescription?case=SetPrescription",
                    type: "GET",
                    data: {
                        name: $('tr')[index].childNodes[0].innerText,
                        schedule: $('tr')[index].childNodes[1].innerText,
                        days: $('tr')[index].childNodes[2].innerText,
                        mr: params.get('mr'),
                        doctor_code: '<?php echo $_SESSION['email'] ?>'
                    },

                    success: function(data) {
                            swal('Completed', 'Patient Prescriptions Have Successfully Registered..', 'success')
                        setTimeout(() => {
                                window.location.href="../pages/Prescription.php?mr="+data
                        }, 2200);
                    }
                })
            }
        })

        $('#txtMedTime').formatter({
            'pattern': '{{9}}-{{9}}-{{9}}',
            'persistent': true
        });

        function AddMed(med) {
            var item = ($('#slctItems').val())

            $('table').show()
            $('#btnPrint').show()
            if ($('#slctItems').val() == '') {
                swal('Warning', 'Please Select The Medicine', 'warning')
            } else {
                $('tbody').append('<tr><td>' + $('#slctItems').val() + '</td><td>' + $('#txtMedTime').val() + '</td><td>' + $('#txtDays').val() + '</td><td><button class="btn red" onclick="Remove(this)">Delete</button></td></tr>')
            }
        }

        function Remove(a) {
            a.parentNode.parentNode.remove()
        }
    </script>
    <!-- END PAGE LEVEL JS-->
</body>

</html>