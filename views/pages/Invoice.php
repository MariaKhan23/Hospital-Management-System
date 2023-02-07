<?php

session_start();

require_once '../connection/connection.php';

if ($_SESSION['email'] == null) {
    echo '<script>window.location.href="../login.php"</script>';
} else {
    $data = mysqli_query($con, "select * from patient_invoice inner join invoice_master on patient_invoice.invoice_id=invoice_master.invoice_id left join patient on patient_invoice.mrno=patient.mrno where patient_invoice.invoice_id='" . $_GET['inv'] . "';");

    if (mysqli_num_rows($data) > 0) {
        $inv_data = mysqli_fetch_assoc($data);
    } else {
        echo '<script>window.location.href="../admin_panel/InvoiceList.php"</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media print {
            #r2
            {
                display:none;
            }

            @page
            {
                size:A4;
                margin:1cm;
            }
        }

        #section-print
        {
            background-image:url('../images/nobg.png');
            background-repeat:no-repeat;
            background-position:center;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
    <?php include_once '../include/style.php'; ?>
</head>

<body>

    <section class="invoice-edit-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <div class="col xl9 m8 s12">
                <div class="card" id="section_print">
                    <div class="card-content px-36">
                        <!-- header section -->
                        <div class="row mb-3">
                            <div class="col s8">
                                <h6 class="invoice-number mr">Invoice#</h6>
                                <span class="m"><?php echo $inv_data['invoice_id']; ?></span>
                            </div>
                            <div class="col s4">
                                <div class="invoice-date-picker display-flex align-items-center">
                                    <div class="display-flex align-items-center">
                                        <small>Date Issue: </small>
                                        <div class="display-flex m-4">
                                            <span><?php echo $inv_data['invoice_date']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- logo and title -->
                        <!-- <div class="row 3">
                            <div class="col m6 s12 invoice-logo display-flex pt-1 push-m6">
                            </div>
                            <div class="col m6 s12 pull-m6">
                                <h4 class="indigo-text">Patient Invoice</h4>
                            </div>
                        </div> -->
                        <div class="row mb-3">
                                            <div class="col m6 s12 invoice-logo display-flex -1 -3 psh-m6">
                                                <!-- <img src="../images/nobg.png" alt="logo" class="img-fluid small" /> -->
                                            </div>
                                            <div class="col m6 s12 pull-m6">
                                                <h4 class="indigo-text">Patient Invoice</h4>
                                            </div>
                                        </div>
                        <!-- invoice address and contact -->
                        <div class="row mb-3">
                            <div class="col l6 s12">
                                <h6>Bill To</h6>
                                <div class="input-field">
                                    <span style="border-bottom:1px;"><?php echo '(' . $inv_data['mrno'] . ')' ?>&nbsp;&nbsp;&nbsp; <?php echo $inv_data['name']; ?></span>
                                </div>
                                <div class="input-field">
                                    <span>Age: <?php echo $inv_data['age']; ?></span>
                                </div>
                                <div class="input-field">
                                    <span>Contact Info: <?php echo $inv_data['contactinfo']; ?>&nbsp;&nbsp;&nbsp;&nbsp; </span>
                                </div>
                                <div class="input-field">
                                    <span>CNIC: <?php echo $inv_data['cnic']; ?></span>
                                </div>
                                <div class="input-field">
                                    <textarea class="materialize-textarea" readonly rows="15"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- product details table-->
                        <div class="invoice-product-details -3">
                          
                                <div data-repeater-list="group-a">
                                    <div class="m">
                                        <!-- invoice Titles -->
                                        
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Qty</th>
                                                    <th>Cost</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $query = mysqli_query($con, "select * from invoice_master where invoice_id='" . $_GET['inv'] . "';");

                                                $row = mysqli_fetch_all($query, MYSQLI_ASSOC);

                                                $json_data = json_encode($row);

                                                file_put_contents('api.json', $json_data, JSON_PRETTY_PRINT);

                                                $file_data = file_get_contents('api.json');

                                                $response = json_decode($file_data);

                                                foreach ($response as $key => $value) {
                                                    echo '<tr>
    <td>' . $response[$key]->item . '</td>
    <td>' . $response[$key]->quantity . '</td>
    <td>' . $response[$key]->price . '</td>
    <td>' . $response[$key]->total . '</td>
                                                                    </tr>';
                                                }


                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                        <!-- invoice subtotal -->
                        <div class="invoice-stotal -5">
                            <div class="row">
                                <div class="col m5 s12">
                                    <div class="input-field">
                                        <input type="text" readonly value="<?php

                                                                            if ($inv_data['payment_type'] == 1) {
                                                                                echo 'Partial Payment';
                                                                            } else {
                                                                                echo 'Complete Payment';
                                                                            }

                                                                            ?>">
                                    </div>
                                </div>
                                <div class="col s8">
                                    <ul>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">Subtotal</span>
                                            <h6 class="invoice-subtotal-value">Rs: <?php echo $inv_data['total_bill'] ?></h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">Amount Remaining</span>
                                            <h6 class="invoice-subtotal-value">- Rs: <?php echo $inv_data['amount_remaining'] ?></h6>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">Amount Recieved</span>
                                            <h6 class="invoice-subtotal-value">Rs: <?php echo $inv_data['amount_recieving']; ?></h6>
                                        </li>
                                        <li>
                                            <div class="divider 2 b-2"></div>
                                        </li>
                                        <li class="display-flex justify-content-between">
                                            <span class="invoice-subtotal-title">Invoice Total</span>
                                            <h6 class="invoice-subtotal-value">Rs: <?php echo $inv_data['total_bill']; ?></h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- invoice action  -->
            <div class="col xl3 m4 s12" id="r2">
                <div class="card invoice-action-wrapper 10">
                    <div class="card-content">


                        <div class="invoice-action-btn input-field">
                               
                                <button class="btn green" onclick="PrintElem(this)"> Print Invoice</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once '../include/scripts.php'; ?>

    <script>
        function PrintElem(elem) {
            $('#r2').hide()
            window.print()
            $('#r2').show()
            return true;
        }
    </script>

</body>

</html>