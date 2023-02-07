<?php

session_start();


if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

if(isset($_GET['id']))
{
    require_once '../connection/connection.php';
    $query = mysqli_query($con,"select * from staff where id=".$_GET['id'].";");
    if(mysqli_num_rows($query)!=1)
    {
        header("location:ListStaffs.php");
    }

    else
    {
        $emp_data = mysqli_fetch_assoc($query);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Hospital Staff</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
   <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->
    
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>

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
                        <h5 class="p-2">Register Staff</h5>
                            <form id="frmStaff">
                            <div class="row">
                                <div class="col s6 container">
                               <input type="text" value="<?php if(isset($emp_data))
                               { echo $emp_data['name']; } ?>" name="name" placeholder="Name" id="txtStaffName">
                                </div>
                                <div class="col s6">
                                    <input type="text" value="<?php if(isset($emp_data))
                               { echo $emp_data['fname']; } ?>" placeholder="Father Name" name="fname" id="txtStaffFatherName">
                                </div>
                                <div class="col mt-2 s6">
                                <input type="number" value="<?php if(isset($emp_data))
                               { echo $emp_data['age']; } ?>" placeholder="Staff Age" name="age" id="txtStaffAge">
                                </div>
                                <div class="col mt-2 s6">
                                  <input type="email" value="<?php if(isset($emp_data))
                               { echo $emp_data['email']; } ?>" name="email" placeholder="Email Address" id="txtStaffEmail">
                                </div>
                                <div class="col mt-2 s6">
                                    <input type="number" value="<?php if(isset($emp_data))
                               { echo $emp_data['contactinfo']; } ?>" name="contactinfo" placeholder="Contact Info" id="txtStaffContactInfo">
                                </div>
                                <div class="col mt-2 s6">
                                    <input type="number" value="<?php if(isset($emp_data))
                               { echo $emp_data['cnic']; } ?>" name="cnic" placeholder="CNIC No." id="txtStaffCNIC">
                                </div>
                                <div class="col mt-2 s6">
                                    <select name="status" id="txtStatus">
                                        <option  <?php if(isset($emp_data)){
                                            if($emp_data['gender']=='Male')
                                            {
                                            echo 'selected';
                                            }
                                        } ?> value="1">Active</option>
                                        <option  <?php if(isset($emp_data)){
                                            if($emp_data['gender']=='Female')
                                            {
                                            echo 'selected';
                                            }
                                        } ?> value="0">Inactive</option>
                                    </select>
                                    <input type="hidden" name="uid" id="txtID">
                                </div>
                                <div class="col mt-2 s6">
                                    <select name="gender" id="txtGender">
                                        <option <?php if(isset($emp_data)){
                                            if($emp_data['stats']==1)
                                            {
                                            echo 'selected';
                                            }
                                        } ?> value="Male">Male</option>
                                        <option  <?php if(isset($emp_data)){
                                            if($emp_data['stats']==0)
                                            {
                                            echo 'selected';
                                            }
                                        } ?> value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col mt-2 s12">
                                    <input type="text" value="<?php if(isset($emp_data))
                               { echo $emp_data['address']; } ?>" name="address" placeholder="Permenant Address" id="txtAddress">
                                </div>
                                <div class="col mt-2 s12">
                                    <button onclick="SubmitData()" type="button" class="btn green">Submit</button>
                                    <a href="ListStaffs.php" class="btn red">Cancel</a>
                                </div>
                            </div>
                            </form>
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
    
    $(document).ready(function()
    {
        $('#txtStaffContactInfo').formatter({
            'pattern':'{{9999}}-{{9999999}}'
        })  

        $('#txtStaffCNIC').formatter({
            'pattern':'{{99999}}-{{9999999}}-{{9}}'
        })
    })

    function SubmitData()
    {
        const params = new URLSearchParams(window.location.search)

        if($('#txtStaffName').val()=='' || $('#txtStaffFatherName').val()=='' || $('#txtStaffAge').val()==''|| $('#txtStaffEmail').val()==''||$('#txtStaffContactInfo').val()==''||$('#txtStaffCNIC').val()=='')
        {
        swal('Warning','All Fields Are Required..','warning')
        }

        else
        {
            if(!params.has('id'))
        {
            //Insert Statement
            $.ajax({
                url:"../ajax/Staff?case=RegisterStaff",
                type:"GET",
                data:$('#frmStaff').serialize(),
                success:function(resp)
                {
                    console.clear()
                    console.log(resp)
                    if(resp==1)
                    {
                        swal({
                            title:"Success",
                            text:"Staff Registered Successfully..",
                            icon:"success",
                            timer:3000
                        })
                    }
                }
            })
        }

        else
        {
            $.ajax({
                url:"../ajax/Staff?case=UpdateStaff",
                type:"GET",
                data:{
                    name:$('#txtStaffName').val(),
                    fname:$('#txtStaffFatherName').val(),
                    age:$('#txtStaffAge').val(),
                    gender:$('#txtGender').val(),
                    address:$('#txtAddress').val(),
                    contactinfo:$('#txtStaffContactInfo').val(),
                    cnic:$('#txtStaffCNIC').val(),
                    email:$('#txtStaffEmail').val(),
                    status:$('#txtStatus').val(),
                    id:params.get('id')  
                },
                success:function(resp)
                {
                    console.clear()
                    console.log(resp)
                    if(resp==1)
                    {
                        swal({
                            title:"Success",
                            text:"Staff Details Updated Successfully..",
                            icon:"success",
                            timer:3000
                        })
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