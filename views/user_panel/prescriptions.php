<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prescriptions</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <?php include_once '../include/sidebar2.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <h5>Prescriptions Panel</h5>
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s2 mt-3">
                                    <span>Enter Your MRNO: </span>
                                </div>
                                <div class="col s6">
                                    <form method="POST">
                                    <input type="text" placeholder="MR-XXXXXXXXXXXXXXXXX" name="mrno" required id="txtmr" />
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <input type="submit" value="Generate Results" name="btn" class="btn" />
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
                <table class="container">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Schedule</th>
                            <th>Follow Up Days</th>
                            <th>Suggested By</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

 <?php include_once '../include/scripts.php'; ?>
 <?php echo '<script>$("table").hide()</script>'; ?>
</body>
<?php 

if(isset($_REQUEST['btn']))
{
    require_once '../connection/connection.php';

    if($_REQUEST['mrno']=='')
    {
        echo '<script>swal("Error","Patient MR is Required..","info")</script>';
    }
    
    else
    {
        $query = mysqli_query($con,"select *,doctor.name,doctor.specialization from prescriptions left join doctor on prescriptions.doctor=doctor.emp_code where prescriptions.mrno='".strtoupper($_REQUEST['mrno'])."';");

        $str = '';

        if(mysqli_num_rows($query)>0)
        {
            while($row = mysqli_fetch_assoc($query))
            {
                $str .= '<tr><td>'.$row['item'].'</td><td>'.$row['med_time'].'</td><td>'.$row['days'].'</td><td>DR- '.$row['name'].' ('.$row['specialization'].')</td></tr>';
            }

            echo "<script>$('tbody').append('".$str."') </script>";
            echo '<script>$("table").show()</script>';
        }

        else
        {
            echo '<script>swal("Sorry.","No Records Found.","error")</script>';
        }

    }
}

?>
</html>