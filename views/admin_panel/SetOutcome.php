<?php

session_start();

require_once '../connection/connection.php';

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Outcome Panel </title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5 class="p-1">Outcome Panel</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div id="list" class="col s6">
                                    <select name="patient" class="select2 browser-default" id="slctPatient">
                                        <option value="">-- Select Patient --</option>
                                        <?php

                                        $get_user_code = mysqli_fetch_assoc(mysqli_query($con, "select emp_code from staff where email='" . $_SESSION['email'] . "' or cnic='" . $_SESSION['email'] . "';"));

                                        $get_user_designation_and_ward = mysqli_query($con, "select designation,ward from staff_roles where emp_code='" . $get_user_code['emp_code'] . "'");
                                        $user_designation_and_ward = mysqli_fetch_assoc($get_user_designation_and_ward);

                                        $query = mysqli_query($con, "select mrno,name from patient_recieving where is_admitted=1 and ward='" . $user_designation_and_ward['ward'] . "';");

                                        $id = 'slctPatient';
                                        $a = '';

                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $a .= '<option value="' . $data['mrno'] . '">' . $data['mrno'] . ' (' . $data['name'] . ')</option>';
                                        }

                                        echo $a;

                                        ?>
                                    </select>
                                </div>
                                <div class="col s3">
                                    <button class="btn magenta" onclick="GenerateData()">Generate Data</button>
                                </div>
                                <div class="col s1">
                                    <button class="btn red" onclick="window.history.back()">Cancel</button>
                                </div>
                            </div>
                            <br>
                            <div class="row mt-2" id="rowData">
                                <div class="col s3">MR:</div>
                                <div class="col s3"><span id="lblMR">MR-1</span></div>

                                <div class="col s3">Name:</div>
                                <div class="col s3"><span id="lblName">2</span></div>
                                <br><br>
                                <div class="col s3">Age:</div>
                                <div class="col s3"><span id="lblAge">3</span></div>

                                <div class="col s3">Gender:</div>
                                <div class="col s3"><span id="lblGender">3</span></div>
                                <br><br>
                                <div class="col s3">Attendant Name:</div>
                                <div class="col s3"><span id="lblAttendantName">3</span></div>

                                <div class="col s3">Attendant Contact Info:</div>
                                <div class="col s3"><span id="lblAttendantContactInfo">3</span></div>
                                <br><br>

                                <div class="col s3">Attendant CNIC:</div>
                                <div class="col s3"><span id="lblAttendantCNIC">3</span></div>

                                <div class="col s3">Admitted In:</div>
                                <div class="col s3"><span id="lblWard">3</span></div>
                                <br><br>

                                <div class="col s3">Bed No:</div>
                                <div class="col s3"><span id="lblBedno">3</span></div>

                                <div class="col s3">Admitted At:</div>
                                <div class="col s3"><span id="lblAdmitDate">3</span></div>
                                <br><br>

                                <div class="col s4">
                                    <label>Patient Outcome:</label>
                                    <select name="outcome" id="slctOutcome">
                                        <option value="Discharged">Discharged</option>
                                        <option value="Expired">Expired</option>
                                        <option value="Sent Back to Ward">Sent Back to Ward</option>
                                        <option value="Refer to Other Hospital">Refer to Other Hospital</option>
                                        <option value="Improved &amp; SentBack To Ward">Improved &amp; SentBack To Ward</option>
                                        <option value="Discharged Upon Patient Request">Discharged Upon Patient Request</option>
                                    </select>
                                </div>
                                <div class="col s4">
                                    <label>Final Notes (if any):</label>
                                    <input type="text" name="final_notes" id="txtFinalNotes" />
                                </div>

                                <div class="col s4">
                                    <label>Outcome Date:</label>
                                    <input type="date" name="outcome_date" id="txtDate" />
                                </div>

                                <div id="other">

                                </div>
                                            <br><br>
                                <div class="col s3">
                                    <button class="btn green accent-3" onclick="SaveOutcome()">Save</button>
                                    <button class="btn red accent-3" onclick="window.history.back()">Cancel</button>
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
        $(document).ready(function() {
            $('#slctPatient').select2()
             $('#rowData').hide()
        })

        function GenerateData() {
            var patient_mr = ($('#slctPatient').val())

            if (patient_mr == '') {
                swal('Error', 'Please Select Patient..', 'warning')
            } else {
                $.ajax({
                    url: "../ajax/PatientOutcome/?case=GetPatientData",
                    type: "GET",
                    data: {
                        mr: patient_mr
                    },
                    success: function(resp) {
                        $('#rowData').show()
                        var data = $.parseJSON(resp)

                        $('#lblMR').html(data.mrno)
                        $('#lblName').html(data.name)
                        $('#lblAge').html(data.age)
                        $('#lblGender').html(data.gender)
                        $('#lblAttendantName').html(data.attendant_name)
                        $('#lblAttendantCNIC').html(data.attendant_cnic)
                        $('#lblAttendantContactInfo').html(data.attendant_contactinfo)
                        $('#lblWard').html(data.ward)
                        $('#lblBedno').html(data.bedno)
                        $('#lblAdmitDate').html(data._date)

                        console.log(data)
                    }
                })
            }
        }

        function SaveOutcome()
        {
            if($('#txtDate').val()=='')
            {
                swal('Error','Outcome Date is Required..','warning')
            }

            else
            {
                $.ajax({
                    url:"../ajax/PatientOutcome/?case=SaveOutcome",
                    type:"GET",
                    data:{
                        mr:$('#lblMR').html(),
                        date:$('#txtDate').val(),
                        outcome:$('#slctOutcome').val(),
                        final_notes:$('#txtFinalNotes').val(),
                        name:$('#lblName').html()
                    },
                    success:function(resp)
                    {
                        if(resp==1)
                        {
                            swal('Success','Patient Outcome Defined Successfully..','success')

                            setTimeout(() => {
                                    window.location.href='PatientOutcome.php'
                            }, 1300);
                        }
                    }
                })
            }
        }
    </script>
</body>

</html>