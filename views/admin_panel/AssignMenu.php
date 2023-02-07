<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    require_once '../connection/connection.php';

    $get_code_query = mysqli_query($con, "select emp_code as Data from staff where email='" . $_SESSION['email'] . "';");
    $code = mysqli_fetch_assoc($get_code_query);

    if ($code['Data'] != 'E-1') {
        echo '<script>window.history.back()</script>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Menus Assesment Panel </title>
    <?php include_once '../include/style.php'; ?>
</head>

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <?php include_once '../include/header.php'; ?>

    <?php include_once '../include/sidebar.php'; ?>

    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <h5>Employees Views Assesment Panel</h5>
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s6">
                                    <span>Selcet Employee: </span>
                                    <select name="emp" id="slctEmployee">
                                        <option value="">-- Select Employee --</option>
                                        <?php $query = mysqli_query($con, "select * from staff left join staff_roles on staff.emp_code=staff_roles.emp_code where staff.id>1 and staff_roles.designation!='Doctor';");

                                        while ($staff_data = mysqli_fetch_assoc($query)) {
                                            echo '<option value="' . $staff_data['emp_code'] . '">' . $staff_data['emp_code'] . ' (' . $staff_data['name'] . ')</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col s4 input-field">
                                    <button class="btn cyan" onclick="GenerateViews()">Select Employee</button>
                                </div>
                                <div class="col s12">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>View</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <br>
                                    <button class="btn green float-right" id="btnSave" onclick="Save()">Save</button>
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
    <script>
        $('#btnSave').hide()

        function GenerateViews() {
            if ($('#slctEmployee').val() == '') {
                swal('Warning', 'Please Select The Employee First..', 'info')
            } else {
                $.ajax({
                    url: '../ajax/Permission?case=GenerateViews',
                    type: "GET",
                    data: {
                        uid: $('#slctEmployee').val()
                    },
                    success: function(resp) {
                        $('tbody').append(resp)
                        $('#btnSave').show()
                    }
                })
            }
        }

        function Save() {

            $.ajax({
                url: '../ajax/Permission/?case=Delete',
                type: "GET",
                data: {
                    uid: $('#slctEmployee').val()
                },
                success: function(resp) {

                }
            })

            var ids = []
            var rows = ($('tbody>tr').length)
            var id = 0;
            // console.clear()
            // console.log(rows)

            for (let index = 1; index <= rows; index++) {
                var chkBox = ($('tr')[index].childNodes[3].childNodes[0].childNodes[0].checked)
                // console.log($('tr')[index].childNodes[3].childNodes[0].childNodes[0].checked)

                if (chkBox == true) {
                    id = 1
                    ids.push($('tr')[index].childNodes[3].childNodes[0].childNodes[0].id)
                }
            }

            for (var a = 0; a < ids.length; a++) {
                $.ajax({
                    url: "../ajax/Permission/?case=Save",
                    type: "GET",
                    data: {
                        vid: ids[a],
                        allow: id,
                        uid: $('#slctEmployee').val()
                    },
                    success: function(resp) {}
                })
            }
            swal('Success', 'Menu Assigned Successfully..', 'success')

            // console.dir($('input[type=checkbox]').html())
        }
    </script>
</body>

</html>