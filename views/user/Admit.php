<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    require_once '../connection/connection.php';
    $data_query = mysqli_query($con, "select * from patient inner join patient_recieving on patient.mrno=patient_recieving.mrno where patient.mrno='MR-" . $_GET['mr'] . "';");
    if (mysqli_num_rows($data_query) > 0) {
        $details = mysqli_fetch_assoc($data_query);
    } else {
        echo "<script>window.location.href='PatientRecieving.php'</script>";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admit Patient</title>
    <?php include_once '../include/style.php'; ?>
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
                    <input type="hidden" name="id" id="txtAdmitID" value="<?php echo $details['id']; ?>">
                    <div class="section">
                        <h5>Manage Admitting Details</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0 container mt-3">
                            <div class="row">
                                <div class="col s3">
                                    <span>MR#</span>
                                </div>
                                <div class="col s9">
                                    <span id="lblMR"><?php echo $details['mrno'] ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    <span>Name:</span>
                                </div>
                                <div class="col s9">
                                    <span id="lblName"><?php echo $details['name'] ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    <span>Age:</span>
                                </div>
                                <div class="col s9">
                                    <span id="lblAge"><?php echo $details['age'] ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    <span>Gender: </span>
                                </div>
                                <div class="col s9">
                                    <span id="lblGender"><?php $g_q = mysqli_query($con, "select gender from patient where mrno='MR-" . $_GET['mr'] . "'");
                                                            $result = mysqli_fetch_assoc($g_q);
                                                            echo $result['gender']; ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    <span>Admitting To: </span>
                                </div>
                                <div class="col s9">
                                    <span id="lblMR_" style="font-weight:bolder;"><?php echo $details['ward'] ?></span>
                                </div>
                                <br><br>
                                <div class="col s4">
                                    <label>Attendant Name:</label>
                                    <input type="text" name="attendant_name" id="txtAttendantName" />
                                </div>
                                <div class="col s3">
                                    <label>Attendant Contact Info: </label>
                                    <input type="text" name="contact_info" id="txtAttendantContactInfo">
                                </div>
                                <div class="col s3">
                                    <label>Attendant CNIC: </label>
                                    <input type="text" name="cnic" id="txtAttendantCNIC">
                                </div>
                                <div class="col s2">
                                    <label>Select Bed No:</label>
                                    <input type="number" name="bed_no" id="txtBed">
                                </div>
                                <br><br>
                                <div class="col s6">
                                    <button class="btn" onclick="AdmitPatient(this)" style="background-color:#198754;">Submit</button>
                                    <button class="btn red" onclick="window.history.back()">Cancel</button>
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
    <div id="modal1" class="modal">
        <div class="modal-content">
            
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
            $('#txtAttendantContactInfo').formatter({
                'pattern': '{{9999}}-{{9999999}}',
                'persistent':true
            });

            $('#txtAttendantCNIC').formatter({
                'pattern': '{{99999}}-{{9999999}}-{{9}}',
                'persistent':true
            })
        })

        function AdmitPatient(e) {
            
            if ($('#txtAttendantName').val() == '') {
                swal('Error', 'Attendant Name is Required..', 'warning')
            } else if ($('#txtAttendantContactInfo').val().length < 12) {
                swal('Warning', 'Attendant Contact Number is Required or Provided Invalid..', 'warning')
            } else if ($('#txtBed').val() == '') {
                swla('Warning', 'Bed Number is Required..', 'error')
            } else {
                $.ajax({
                    url: "../ajax/PatientRecieving?case=AdmitPatient",
                    type: "GET",
                    data: {
                        id: $('#txtAdmitID').val(),
                        name: $('#txtAttendantName').val(),
                        contact: $('#txtAttendantContactInfo').val(),
                        cnic: $('#txtAttendantCNIC').val(),
                        bed: $('#txtBed').val(),
                        gender: $('#lblGender').html()
                    },
                    success: function(resp) {
                        console.log(resp)
                        if (resp == 1) {
                            swal('Completed!', 'Patient Admitted Successfully..', 'success')
                            setTimeout(() => {
                                window.location.href = 'PatientRecieving.php'
                            }, 1500);
                        }

                        if (resp == 0) {
                            swal('Warning', 'This Bed Is Already Reserved.', 'warning')
                        }
                    }
                })
            }
        }

        function GenerateSummary() {
            $.ajax({
                url: "../ajax/PatientRecieving?case=GenerateSheet",
                type: "GET",
                data: {
                    ward: $('#lblMR_').html(),
                    id:$('#txtAdmitID').val()
                },
                success: function(resp) {
                      $('.modal-content').html('<h5 class="p-2">'+$('#lblMR_').html()+' Summary</h5>')
                    $('.modal-content').append(resp)
                }
            })
        }
    </script>
</body>

</html>