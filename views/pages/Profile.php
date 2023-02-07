<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    require_once '../connection/connection.php';

    $get_code_query = mysqli_query($con, "select emp_code as Data from staff where email='" . $_SESSION['email'] . "';");
    $code = mysqli_fetch_assoc($get_code_query);

    if($code['Data']==null)
    {
        echo '<script>window.location.href="../login.php"</script>';
    }

    else
    {
        $data_query = mysqli_query($con,"select * from staff inner join staff_roles on staff.emp_code=staff_roles.emp_code where staff.emp_code='".$code['Data']."';");
        $user_data = mysqli_fetch_assoc($data_query);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <?php include_once '../include/style.php'; ?>
</head>

<body>
    <?php include_once '../include/header.php';

    if ($code['Data'] == 'E-1') {
        include_once '../include/sidebar.php';
    } else {
        include_once '../include/userbar.php';
    }

    ?>

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <h5>User Profile</h5>
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">


                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s12">
                                            <ul class="tabs">
                                                <li class="tab col m4"><a href="#test1">Personal Information</a></li>
                                                <li class="tab col m4"><a href="#test2">Roles Assigned</a></li>
                                            </ul>
                                        </div>
                                        <div id="test1" class="col s12 container">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Employee Code</th>
                                                        <td><?php echo $code['Data']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <td><?php echo $user_data['name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Father Name</th>
                                                        <td><?php echo $user_data['fname']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Age</th>
                                                        <td><?php echo $user_data['age']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Gender</th>
                                                        <td><?php echo $user_data['gender']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email Address:</th>
                                                        <td><?php echo $user_data['email']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Info: </th>
                                                        <td><?php echo $user_data['contactinfo']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Employee CNIC: </th>
                                                        <td><?php echo $user_data['cnic']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Complete Address: </th>
                                                        <td><?php echo $user_data['address']; ?></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div id="test2" class="col s12 container">
                                              <table>
                                                <thead>
                                                    <tr>
                                                        <th>Department: </th>
                                                        <td><?php echo $user_data['department']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Designation: </th>
                                                        <td><?php echo $user_data['designation']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ward</th>
                                                        <td><?php echo $user_data['ward']; ?></td>
                                                    </tr>
                                                </thead>
                                              </table>
                                        </div>
                                        <div id="test3" class="col s12 container">

                                        </div>
                                        <div id="test4" class="col s12 container">

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