<?php

session_start();

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Patient Outcome </title>
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
                        <h5 style="display:inline;">Patient Outcome</h5>
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row mt-2">
                                <div class="col s12">
                                    <a href="#" class="btn green float-right" onclick="AddPatientOutcome()">ADD</a>
                                    <br><br><br>
                                    <div class="container">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>MRNo</th>
                                                    <th>Name</th>
                                                    <th>Outcome</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalView">
        <div style="text-align:center;">
            <h5>In-Patient Outcome Details</h5>
        </div>
        <div class="modal-content">
            <div class="row">

                <div class="col s3">MR:</div>
                <div class="col s9"><span id="lblMR"></span></div>
                <br><br>
                <div class="col s3">Name:</div>
                <div class="col s9"><span id="lblName"></span></div>
                <br><br>
                <div class="col s3">Outcome:</div>
                <div class="col s9"><span id="lblOutcome"></span></div>
                <br><br>
                <div class="col s3">Outcome Date:</div>
                <div class="col s9"><span id="lblOutcomeDate"></span></div>
                <br><br>
                <div class="col s3">Final Notes:</div>
                <div class="col s9"><span id="lblFinalNotes"></span></div>
                <br><br>
                <div class="col s3">Submit By:</div>
                <div class="col s9"><span id="lblSubmitBy"></span></div>
                <br><br>
                <div class="col s3">Updated By:</div>
                <div class="col s9"><span id="lblUpdatBy"></span></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalEdit">
        <div class="modal-content">
            <div class="row">
                <div class="col s3">MR:</div>
                <div class="col s9"><span id="lblMR"></span></div>
                <br><br>
                <div class="col s3">Name:</div>
                <div class="col s9"><span id="lblName"></span></div>
                <br><br>
                <div class="col s3">Outcome: </div>
                <div class="col s9">
                    <select name="outcome" id="lblOutcome">
                        <option value="Discharged">Discharged</option>
                        <option value="Expired">Expired</option>
                        <option value="Sent Back to Ward">Sent Back to Ward</option>
                        <option value="Refer to Other Hospital">Refer to Other Hospital</option>
                        <option value="Improved &amp; SentBack To Ward">Improved &amp; SentBack To Ward</option>
                        <option value="Discharged Upon Patient Request">Discharged Upon Patient Request</option>
                    </select>
                </div>
                <br><br>
                <div class="col s3">Final Notes: </div>
                <div class="col s9"><input type="text" id="lblFinalNotes" /></div>
                <br><br>
                <div class="col s3">Date: </div>
                <div class="col s9"><input type="date" id="lblOutcomeDate" /></div>
                <br><br>
                <div class="col s3">
                    <button class="btn green" onclick="UpdateOutcome()">Update</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
        </div>
    </footer>
    <?php include_once '../include/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            GeneratePatientOutcome()
        })

        function GeneratePatientOutcome() {
            $.ajax({
                url: "../ajax/PatientOutcome?case=GetInPatients",
                success: function(resp) {
                    $('tbody').html('')
                    $('tbody').append(resp)
                    $('table').DataTable()
                }
            })
        }

        function UpdateOutcome() {
            $.ajax({
                url: "../ajax/PatientOutcome?case=UpdateOutcome",
                type: "GET",
                data: {
                    mr: $('#lblMR').html(),
                    outcome: $('#lblOutcome').val(),
                    date: $('#lblOutcomeDate').val(),
                    final_notes: $('#lblFinalNotes').val()
                },
                success: function(resp) {
                    if (resp == 1) {
                        swal('Success', 'Patient Outcome Updated Successfully..', 'success')
                    }
                }
            })
        }

        function SetOutcome(a) {
            $.ajax({
                url: "../ajax/PatientOutcome/?case=GetData",
                type: "GET",
                data: {
                    mr: a.id
                },
                success: function(resp) {
                    let data = $.parseJSON(resp)
                    $('#lblMR').html(a.id)
                    $('#lblName').html(data.name)
                    $('#lblOutcome').html(data.outcome)
                    $('#lblFinalNotes').html(data.final_notes)
                    $('#lblOutcomeDate').html(data.outcome_date)
                    $('#lblSubmitBy').html(data.submit_by),
                        $('#lblUpdatBy').html(data.updated_by)
                }
            })
        }

        function SetEdit(e) {
            $('#lblMR').html(e.id)

            $.ajax({
                url: "../ajax/PatientOutcome/?case=GetData",
                type: "GET",
                data: {
                    mr: $('#lblMR').html()
                },
                success: function(resp) {
                    let data = $.parseJSON(resp)
                    $('#lblName').html(data.name)
                    $('#lblOutcome').val(data.outcome)
                    $('#lblFinalNotes').val(data.final_notes)
                    $('#lblOutcomeDate').val(data.outcome_date)
                }
            })
        }

        function AddPatientOutcome() {
            window.location.href = 'SetOutcome.php'
        }
    </script>
</body>

</html>