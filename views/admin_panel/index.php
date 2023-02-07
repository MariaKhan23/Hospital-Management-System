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
    <title>Welcome - Hospital Management System (Admin Panel)</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar.php'; ?>

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12 m6 l6 xl3">
                                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-symbols-outlined ml-5 background-round mt-5">outpatient</i>
                                                    <p>Out Patients</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">
                                                        <?php

                                                        echo GetCount('patient');

                                                        ?>
                                                    </h5>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-symbols-outlined background-round mt-5">inpatient</i>
                                                    <p>In Patients</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">
                                                        <?php echo GetCount('patient_recieving'); ?>
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-symbols-outlined background-round mt-5">add_home_work</i>
                                                    <p>Departments</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">
                                                        <?php echo GetCount('department'); ?>
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="card gradient-45deg-purple-deep-purple
 gradient-shadow min-height-100 white-text animate fadeRight">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-symbols-outlined background-round mt-5">home_health</i>
                                                    <p>Wards</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">
                                                        <?php echo GetCount('ward'); ?>
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-symbols-outlined background-round mt-5">person_filled</i>
                                                    <p>Employees</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">
                                                        <?php echo GetCount('staff'); ?>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
</body>
</html>

<?php

function GetCount($table)
{
    $con = mysqli_connect("localhost", "root", "", "hospital");

    $query = mysqli_query($con, "select count(*) as MyTotal from " . $table . ";");

    $total_count = mysqli_fetch_assoc($query);

    return $total_count['MyTotal'];
}

?>