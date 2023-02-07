<?php

session_start();

require_once '../connection/connection.php';

if($_SESSION['email']==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

if(isset($_GET['id']))
{
    $query = mysqli_query($con,"select * from items where id=".$_GET['id'].";");
    if(mysqli_num_rows($query)==0)
    {
        echo '<script>window.history.back()</script>';
    }

    else
    {
        $data = mysqli_fetch_assoc($query);
    }
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
    <!-- END: Header-->
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>



    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <h5 class="p-2">Pharmacy Items</h5>
                            <div class="row p-1">
                                <div class="col s6 p-4">
                            <div class="container">
                                <input placeholder="Enter Item Name" value="<?php
                                if(isset($data))
                                {
                                    echo $data['name'];
                                }
                                ?>" type="text" id="txtName">
                            </div>
                        </div>
                        <div class="col s6">
                                <select name="generic" id="txtGeneric">
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Medical')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?> value="Medical">Medical </option>
                                    <option  <?php if(isset($data)){
                                        if($data['generic']=='Surgical Item')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?> value="Surgical Item">Surgical Item</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Tablet')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Tablet">Tablet</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Cream')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Cream">Cream</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Syrup')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Syrup">Syrup</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Drops')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Drops">Drops</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Injection')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Injection">Injection</option>
                                    <option <?php if(isset($data)){
                                        if($data['generic']=='Gel')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?>  value="Gel">Gel</option>
                                    <option  <?php if(isset($data)){
                                        if($data['generic']=='Miscellaneous')
                                        {
                                            echo 'Selected';
                                        }
                                    } ?> value="Miscellaneous">Miscellaneous</option>
                                </select>
                            </div>
                            <br><br><br> <br>
                            <div class="col s3">
                                <input type="text" value="<?php
                                if(isset($data))
                                {
                                    echo $data['strength'];
                                }
                                ?>" placeholder="Enter Medicine Strength With Unit." name="strength" id="txtStrength">
                            </div>
                            <div class="col s3">
                                <input type="number" value="<?php
                                if(isset($data))
                                {
                                    echo $data['unit_price'];
                                }
                                ?>" placeholder="Enter Medicine Unit Price." name="price" id="txtPrice" />
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
                                
                                <div class="col s10 container">
                                    <button onclick="SubmitData()" class="btn green mt-3">Submit</button>
                                    <a href="ListItems.php" class="btn mt-3 red">Cancel</a>
                                </div>
                                <div class="col s2 container">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        if($('#txtName').val()=='' || $('#txtStrength').val()==''||$('#txtPrice').val()=='')
                        {
                            swal('Error','All Fields are Required','error')
                        }

                        else
                        {
                                    if(!params.has('id'))
                                    {
                                        $.ajax({
                                url:"../ajax/Items?case=RegisterItem",
                                type:"GET",
                                data:{
                                    name:$('#txtName').val(),
                                    details:$('#txtDetails').val(),
                                    generic:$('#txtGeneric').val(),
                                    strength:$('#txtStrength').val(),
                                    description:$('#txtDetails').val(),
                                    price:$('#txtPrice').val()
                                },
                                success:function(resp)
                                {
                                    console.clear()
                                    console.log(resp)
                                    if(resp==1)
                                    {
                                        swal('Success','Item For Pharmacy Have Registered Successfully..','success')
                                        $('#txtName').val('')
                                        $('#txtDetails').val('')
                                    }
                                }
                            })
                       }

                       else
                       {
                        $.ajax({
                            url:"../ajax/Items?case=UpdateItem",
                            type:"GET",
                            data:{
                                name:$('#txtName').val(),
                                details:$('#txtDetails').val(),
                                generic:$('#txtGeneric').val(),
                                strength:$('#txtStrength').val(),
                                price:$('#txtPrice').val(),
                                id:params.get('id')
                            },
                            success:function(resp)
                            {
                                if(resp==1)
                                {
                                    swal('Success','Pharmacy Item Updated Successfully..','info')
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
