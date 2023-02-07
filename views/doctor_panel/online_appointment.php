<?php

session_start();

if (isset($_SESSION['email']) == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
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
                        <h5>Manage Your Appointments</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Patient Name</th>
                                                <th>Age</th>
                                                <th>Contact Info</th>
                                                <th>CNIC</th>
                                                <th>App: Time</th>
                                                <th>App: Date</th>
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
            $.ajax({
                url: "../ajax/Appointment/?case=FetchPatients",
                success: function(resp) {
                    if (resp != null) {
                        $('tbody').html('')
                        $('tbody').append(resp)
                        $('table').DataTable()
                    }
                }
            })
        })

        function Approve(id) {
            swal({
                title: "Sure To Approve?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No',
                    delete: 'Yes'
                }
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url:"../ajax/Appointment?case=ApproveAppointment",
                        type:"GET",
                        data:{
                            id:id.id
                        },
                        success:function(resp)
                        {
                            if(resp==1)
                            {
                                swal("Appointment Approved", {
                                    icon: "success",
                                });

                                setTimeout(() => {
                                    window.location.reload()
                                }, 2000);
                            }
                        }
                    })
                } else {
                    swal("No Changes Applied", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                }
            });
        }

        function Reject(id) {
            swal({
                title: "Sure To Reject?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'No',
                    delete: 'Yes'
                }
            }).then(function(willDelete) {
                if (willDelete) {

                    $.ajax({
                        url:"../ajax/Appointment?case=RejectAppointment",
                        type:"GET",
                        data:{
                            id:id.id
                        },
                        success:function(resp)
                        {
                            swal("Appointment Rejected!!", {
                                icon: "success",
                            });
                        }
                    })

                } else {
                    swal("No Changes Applied", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                }
            });
        }
    </script>
</body>
</html>