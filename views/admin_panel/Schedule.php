<?php

session_start();

if($_SESSION['email']==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

else
{
    require_once '../connection/connection.php';
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
                            <h5 class="p-2">Staff Scheduling</h5>
                            <div class="row">
                                <div class="col s12 p4">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Emp ID</th>
                                                <th>Name</th>
                                                <th>Contact Info</th>
                                                <th>CNIC</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

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

    <div class="modal" id="modalStaffRoles">
        <div class="modal-content">
            <table id="tblMember" class="table table-hover table-striped table-borderless w-100">



            </table>

            <div class="row">
                <div class="col s4">
                    <span>Starting Time:</span>
                    <input type="time" name="stime" id="txtStartTime">
                </div>
                <div class="col s4">
                    <span>Ending Time:</span>
                    <input type="time" name="etime" id="txtEndTime">
                </div>
                <div class="col s4">
                    <button onclick="SaveShift()" class="btn green mt-5">Save</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

    <?php include_once '../include/scripts.php'; ?>
    <!-- END PAGE LEVEL JS-->
    <script>

    </script>
<script>
    $(document).ready(function() {
        FetchStaff()
    })
    
    function FetchStaff() {
        $.ajax({
            url: "../ajax/Schedule?case=FetchStaff",
            success: function(resp) {
                $('tbody').html('')
                $('tbody').append(resp)
                $('table').dataTable()
            }
        })
    }

    function SetData(param) {
       // alert(param.id)
        $.ajax({
            url: "../ajax/Schedule?case=GetStaff",
            type: "GET",
            data: {
                id: param.id
            },
            success: function(resp) {
                var data = $.parseJSON(resp)
                $('#tblMember').empty()
                $('#tblMember').append(' <tr><th>Emp Code</th><th>Name</th><th>Contact Info</th><th>CNIC</th></tr><tr><td id="lblCode">' + data.emp_code + '</td><td>' + data.name + '</td><td>' + data.contactinfo + '</td><td>' + data.cnic + '</td></tr>')
                let emp_code_ = (data.emp_code)
                $.ajax({
                    url: "../ajax/Schedule?case=GetTime",
                    type: "GET",
                    data: {
                        code: emp_code_
                    },
                    success: function(resp) {
                        var data_ = $.parseJSON(resp)
                      
                        if(data_!=null)
                        {
                            $('#txtStartTime').val(data_.starting_time)
                            $('#txtEndTime').val(data_.ending_time)
                        }
                        
                        else
                        {
                            $('#txtStartTime').val('')
                            $('#txtEndTime').val('')
                        }
                    }
                })
                console.log(data)
            }
        })
    }
    
    function SaveShift() {
        $.ajax({
            url: "../ajax/Schedule?case=SubmitShift",
            type: "GET",
            data: {
                code: $('#lblCode').html(),
                stime: $('#txtStartTime').val(),
                etime: $('#txtEndTime').val()
            },
            success: function(resp) {
                console.clear()
                console.log($('#txtEndTime').val())
                console.log(resp)
                if (resp == 1) {
                    swal('Success', 'Staff Shift Have Successfully Created..', 'success')
                }
            }
        })
    }
</script>
</body>
</html>
<!-- END: Head-->