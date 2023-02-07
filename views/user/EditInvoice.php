<?php

session_start();

require_once '../connection/connection.php';

if ($_SESSION['email'] == null) {
    echo "<script>window.location.href='../login.php'</script>";
}

else
{
    $query = mysqli_query($con,"select * from patient_invoice left join patient_recieving on patient_invoice.mrno=patient_recieving.mrno where patient_invoice.invoice_id='".$_GET['inv']."';");

    if(mysqli_num_rows($query)>0)
    {
        $invoice_data = mysqli_fetch_assoc($query);
    }

    else
    {
        echo "<script>window.location.href='InvoiceList.php'</script>";
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Patient Invoice Management Panel</title>
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
                        <h5>Invoice Management</h5>
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                
                                    </div>
                                <div class="row" id="panel">
                                <div class="col s3">
                                    Patient MR:
                                </div>

                                <div class="col s9">
                                    <span id="lblMR"><?php echo $invoice_data['mrno']; ?></span>
                                </div>

                                <br><br>
                                <div class="col s3">
                                    Patient Name:
                                </div>

                                <div class="col s9">
                                    <span id="lblName"><?php echo $invoice_data['name']; ?></span>
                                </div>

                                <br><br>

                                <div class="col s3">
                                    Admit In:
                                </div>

                                <div class="col s9">
                                    <span class="" id="lblWard"><?php echo $invoice_data['ward']; ?></span>
                                </div>
                                
                                <div class="col s3 input-field">
                                    <span>Total Bill: </span>
                                </div>
                                
                                <div class="col s9 input-field">
                                    <?php echo 'Rs:'.$invoice_data['total_bill']; ?>
                                </div>

                                <div class="col s3 input-fild">
                                    <span>Advance Payment: </span>
                                </div>
                                
                                <div class="col s9 inpu-field">
                                    <?php echo 'Rs:' . $invoice_data['amount_recieving']; ?>
                                </div>

                                <div class="col s3 mt-1 input-f">
                                    <span>Remaining Amount: </span>
                                </div>

                                <BR></BR>

                                <div class="col s9 mt-1">
                                    Rs:<span id="lblRemaining"><?php echo $a = $invoice_data['total_bill'] - $invoice_data['amount_recieving']; ?>
</span>
                                </div>

                                <div class="col s4 mt-4">
                                    <span>Enter Remaining Amount: </span>
                                    <input type="number" name="amount" id="txtAmount" />
                                </div>

                                <div class="col s4 input-field mt-4">
                                    <span>Select Payment Type</span>
                                    <select>
                                        <option value="1">Partially Payment</option>
                                        <option value="2">Complete Payment</option>
                                    </select>
                                </div>
                                <div class="col input-field mt-5 s4">
                                    <button onclick="SaveInvoice()" class="btn blue flot-right">Save</button>
                                </div>
                                    </div>
                            
                            <div class="row" id="btnRow">
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
            // $('#btnRow').hide()
            // $('#panel1').hide()
            // $('#panel').hide()
            // $('#panel2').hide()
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
            const params = new URLSearchParams(window.location.search)

            // alert(34)

            if(parseInt($('#txtAmount').val())>parseInt($('#lblRemaining').html()))
            {
                swal('Warning','Amount Exceeded The Actual Remaining Amount','warning')
            }

            else if($('#txtAmount').val()=='')
            {
                swal('Error','Difference Amount is Required..','error')
            }

            else
            {
                // alert(333)
                $.ajax({
                    url:"../ajax/Invoice/?case=UpdateInvoice",
                    type:"GET",
                    data:{
                        inv_id:params.get('inv'),
                        remaining_amount:$('#txtAmount').val()
                    },
                    success:function(resp)
                    {
                        console.log(resp)
                        if(resp==1)
                        {
                            window.location.href='../pages/Invoice.php?inv='+params.get('inv')
                        }
                    }
                })
            }
        }

    </script>
</body>
</html>