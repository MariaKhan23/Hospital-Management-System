<?php

require_once '../connection/connection.php';

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    $doctor_data = mysqli_query($con, "SELECT * FROM staff left join doctor on staff.emp_code=doctor.emp_code WHERE staff.email='" . $_SESSION['email'] . "' or cnic='" . $_SESSION['email'] . "';");
    $doctor_details = mysqli_fetch_assoc($doctor_data);
   // print_r($doctor_details);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Profile Management Panel</title>
    <?php include_once '../include/style.php'; ?>
    <style>
        .abc
        {
            overflow:hidden;
        }
    </style>
</head>
<!-- END: Head-->

<body class="vertical-layout abc page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

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
                    <h5>Manage Your Profile</h5>
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s3 ">
                                    <span>Employee ID: </span>
                                </div>
                                <div class="col s1 ">
                                    <span id="lblID"><?php echo $doctor_details['emp_code'] ?> </span>
                                </div>
                                <br><br>
                                <div class="col   s3 ">
                                    <span>Name: </span>
                                </div>
                                <div class="col s2">
                                    <span id="lblName">
                                        <?php echo $doctor_details['name'] ?>
                                    </span>
                                </div>
                                <br> <br>
                                <div class="col   s3">
                                    <span>Age: </span>
                                </div>
                                <div class="col s2">
                                    <?php echo $doctor_details['age'] ?>
                                </div>
                                <br> <br>
                                <div class="col   s3 ">
                                    <span>Gender: </span>
                                </div>
                                <div class="col s2">
                                    <?php echo $doctor_details['gender'] ?>
                                </div>
                                <br> <br>
                                <div class="col   s3 ">
                                    <span>Contact Info: </span>
                                </div>
                                <div class="col s3">
                                    <?php echo $doctor_details['contactinfo'] ?>
                                </div>
                                <br> <br>
                                <div class="col   s3 ">
                                    <span>CNIC No: </span>
                                </div>
                                <div class="col s4"><?php echo $doctor_details['cnic'] ?></div>
                            <br> <br>
                                <div class="col   s3 ">
                                    <span>Registered At: </span>
                                </div>
                                <div class="col s3">
                                    <?php echo $doctor_details['created_at'] ?? "----" ?>
                                </div>
                                <br> <br>
                                <div class="col   s3 ">
                                    <span>Select Specialization: </span>
                                </div>
                                <div class="col s6">
                                    <select name="specialist" id="slctSpecialization">
                                        <option  value="" selected>-- Select Specialization --</option>
                                        <option <?php if($doctor_details['specialization']=='Cardiologist') echo 'selected';  ?> value="Cardiologist">Cardiologist</option>
                                        <option <?php if($doctor_details['specialization']=='Dermatologist') echo 'selected';  ?> value="Dermatologist">Dermatologist</option>
                                        <option <?php if($doctor_details['specialization']=='Nephrologist') echo 'selected';  ?> value="Nephrologist">Nephrologist</option>
                                        <option <?php if($doctor_details['specialization']=='Nuerologist') echo 'selected';  ?> value="Nuerologist">Nuerologist</option>
                                        <option <?php if($doctor_details['specialization']=='Ortho') echo 'selected';  ?> value="Ortho">Ortho</option>
                                    </select>
                                </div>
                                <div class="col s2">
                                    <button id="btnSubmit" type="button" class="btn cyan">Save</button>
                                </div>
                                <br> <br>
                                <div class="col   s12 ">
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Specialization</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>

    <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function() {

            GetSpecialization()

            $('#btnSubmit').click(function() {
                if ($('#slctSpecialization').val() == '') {
                        swal('Warning','Please Select Your Specialization First..','warning')
                } else {

                    $.ajax({
                        url: "../ajax/Staff?case=SetDoctor",
                        type: "GET",
                        data: {
                            name: $.trim($('#lblName').html()),
                            code: $('#lblID').html(),
                            specialization: $('#slctSpecialization').val()
                        },
                        success: function(resp) {
                            if (resp == 1) {
                                $('tbody').html('')
                                $('tbody').append('<th>' + $('#lblID').html() + '</th><th>' + $('#slctSpecialization').val() + '</th>')
                                $('#data').html($('#slctSpecialization').val())
                                swal('Success', 'Your Specialization Has Been Created', 'success')
                            } else {
                                alert('An Error Occured While Processing The Data..')
                            }
                        }
                    })
                }
            })
        })

        function GetSpecialization()
        {
            $.ajax({
                url:"../ajax/Doctor/?case=GetSpecialization",
                type:"GET",
                data:{
                    code:$('#lblID').html()
                },
                success:function(resp)
                {
                    if(resp!=null)
                    {
                        $('tbody').append(resp)
                    }
                }
            })
        }
    </script>
    <!-- END PAGE LEVEL JS-->
</body>

</html>
}