<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome - Hospital Management System</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar2.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5>Create an Appointment</h5>
                        <!--card stats start-->
                        <div id="card-stats mt-5 p-3" class="pt-0">
                            <div class="row container mt-5">
                                <div class="col s6">
                                    <label>Name: </label>
                                    <input type="text" name="name" id="txtName" />
                                </div>
                                <div class="col s6">
                                    <label>Age: </label>
                                    <input type="number" name="age" id="txtAge" />
                                </div>
                            </div>
                            <div class="row container">
                                <div class="col s6">
                                    <label>Contact Info: </label>
                                    <input type="text" name="contact_info" id="txtContactInfo" />
                                </div>
                                <div class="col s6">
                                    <label>CNIC: </label>
                                    <input type="text" name="cnic" id="txtCNIC" />
                                </div>
                                <div class="col s6">
                                    <label>Select Time:</label>
                                    <input type="time" name="time" id="txtTime" />
                                </div>
                                <div class="col s6">
                                    <label>Date: </label>
                                    <input type="date" name="date" id="txtDate" />
                                </div>
                                <div class="col s12">
                                    <label>Select Doctor:</label>
                                    <select name="doctor" id="slctDoctor">
                                        <option value="--">-- Select Doctor --</option>
                                        <?php

                                        $query = mysqli_query(mysqli_connect("localhost","root","","hospital"),"SELECT staff.emp_code,staff.name,schedules.starting_time,schedules.ending_time,doctor.specialization FROM staff LEFT JOIN schedules ON staff.emp_code=schedules.emp_code INNER JOIN doctor ON schedules.emp_code=doctor.emp_code;");

                                        while($row = mysqli_fetch_assoc($query))
                                        {
                                            echo "<option value='".$row['emp_code']."'>".$row['name']." (".$row['specialization'].")</option>";
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                            </div><br><br>
                            <div class="row container">
                                <div class="col s6">
                                    <button class="btn green accent-3" onclick="CreateAppointment()">Create Appointment</button>
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

    <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#txtContactInfo').formatter({
                'pattern': '03{{99}}-{{9999999}}',
                'persistent':true
            })

            $('#txtCNIC').formatter({
                'pattern': '{{99999}}-{{9999999}}-{{9}}',
                'persistent':true
            })
        })

        function CreateAppointment()
        {
            if($('#txtName').val()=='')
            {
                swal('Error','Name is Required..','warning')
            }

            else if($('#txtAge').val()=='')
            {
                swal('Error','Age is Required..','warning')
            }

            else if($('#txtContactInfo').val()=='')
            {
                swal('Error','Contact Info is Required..','warning')
            }
            
            else if($('#txtCNIC').val()=='')
            {
                swal('Error','CNIC is Required..','warning')
            }

            else if($('#txtCNIC').val().length<15)
            {
                swal('Warning','Invalid CNIC Format..','warning')
            }

            else if($('#txtContactInfo').val().length<12)
            {
                swal('Warning','Invalid Contact Number Format..','warning')
            }

            else if($('#txtTime').val()=='')
            {
                swal('Error','Please Select The Time','warning')
            }

            else if($('#txtDate').val()=='')
            {
                swal('Error','Date is Required Field..','warning')
            }

            else if($('#slctDoctor').val()=='')
            {
                swal('Error','Please Select The Doctor..','warning')
            }

            else
            {
                $.ajax({
                    url:"../ajax/Appointment/?case=CreateAppointment",
                    type:"GET",
                    data:{
                        name:$('#txtName').val(),
                        age:$('#txtAge').val(),
                        contactinfo:$('#txtContactInfo').val(),
                        cnic:$('#txtCNIC').val(),
                        time:$('#txtTime').val(),
                        date:$('#txtDate').val(),
                        doctor:$('#slctDoctor').val()
                    },
                    success:function(resp)
                    {
                        console.log(resp)
                        if(resp==1)
                        {
                            swal('Success','Appointment Submitted Successfully.\n Please Wait For The Approval.','success')
                        }

                        if(resp==12)
                        {
                            swal('WARNING','Un-Authorized Name or ContactInfo Against CNIC','warning')
                        }
                    }
                })
            }
        }
    </script>
</body>

</html>