<?php

session_start();

if(($_SESSION['email'])==null)
{
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Create/Update Lab Test</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
   <?php include_once '../include/header.php'; ?>

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
                        <h5 class="p-2">Hospital Laboratory Test</h5>

                            <div class="ow">
                            <a href="Tests.php" class="btn btn-sm float-right cyan">ADD</a> <br> <br>
                                    <table class="table small table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Test ID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
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

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>

 <?php include_once '../include/scripts.php'; ?>
   <script>
    $(document).ready(function()
    {
        GetTest();
    })

    function UpdateTest(e)
    {
        window.location.href='Tests.php?id='+e.id
    }

    function DeleteTest(a)
    {
        swal({
    title: "Are you sure?",
    text: "You will not be able to recover this imaginary file!",
    icon: 'warning',
    dangerMode: true,
    buttons: {
      cancel: 'No!',
      delete: 'Yes'
    }
  }).then(function (willDelete) {
    if (willDelete) {

         $.ajax({
            url:"../ajax/Test?case=DeleteTest",
            type:"GET",
            data:{
                id:a.id
            },
            success:function(resp)
            {
                if(resp==1)
                {
                    swal('Success','Selected Test Record Deleted Successfully..','success')
                }

                setTimeout(() => {
                        window.location.reload()
                }, 2000);
            }
       })


      swal("Your Selected Data has been deleted!", {
        icon: "success",
      });
    } else {
      swal("Deletion Terminated", {
        title: 'Cancelled',
        icon: "error",
      });
    }
  });

       
    }

    function GetTest()
    {
        $.ajax({
            url:"../ajax/Test?case=GetTest",
            success:function(resp)
            {
                $('tbody').html('')
                $('tbody').append(resp)
                $('table').dataTable()
            }
        })
    }
   </script>
</body>
</html>