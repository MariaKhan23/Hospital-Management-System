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
    <title>Patient Recieving </title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/userbar.php'; ?>
    <div class="modal" id="modalEdit" style="overflow:hidden;">
        <h5 style="text-align:center;">Patient Recieving Panel</h5>
        <div class="modal-content">
            <div class="row">
                <div class="col s3">MR:</div>
                <div class="col s9"><span id="lblMR"></span></div>
                <br><br>
                <div class="col s3">Name: </div>
                <div class="col s9"><span id="lblName"></span></div>
                <br><br>
                <div class="col s3">Ward: </div>
                <div class="col s9"><span id="lblWard"></span></div>
                <br><br>
                <div class="col s3">Bed No:</div>
                <div class="col s9"><span id="lblBedno"></span></div>
            </div>
            <div class="row">
                <div class="col s4 mt-3">Attendant Name: </div>
                <div class="col s8"><input type="text" name="attendant_name" id="txtName" /></div>
                <br><br>
                <div class="col s4 mt-3">Attendant ContactInfo: </div>
                <div class="col s8"><input type="text" name="contact_info" id="txtContactInfo" /></div>
                <br><br>
                <div class="col s4 mt-3">Attendant CNIC:</div>
                <div class="col s8"><input type="text" name="cnic" id="txtCNIC" /></div>
                <br><br>
                <div class="col s12">
                    <button class="btn green float-right" onclick="UpdateRecieving()">Update</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    </div>
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5>Patient Recieving Panel</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <table id="tblPatients">
                                <thead>
                                    <tr>
                                        <th>MR#</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Contact#</th>
                                        <th>CNIC</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                    <!-- END RIGHT SIDEBAR NAV -->
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalView">
        <div style="text-align:center;">
            <h5>Patient Recieving Details</h5>
        </div>
        <br>
        <div class="modal-content">
            <div class="row">
                <div class="col s3">MR:</div>
                <div class="col s3"><span id="lblMR1"></span></div>

                <div class="col s3">Name:</div>
                <div class="col s3"><span id="lblName1"></span></div>
                <br><br>
                <div class="col s3">Age:</div>
                <div class="col s3"><span id="lblAge"></span></div>

                <div class="col s3">Gender:</div>
                <div class="col s3"><span id="lblGender"></span></div>
                <br><br>
                <div class="col s3">Contact Info:</div>
                <div class="col s3"><span id="lblContactInfo1"></span></div>

                <div class="col s3">CNIC:</div>
                <div class="col s3"><span id="lblCNIC"></span></div>
                <br><br>
                <div class="col s3">Attendant Name:</div>
                <div class="col s3"><span id="lblAttendantName"></span></div>

                <div class="col s3">Attendant Mobile:</div>
                <div class="col s3"><span id="lblAttendantContactInfo"></span></div>
                <br><br>
                <div class="col s3">Attendant CNIC:</div>
                <div class="col s3"><span id="lblCNIC_"></span></div>

                <div class="col s3">Admit In:</div>
                <div class="col s3"><span id="lblWard1"></span></div>
                <br><br>
                <div class="col s3">Bed No:</div>
                <div class="col s3"><span id="lblBedno1"></span></div>

                <div class="col s3">Submit By:</div>
                <div class="col s3"><span id="lblSubmitBy1"></span></div>
                <br><br>
                <div class="col s3">Last Update By:</div>
                <div class="col s3"><span id="lblUpdateBy1"></span></div>
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
            FetchPatients();

            $('#txtContactInfo').formatter({
                'pattern':'03{{99}}-{{9999999}}'
            })

            $('#txtCNIC').formatter({
                'pattern':'{{99999}}-{{9999999}}-{{9}}'
            })
        })

        function FetchPatients() {
            $.ajax({
                url: "../ajax/PatientRecieving?case=GetPatient",
                success: function(resp) {
                    $('tbody').html('')
                    $('tbody').append(resp)
                    $('table').DataTable({
                        dom: 'Bfrtip',
                        buttons: [{
                            text: 'My button',
                            action: function(e, dt, node, config) {
                                alert('Button activated');
                            }
                        }]
                    })
                }
            })
        }


        function SetAdmission(e) {
            window.location.href = 'Admit.php?mr=' + e.id
        }

        function GetDetails(param) {
            $.ajax({
                url: "../ajax/PatientRecieving/?case=GetSingleData",
                type: "GET",
                data: {
                    mr: param.id
                },
                success: function(resp) {
                    let data = $.parseJSON(resp)

                    $('#lblMR1').html('MR-' + param.id)
                    $('#lblName1').html(data.name)
                    $('#lblContactInfo1').html(data.contactinfo)
                    $('#lblAge').html(data.age)
                    $('#lblGender').html(data.gender)
                    $('#lblWard1').html(data.ward)
                    $('#lblCNIC').html(data.cnic)
                    $('#lblAttendantName').html(data.attendant_name)
                    $('#lblAttendantContactInfo').html(data.attendant_contactinfo)
                    $('#lblCNIC_').html(data.attendant_cnic)
                    $('#lblSubmitBy1').html(data.submit_by)
                    $('#lblUpdateBy1').html(data.update_by)
                    $('#lblBedno1').html(data.bedno)

                    if (data.cnic == '') {
                        $('#lblCNIC').html('----')
                    } else {
                        $('#lblCNIC').html(data.cnic)
                    }

                }
            })
        }

        function UpdateRecieving() {
            var mr = $('#lblMR').html()

            $.ajax({
                url: "../ajax/PatientRecieving/?case=UpdateRecieving",
                type: "GET",
                data: {
                    mr: mr,
                    name: $('#txtName').val(),
                    contactinfo: $('#txtContactInfo').val(),
                    cnic: $('#txtCNIC').val()
                },
                success: function(resp) {
                    if (resp == 0) {
                        swal('Warning', 'This Bed Number is Already Reserved..', 'warning')
                    }

                    if (resp == 1) {
                        swal('Success', 'Patient Recieving Details Updated Successfully...', 'success')
                    }
                }
            })
        }

        function GetDetailsForEdit(id) {
            $.ajax({
                url: "../ajax/PatientRecieving/?case=GetSingleData",
                type: "GET",
                data: {
                    mr: id.id
                },
                success: function(resp) {
                    console.log(resp)
                    let data = $.parseJSON(resp)

                    $('#lblMR').html('MR-' + id.id)
                    $('#lblName').html(data.name)
                    $('#lblWard').html(data.ward)
                    $('#lblBedno').html(data.bedno)

                    $('#txtName').val(data.attendant_name)
                    $('#txtContactInfo').val(data.attendant_contactinfo)
                    $('#txtCNIC').val(data.attendant_cnic)
                    $('#txtBedno').val(data.bedno)
                }
            })
        }
    </script>
</body>

</html>