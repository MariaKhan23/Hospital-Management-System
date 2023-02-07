<?php

session_start();

include_once '../connection/connection.php';

if($_SESSION['email']==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

else
{
    if (isset($_GET['mr'])) {
        $uery = mysqli_query($con, "select * from patient where mrno='" . $_GET['mr'] . "';");
        $patient_data = mysqli_fetch_assoc($uery);
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Patient Registration Management</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <?php include_once '../include/userbar.php'; ?>
    <!-- END: SideNav-->

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">

                    </div>
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col m4"><a class="active" href="#test1">Patient Registration</a></li>
                                <li class="tab col m4"><a href="#test2">Approved Appointments</a></li>
                                <li class="tab col m4"><a href="#test4">Pending Appointments</a></li>
                            </ul>
                        </div>
                        <div id="test1" class="col s12">
                            <div id="card-stats" class="pt-0">
                                <h5 class="p-2">Patient Registration </h5>
                                <!--card stats start-->
                                <div id="card-stats" class="pt-0">
                                    <div class="row p-1">
                                        <div class="col s6">
                                            <input type="text" value="<?php if (isset($patient_data)) {
                                                                            echo $patient_data['name'];
                                                                        } ?>" placeholder="Patient Name" name="name" id="txtPatientName">
                                        </div>
                                        <div class="col s2">
                                            <input type="number" value="<?php if (isset($patient_data)) {
                                                                            echo $patient_data['age'];
                                                                        } ?>" placeholder="Patient Age" name="age" id="txtPatientAge">
                                        </div>
                                        <div class="col s4">
                                            <select name="gender" id="slctGender">
                                                <option <?php if (isset($patient_data) && $patient_data['gender'] == 'Male') {
                                                            echo 'selected';
                                                        } ?> value="Male">Male</option>
                                                <option <?php if (isset($patient_data) && $patient_data['gender'] == 'Female') {
                                                            echo 'selected';
                                                        } ?> value="Female">Female</option>
                                            </select>
                                        </div>
                                        <br><br><br>
                                        <div class="col s3">
                                            <input type="number" value="<?php if (isset($patient_data)) {
                                                                            echo $patient_data['contactinfo'];
                                                                        } ?>" placeholder="Patient Contact No." name="contact" id="txtContactInfo">
                                        </div>
                                        <div class="col s3">
                                            <input type="number" value="<?php if (isset($patient_data)) {
                                                                            echo $patient_data['cnic'];
                                                                        } ?>" placeholder="Patient CNIC" name="cnic" id="txtCNIC">
                                        </div>
                                        <br><br><br>

                                        <div class="col s12">
                                            <select id="slctDoctor">
                                                <option value="" selcted>-- Select Doctor To Consult --</option>
                                                <?php

                                                require_once '../connection/connection.php';
                                                $doctor_query = mysqli_query($con, "select emp_code,name,specialization from doctor;");

                                                while ($row = mysqli_fetch_assoc($doctor_query)) {
                                                    echo "<option value='" . $row['emp_code'] . "'>[" . $row['emp_code'] . "] " . $row['name'] . " (" . $row['specialization'] . ")</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                        <div class="col s5">
                                            <button class="btn green" id="btnSubmit">Save</button>
                                            <a href="ListPatients.php" class="btn red">Cancel</a> <br> <br>
                                            <a onclick="GenerateSchedule()" href="#modalSchedule" class="btn cyan modal-trigger">Show Doctors Schedule</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="modalSchedule">
                                <div class="modal-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Doctor Name</th>
                                                <th>Employee Code</th>
                                                <th>Speciaization In</th>
                                                <th>From</th>
                                                <th>To</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="test2" class="col s12">
                            <div class="container p-2">
                                <h5>Approved Appointments</h5>
                                <table id="tblApproved">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Contact Info</th>
                                            <th>CNIC</th>
                                            <th>Consulting To</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="test4" class="col s12">
                            <div class="p-1">
                                <h5>Pending Appointments</h5>
                                <table id="tblPending">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Contact Info</th>
                                            <th>CNIC</th>
                                            <th>Consulting To</th>
                                            <th>Date</th>
                                            <th>Time</th>
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
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalPending">
        <div class="modal-content">
            <ul id="doc"></ul>
            <button class="btn blue" onclick="RegisterNewPatient()">Print Reciept</button>
        </div>
    </div>

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <script>
        const params = new URLSearchParams(window.location.search)
        if (params.has('mr')) {
            $('#btnSubmit').click(function() {
                if ($('#txtPatientName').val() == '' || $('#txtPatientAge').val() == '') {
                    swal('Warning', 'All Fields Are Required..', 'warning')
                } else if ($('#txtContactInfo').val() == '' && $('#txtCNIC').val() == '') {
                    swal('Warning', 'Patient Contact Info or CNIC, Any One of Them is Required.', 'warning')
                } else {
                    $.ajax({
                        url: "../ajax/patient?case=UpdatePatient",
                        type: "GET",
                        data: {
                            name: $('#txtPatientName').val(),
                            age: $('#txtPatientAge').val(),
                            contactinfo: $('#txtContactInfo').val(),
                            cnic: $('#txtCNIC').val(),
                            gender: $('#slctGender').val(),
                            doctor: $('#slctDoctor').val(),
                            mrno: params.get('mr')
                        },
                        success: function(resp) {
                            console.log(resp)
                            if (resp == 1) {
                                swal('Success', "Patient Detail's Updated Succesfully..", 'success')
                                window.location.href='../pages/Reciept.php?mr='+params.get('mr')
                            }
                        }
                    })
                }
            })
        } else {
            $('#btnSubmit').click(function() {
                if ($('#txtPatientName').val() == '' || $('#txtPatientAge').val() == '') {
                    swal('Warning', 'All Fields Are Required..', 'warning')
                } else if ($('#txtContactInfo').val() == '' && $('#txtCNIC').val() == '') {
                    swal('Warning', 'Patient Contact Info or CNIC, Any One of Them is Required.', 'warning')
                } else {
                    $.ajax({
                        url: "../ajax/patient?case=RegisterPatient",
                        type: "GET",
                        data: {
                            name: $('#txtPatientName').val(),
                            age: $('#txtPatientAge').val(),
                            doctor: $('#slctDoctor').val(),
                            contactinfo: $('#txtContactInfo').val(),
                            cnic: $('#txtCNIC').val(),
                            gender: $('#slctGender').val()
                        },
                        success: function(resp) {
                            swal('Success', 'Patient Registered Succesfully..', 'success')
                            window.location.href="../pages/Reciept.php?mr="+resp
                        }
                    })
                }
            })
        }

        function GenerateSchedule() {
            $.ajax({
                url: "../ajax/Schedule?case=ShowDoctors",
                success: function(resp) {
                    console.clear()
                    console.log(resp)
                    $('tbody').html('')
                    $('tbody').append(resp)
                    $('table').dataTable()
                }
            })
        }

        $(document).ready(function() {
            $.ajax({
                url: "../ajax/patient?case=GetApprovedAppointments",
                success: function(resp) {
                    console.log('1' + resp)
                    if (resp != null) {
                        $('#tblApproved').find('tbody').html('')
                        $('#tblApproved').find('tbody').append(resp)
                        $('#tblApproved').DataTable()
                    }
                }
            })

            $.ajax({
                url: "../ajax/patient?case=GetPendingAppointments",
                success: function(resp) {
                    console.log('2' + resp)
                    if (resp != null) {
                        $('#tblPending').find('tbody').html('')
                        $('#tblPending').find('tbody').append(resp)
                        $('#tblPending').DataTable()
                    }
                }
            })
        })

        let resp,namee,age,contact,cnic;

        function ManagePendingAppointment(e) {
            $.ajax({
                url: "../ajax/Schedule?case=ShowDoctorss",
                success: function(data) {
                    console.log(data)
                   resp = $.parseJSON(data)
                   $('#doc').html('')
                  $('#doc').append('<li>'+resp.name+' ['+resp.specialization+'] ('+resp.emp_code+') <p style="display:inline;"><label><input type="radio" class="with-ga float-right" id="'+resp.emp_code+'" onclick="GiveDoctor(this)" /><span>Select Doctor</span></label></p></li><br />')
                }
            })

            var parent = e.parentNode.parentNode
            namee = (parent.childNodes[1])
            age = (parent.childNodes[3])
            contact = parent.childNodes[5]
            cnic = parent.childNodes[7]
        }

        let doc_id;

        function GiveDoctor(e)
        {
            doc_id = e.id
            return (e.id)
        }

        function RegisterNewPatient()
        {
            if(doc_id==null)
            {
                swal('Error','Select Doctor To Consult..','warning')
            }

            else
            {
                var patient_name = namee
                console.clear()
                console.log(patient_name.innerHTML,contact.innerHTML,age.innerHTML,cnic.innerHTML,resp.id,doc_id)
                // alert(34)
                $.ajax({
                    url:"../ajax/patient/?case=RegisterNew",
                    type:"GET",
                    data:{
                        age:age.innerHTML,
                        name:namee.innerHTML,
                        contactinfo:contact.innerHTML,
                        cnic:cnic.innerHTML,
                        doctor:doc_id
                    },
                    success:function(resp)
                    {
                        console.log(resp)
                        swal('Success','Patient Registered Successfully..','success')
    
                        setTimeout(() => {
                                window.location.reload()
                        }, 20000);
                    }
                })
            }

        }

        function RegisterOnlinePatient(e)
        {
            name = e.parentNode.parentNode.childNodes[1].innerHTML
            $('#txtPatientName').val(name)
        }

    </script>
</body>
</html>