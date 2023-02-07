<?php

require_once '../connection/connection.php';

if(isset($_GET['id']))
{
    $query = mysqli_query($con,"select * from department where id=".$_GET['id'].";");

    if(mysqli_num_rows($query)>0)
    {
        $data = mysqli_fetch_assoc($query);
    }

    else
    {
        echo '<script>window.history.back()</script>';
    }

}

session_start();


if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include_once '../include/style.php'; ?>
</head>
<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
   <?php include_once '../include/header.php'; ?>

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/userbar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5 class="p-2">Departments</h5>
                            <div class="row">
                                <div class="col s6 p-4">
                            <div class="container">
                                <input placeholder="Enter Department Name" value="<?php
                                if(isset($data))
                                {
                                    echo $data['name'];
                                }
                                ?>" type="text" id="txtName">
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="container">
                                <input type="text" value="<?php
                                if(isset($data))
                                {
                                    echo $data['description'];
                                }
                                ?>" name="detail" placeholder="Enter Description" id="txtDetails">
                                  </div>
                                </div>
                                <div class="col s6 container">
                                    <button onclick="SubmitData()" class="btn green mt-3">Submit</button>
                                    <a href="ListDepartments.php" class="btn mt-3 red">Cancel</a>
                                </div>
                                <div class="col s2 container">
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
            
            <!-- BEGIN: Footer-->
            
            <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
                <div class="footer-copyright">
                    </div>
                </footer>
                
                <?php include_once '../include/scripts.php'; ?>
                <script>
                    const params = new URLSearchParams(window.location.search)
function SubmitData()
                    {
                        if($('#txtName').val()=='')
                        {
                            swal('Error','Name is Required','error')
                        }

                        else
                        {
                                    if(!params.has('id'))
                                    {
                                        $.ajax({
                                url:"../ajax/Department?case=RegisterDepartment",
                                type:"GET",
                                data:{
                                    name:$('#txtName').val(),
                                    details:$('#txtDetails').val()
                                },
                                success:function(resp)
                                {
                                    console.clear()
                                    console.log(resp)
                                    if(resp==1)
                                    {
                                        swal('Success','Department Registered Successfully..','success')
                                        $('#txtName').val('')
                                        $('#txtDetails').val('')
                                    }
                                }
                            })
                       }

                       else
                       {
                        $.ajax({
                            url:"../ajax/Department?case=UpdateDepartment",
                            type:"GET",
                            data:{
                                name:$('#txtName').val(),
                                details:$('#txtDetails').val(),
                                id:params.get('id')
                            },
                            success:function(resp)
                            {
                                if(resp==1)
                                {
                                    swal('Success','Department Updated Successfully..','info')
                                        $('#txtName').val('')
                                        $('#txtDetails').val('')
                                }
                            }
                        })
                       }
                    }
                }
                </script>
                <!-- END PAGE LEVEL JS-->
            </body>
            </html>
            <!-- END: Head-->
