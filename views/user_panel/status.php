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

    <!-- BEGIN: SideNav-->
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
                            <h5>Appointment Tracking Appointments</h5>
                            <div class="row mt-5">
                                <div class="col s7">
                                    <input type="text" name="cnic" placeholder="Enter CNIC" id="txtCNIC" />
                                </div>
                                <div class="col s2">
                                    <button class="btn green" onclick="GenerateAppointments()">Submit</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12" id="rowData">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>CNIC</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Doctor</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
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

 <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function()
        {
           
        })

        function GenerateAppointments()
        {
            if($('#txtCNIC').val()=='')
            {
                swal('Error','CNIC is Required..','warning')
            }

            else if($('#txtCNIC').val().length<15)
            {
                swal('Error','CNIC is Invalid..','warning')
            }

            else
            {
                $.ajax({
                    url:"../ajax/Appointment/?case=GetAppointments",
                    type:"GET",
                    data:{
                        cnic:$('#txtCNIC').val()
                    },
                    success:function(resp)
                    {
                        if(resp==0)
                        {
                            swal('Sorry','No Appointments Found','info')
                            $('table').hide()
                        }

                        else
                        {
                            $('tbody').append(resp)
                            $('table').show()
                            $('table').DataTable()
                        }
                    }
                })
            }
        } 

        function DeleteAppointment(e)
        {
            $.ajax({
                url:"../ajax/Appointment/?case=Delete",
                type:"GET",
                data:{
                    id:e.id
                },
                success:function(resp)
                {
                    if(resp==1)
                    {
                        swal('success','Appointment Deleted Successfully..','success')
                        setTimeout(() => {
                                window.location.reload()
                        }, 1500);
                    }
                }
            })
        }
    </script>
</body>
</html>