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
    <title>Patient Invoice Management </title>
    <?php include_once '../include/style.php'; ?>
</head>

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <?php include_once '../include/header.php'; ?>
 
    <?php include_once '../include/sidebar.php'; ?>
   
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <h5>Invoice Management</h5>
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s9 input-field">
                                    <span>Select Patient</span>
                                    <select name="patient" id="slctPatient">
                                        <?php

                                        require_once '../connection/connection.php';

                                        $query = mysqli_query($con, "select * from patient_outcome left join patient_invoice on patient_outcome.mrno=patient_invoice.mrno where patient_invoice.mrno is null;");

                                        $str = '';
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            $str .= '<option value="' . $row['mrno'] . '"> '.$row['mrno'].' (' . $row['name'] . ')</option>';
                                        }

                                        echo $str;

                                        ?>
                                    </select>
                                </div>
                                <div class="col s3 input-field">
                                    <button onclick="GenerateData()" class="btn green">Generate Data</button>
                                </div>
                                    </div>
                                <div class="row" id="panel">
                                <div class="col s3">
                                    Patient MR:
                                </div>

                                <div class="col s9">
                                    <span id="lblMR"></span>
                                </div>

                                <br><br>
                                <div class="col s3">
                                    Patient Name:
                                </div>

                                <div class="col s9">
                                    <span id="lblName"></span>
                                </div>

                                <br><br>

                                <div class="col s3">
                                    Admit In:
                                </div>

                                <div class="col s9">
                                    <span class="" id="lblWard"></span>
                                </div>

                                <br><br>
                                
                                <div class="col s4 input-field">
                                    <label>OT Fee:</label>
                                    <input type="number" name="ot_fee" id="txtOtFee" />
                                </div>

                                <div class="col s4 input-field">
                                    <label>Meidication Fee:</label>
                                    <input type="text" name="med_fee" readonly id="lblMedicalFee" />
                                </div>

                                <div class="col s4 input-field">
                                    <label>Days Staying:</label>
                                    <input type="number" name="days" id="txtDays">
                                </div>

                                <div class="col s4 input-field">
                                    <select name="pay" onchange="CalculateBill()" id="slctPayment">
                                        <option value="">-- SELECT PAYMENT METHOD --</option>
                                        <option value="1">Partial Payment</option>
                                        <option value="2">Complete Payment</option>
                                    </select>
                                </div>
                                <div class="col s4 input-field">
                                    <label>Total Bill: </label>
                                    <input type="text" name="bill" readonly id="txtBill" />
                                </div>

                                <!-- <div class="col s4 input-field">
                                    .
                                </div> -->

                                <div class="col s4 input-field">
                                    <label>Amount Recieved: </label>
                                    <input type="number" name="amount_recieve" id="txtAmountRecieve" />
                                </div>
                                    </div>
                            
                            <div class="row" id="btnRow">
                                <div class="col s12">
                                    <button onclick="SaveInvoice()" class="btn blue float-right">Save</button>
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
        $(document).ready(function() {
            $('#btnRow').hide()
            $('#panel1').hide()
            $('#panel').hide()
            $('#panel2').hide()
        })

        let med_fee = 0;

        function GenerateData()
        {
            $.ajax({
                url:'../ajax/Invoice?case=GetDosages',
                type:"GET",
                data:{
                    uid:$('#slctPatient').val()
                },
                success:function(resp)
                {
                    med_fee = resp
                    $('#lblMedicalFee').val('RS:'+resp)
                }
            })

            $.ajax({
                url:"../ajax/Invoice?case=Patient",
                type:"GET",
                data:{
                    uid:$('#slctPatient').val()
                },
                success:function(resp)
                {
                    let data = $.parseJSON(resp)

                    $('#lblMR').html(data.mrno)
                    $('#lblName').html(data.name)
                    $('#lblWard').html(data.ward)
                    $('#lblWard').attr('class',data.id)
                }
            })

            $('#panel').show()
            $('#btnRow').show()
            $('#panel1').show()
            $('#panel2').show()

        }

        function CalculateBill()
        {
            if($('#txtOtFee').val()=='' || $('#txtDays').val()=='')
            {
                swal('Warning','OT Fee or Staying Days are Required..','info')
            }

            else
            {
                var ward = (document.getElementById('lblWard').className)
                $.ajax({
                    url:"../ajax/Invoice?case=GetTotalBill",
                    type:"GET",
                    data:{
                        med:med_fee,
                        ot_fee:$('#txtOtFee').val(),
                        rent:$('#txtDays').val(),
                        ward_id:ward
                    },
                    success:function(resp)
                    {
                        $('#txtBill').val(resp)
                    }
                })
            }

        }

        function SaveInvoice()
        {
            $.ajax({
                url:"../ajax/Invoice?case=SaveInvoiceData",
                type:"GET",
                data:{
                    mr:$('#lblMR').html(),
                    total:$('#txtBill').val(),
                    payment_type:$('#slctPayment').val(),
                    amount_paying:$('#txtAmountRecieve').val(),
                    ot_fees:$('#txtOtFee').val(),
                    days:$('#txtDays').val(),
                    ward_id:document.getElementById('lblWard').className
                },
                success:function(resp)
                {
                    if(resp==1)
                    {
                        window.location.href='../pages/Invoice.php?mr='+$('#lblMR').html()
                    }
                },
                error:function(err)
                {
                    console.log(err)
                }
            })
        }

    </script>
</body>
</html>