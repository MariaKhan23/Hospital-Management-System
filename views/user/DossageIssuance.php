<?php

session_start();

require_once '../connection/connection.php';

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
} else {
    $get_patient = mysqli_query($con, "select name,age from patient where mrno='" . $_GET['mr'] . "';");

    if (mysqli_num_rows($get_patient) > 0) {
        $patient_data = mysqli_fetch_assoc($get_patient);
    } else {
        echo "<script>window.location.href='PatientDosage.php'</script>";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Patient Dossage</title>
    <?php include_once '../include/style.php'; ?>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <?php include_once '../include/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    <?php include_once '../include/userbar.php'; ?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5 style="display:inline;">Patient Dossage</h5>
                        <button class="btn red float-right" onclick="window.history.back() ">Cancel</button> <br><br>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s3">
                                    MR#
                                </div>
                                <div class="col s9">
                                    <span id="lblMR"><?php echo $_GET['mr']; ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    Name
                                </div>

                                <div class="col s9">
                                    <span id="lblName"><?php echo $patient_data['name']; ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    Age:
                                </div>

                                <div class="col s9">
                                    <span id="lblAge"><?php echo $patient_data['age']; ?></span>
                                </div>
                                <br><br>
                                <div class="col s3">
                                    Dossage Issuance Status:
                                </div>

                                <div class="col s9">
                                    <span id="lblAge_">
                                        <?php $abc = mysqli_query($con,"select count(*) as Total from dosage where mrno='".$_GET['mr']."';");
                                        $a_ = mysqli_fetch_assoc($abc);

                                        if ($a_['Total'] == 0) {
                                            echo '<span style="color:#dc3545;">Not Issued</span>';
                                        }

                                        else
                                        {
                                            echo '<span style="color:#198754;">Issued</span>';
                                        }
                                        ?>
                                    </span>
                                </div>
                                <br><br>
                                <div class="col s6">
                                    <span>Select Item:</span>
                                    <select name="item" id="txtMed" class="select2 browser-default">
                                        <option value="">-- Select Item --</option>
                                        <?php

                                        $items = mysqli_query($con, "select id,name from items;");
                                        while ($arr = mysqli_fetch_assoc($items)) {
                                            echo "<option value=" . $arr['id'] . ">" . $arr['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col s3">
                                    <span>Select Dosage:</span>
                                    <select name="dosage" id="slctDosage">
                                        <option value="1">OD (1)</option>
                                        <option value="2">BD (2)</option>
                                        <option value="3">TDS (3)</option>
                                        <option value="4">QID (4)</option>
                                    </select>
                                </div>
                                <div class="col s2">
                                    <button class="btn cyan" onclick="AddItem()">ADD</button>
                                </div>
                                <table class="container row col s12">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Generic</th>
                                            <th>Strength</th>
                                            <th>Dosages</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><button class="btn green accent-2" onclick="GenerateRow()">Save</button></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
        $(document).ready(function() {
            $('table').hide()
            $('.select2').select2()
        })

        function GenerateItems() {
            $.ajax({
                url: "../ajax/PatientDosage?case=GetItems",
                success: function(resp) {
                    $('tbody').append(resp)
                    return resp;
                }
            })
        }

        function AddItem() {
            // console.log($('#txtMed').val())
            $.ajax({
                url: "../ajax/PatientDosage?case=GetOneItem",
                type: "GET",
                data: {
                    id: $('#txtMed').val(),
                    dosage: $('#slctDosage').val()
                },
                success: function(resp) {
                    $('tbody').append(resp)
                }
            })

            $('table').show()
        }

        function GenerateRow() {

            var id;

            $.ajax({
                url: "../ajax/PatientDosage?case=SendPatient",
                type: "GET",
                data: {
                    mrno: $('#lblMR').html(),
                    name: $('#lblName').html(),
                    age: $('#lblAge').html()
                },
                success: function(resp) {
                    var rows = $('tr').length

for (let index = 1; index < rows - 1; index++) {
    let item_name = ($('tr')[index].childNodes[1].innerHTML)
    let item_dosage = ($('tr')[index].childNodes[7].innerHTML)
    var string =item_dosage;
var numberInBrackets = string.match(/\(\d+\)/)[0];
var number = numberInBrackets.replace(/[\(\)]/g, "");
// console.log(number)
    $.ajax({
        url: "../ajax/PatientDosage?case=SendItems",
        type: "GET",
        data: {
            id: resp,
            name: item_name,
            dosage: number
        },
        success: function(resp) {
            swal('Success', 'Dossages Described Successfully..', 'success')

            setTimeout(() => {
                window.location.href = 'PatientDosage.php'
            }, 1500);
        }
    })
}
                    id = resp
                }
            })
        }

        function RemoveItem(uid) {
            uid.parentNode.parentNode.remove()
        }
    </script>
</body>

</html>