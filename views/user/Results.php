<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Patients Test Results </title>
    <?php $test_name = array(); ?>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/userbar.php'; ?>
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5>Results Management Panel</h5>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row mt-4 input-field">
                                    <?php require_once '../connection/connection.php'; ?>
                                    <div class="col s3">MR#</div>
                                    <div class="col s9"><span id="lblMR"><?php echo $_GET['mr']; ?></span></div>
                                    <br><br>
                                    <div class="col s3">Name: </div>
                                    <div class="col s9"><?php $name = mysqli_query($con, "select distinct name from lab_test where mrno='" . $_GET['mr'] . "';");
                                                        $get = mysqli_fetch_assoc($name);
                                                        echo $get['name']; ?></div>
                                    <?php

                                    $q = mysqli_query($con, "select * from lab_test where mrno='" . $_GET['mr'] . "';");

                                    if (mysqli_num_rows($q) > 0) {
                                        while ($data = mysqli_fetch_assoc($q)) {
                                            array_push($test_name, $data['id']);
                                            echo "<div class='col s12'>
                                        <div class='file-field input-field'>
      <div class='btn'>
        <span>" . $data['lab_test'] . "</span>
        <input type='file' name='" . $data['id'] . "' required id='" . $data['id'] . "' />
      </div>
      <div class='file-path-wrapper'>
        <input class='file-path validate' value='".$data['results']."' type='text' />
      </div>
    </div>
                                        </div>";
                                        }
                                    } else {
                                        echo "<script>window.location.href='PatientTest.php'</script>";
                                    }

                                    ?>

                                    <div class="col s5">
                                        <input class="btn blue" type="submit" name="btnUpload" />
                                    </div>
                            </form>
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

if (isset($_REQUEST['btnUpload'])) {
    for ($i = 0; $i < count($test_name); $i++) {
        $file_type = $_FILES[$test_name[$i]]['type'];
        $extension = pathinfo($_FILES[$test_name[$i]]['name'], PATHINFO_EXTENSION);
        $valid_extension = array('pdf', 'doc', 'docx', 'xlsx', 'xlx');

        if (in_array($extension, $valid_extension)) {
            $new_name = uniqid() . '.' . $extension;
            $test_file_directory = '../test_files/';
            move_uploaded_file($_FILES[$test_name[$i]]['tmp_name'], $test_file_directory . $new_name);

            $index = $i + 1;
            $query = mysqli_query($con, "update lab_test set results='" . $new_name . "' where id=" . ($index) . ";");

            if ($query) {
                echo '<script>swal("Success","Lab Test Record Submitted Successfully..","success")</script>';
            } else {
                echo '<script>swal("Sorry","' . mysqli_errno($con) . '","error")</script>';
            }
        } else {
            echo '<script>swal("Warning","Invalid File Format. Only PDF,DOC,DOCX,XLSX Format File Allowed..","info")</script>';
        }
    }
}

?>