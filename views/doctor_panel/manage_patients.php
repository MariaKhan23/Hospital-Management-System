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
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>



    <!-- BEGIN: SideNav-->
    <?php include_once '../include/sidebar1.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <h5>Patients</h5>
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                        
                            <table>
                                <thead>
                                    <tr>
                                        <th>MR#</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>User</th>
                                        <TH>Action</TH>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <div id="modalData" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col s3">
                    MR: 
                </div>

                <div class="col s9">
                <span id="lblMR"></span>
                </div>
<br><br>
                <div class="col s3">
                    Name:
                </div>

                <div class="col s9">
                    <span id="lblName"></span>
                </div>
<br><br>
<div class="col s3">
                    Age:
                </div>

                <div class="col s9">
                    <span id="lblAge"></span>
                </div>
<br><br>
                <div class="col s3">
                    Ward:
                </div>

                <div class="col s9">
                    <select class="select2 browser-default" style="width:100%;" name="ward" id="slctWard">
                        <option value="">-- Select Ward --</option>
                        <?php
                        require_once '../connection/connection.php';
                        $q = mysqli_query($con,"select name from ward;");
                        while($list = mysqli_fetch_assoc($q))
                        {
                            echo '<option value="'.$list['name'].'">'.$list['name'].'</option>';
                        }
                        
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn blue" onclick='SetRequest()'>Send Details</button>
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
        $(document).ready(function() {
            $('select').select2()
           $('tbody').append('<tr><td colspan="5"><h4>Loading..</h4></td></tr>')
        })
        
      //  setTimeout(function(){GetPatients()}, 500)

     var _time = setInterval(() => {
                GetPatients()
        }, 2000);

        clearInterval()

        function GetPatients() {
            $.ajax({
                url: "../ajax/Consults?case=GetPatients",
                type: "GET",
                success: function(resp) {
                    if(resp!=null)
                    {
                        $('tbody').html('')
                        $('tbody').append(resp)
                        $('table').DataTable()                   
                    }
                }
            })
        }

        function SetLabTest(mr)
        {
            window.location.href='lab_test.php?mr='+mr.id
        }

        function SetMedicines(e)
        {
            console.clear()
            console.log(e.id)

            window.location.href='prescription.php?mr='+e.id
        }

        function SetAdmission(a)
        {
            console.log(a.parentNode.parentNode.childNodes[1].innerText)
            console.log(a.parentNode.parentNode.childNodes[3].innerText)

            $('#lblMR').html(a.parentNode.parentNode.childNodes[1].innerText)
            $('#lblName').html(a.parentNode.parentNode.childNodes[3].innerText)
            $('#lblAge').html(a.parentNode.parentNode.childNodes[5].innerText)
        }

        function SetRequest()
        {
            $.ajax({
                url:"../ajax/Consults?case=SendRequest",
                type:"GET",
                data:{
                    mr:$('#lblMR').html(),
                    name:$('#lblName').html(),
                    ward:$('#slctWard').val(),
                    age:$('#lblAge').html()
                },
                success:function(resp)
                {
                    if(resp==1)
                    {
                        swal('Success','Patient Details Sended Successfully..','success')
                    }
                }
            })
        }
    </script>
</body>
</html>