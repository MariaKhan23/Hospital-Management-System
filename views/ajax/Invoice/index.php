<?php

session_start();

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');
global $operation_fee;
global $ward_rent;
global $rent;
global $amount_rent;

switch ($case) {
    case 'GetInvoices':
        $query = mysqli_query($con, "select * from patient_invoice;");

        $invoice_str = '';

        while ($row = mysqli_fetch_assoc($query)) {
            $invoice_str .= "<tr>
            <td>" . $row['invoice_id'] . "</td>
            <td>" . $row['total_bill'] . "</td>
            <td>" . $row['invoice_date'] . "</td>
            <td>";

            if ($row['payment_type'] == 0) {
                $invoice_str .= '<span class="chip lighten-5 red red-text">Unpaid</span>';
            } else if ($row['payment_type'] == 1) {
                $invoice_str .= '<span class="chip lighten-5 orange orange-text">Partially Payment</span>';
            } else {
                $invoice_str .= '<span class="chip lighten-5 green green-text">Paid</span>';
            }

            $invoice_str .= "</td>
            <td>
            <a onclick='ShowReciept(this)' style='cursor:pointer;' id='" . $row['invoice_id'] . "'><i class='material-icons'>remove_red_eye</i></a>";

            if ($row['payment_type'] == 0 || $row['payment_type'] == 1) {
                $invoice_str .= '&nbsp; &nbsp;<a onclick="EditReciept(this)" style="cursor:pointer;"  id="' . $row['invoice_id'] . '"><i class="material-icons">edit</i></a>';
            }

            $invoice_str .= "</td>
            </tr>";
        }

        echo $invoice_str;

        break;

    case 'UpdateInvoice':
        $query = mysqli_query($con,"select * from patient_invoice where invoice_id='".setKey('inv_id')."';");

        $data = mysqli_fetch_assoc($query);

        // echo json_encode($data);

        $type = '';

        if(setKey('remaining_amount')<$data['amount_remaining'])
        {
            $type = 1;
        }
        
        if(setKey('remaining_amount')==$data['amount_remaining'])
        {
            $type = 2;
        }

        $val= $data['amount_recieving'] + setKey('remaining_amount');
        $val_cut = $data['amount_remaining'] - setKey('remaining_amount');
        $queryy = mysqli_query($con,"update patient_invoice set payment_type=".$type.",amount_remaining=".$val_cut.",amount_recieving=".$val." where invoice_id='".setKey('inv_id')."';");

         if($queryy)
         {
             echo 1;
         }

         else
         {
             echo mysqli_errno($con);
         }

        break;

    case 'SaveReceipt':
        break;

    case 'GetPatients':
        $query = mysqli_query($con, "select * from patient_outcome left join patient_invoice on patient_outcome.mrno=patient_invoice.mrno;");

        $str = '';
        while ($row = mysqli_fetch_assoc($query)) {
            $str .= '<option value="' . $row['mrno'] . '">' . $row['name'] . '</option>';
        }

        echo $str;

        break;

    case 'GetDosages':
        $query = mysqli_query($con, "SELECT dosage_master.dosage,items.name AS ItemName,items.unit_price FROM dosage INNER JOIN dosage_master ON dosage.id=dosage_master.dosage_id LEFT JOIN items ON dosage_master.item=items.name WHERE dosage.mrno='" . setKey('uid') . "';");

        $str_ = 0;

        while ($row = mysqli_fetch_assoc($query)) {
            $str_ += $row['unit_price'] * $row['dosage'];
        }

        echo $str_;

        break;

    case 'Patient':
        $query = mysqli_query($con, "select patient_recieving.mrno,patient_recieving.name,patient_recieving.ward,ward.id from patient_recieving left join ward on patient_recieving.ward=ward.name where patient_recieving.mrno='" . setKey('uid') . "';");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'GetTotalBill':

        $query = mysqli_query($con, "select one_day_rent from ward where id=" . setKey('ward_id') . ";");
        $rent = mysqli_fetch_assoc($query);
        $amount_rent = $rent['one_day_rent'] * setKey('rent');

        $operation_fee = setKey('ot_fee');
        $ward_rent = setKey('rent');
        echo setKey('med') + setKey('ot_fee') + $amount_rent;

        break;

    case 'SaveInvoiceData':
        $amount_remaining = setKey('total') - setKey('amount_paying');

        $query = mysqli_query($con, "insert into patient_invoice(mrno,total_bill,amount_recieving,payment_type,invoice_date,amount_remaining) values('" . setKey('mr') . "'," . setKey('total') . "," . setKey('amount_paying') . "," . setKey('payment_type') . ",'" . date("Y-m-d") . "'," . $amount_remaining . ");");

        if ($query) {
            $uid = mysqli_insert_id($con);
            $update_query = mysqli_query($con, "update patient_invoice set invoice_id='INV-" . $uid . "' where id=" . $uid . ";");

            if ($update_query) {
                // echo 'INV-' . $uid;
                $master_query = mysqli_query($con, "insert into invoice_master(invoice_id,item,quantity,price,total) values('INV-" . $uid . "','Surgery',1," . setKey('ot_fees') . "," . setKey('ot_fees') . ");");

                if ($master_query) {
                    $query = mysqli_query($con, "select one_day_rent from ward where id=" . setKey('ward_id') . ";");
                    $rent1 = mysqli_fetch_assoc($query);
                    $amount_rent1 = $rent1['one_day_rent'] * setKey('days');
                    $rent_query = mysqli_query($con, "insert into invoice_master(invoice_id,item,quantity,price,total) values('INV-" . $uid . "','" . setKey('days') . " Days Rent Fee'," . setKey('days') . "," . $rent1['one_day_rent'] . "," . setKey('days') * $rent1['one_day_rent'] . ");");

                    if ($rent_query) {
                        $med_query = mysqli_query($con, "SELECT dosage_master.dosage,items.name AS ItemName,items.unit_price FROM dosage INNER JOIN dosage_master ON dosage.id=dosage_master.dosage_id LEFT JOIN items ON dosage_master.item=items.name WHERE dosage.mrno='" . setKey('mr') . "';");

                        while ($row = mysqli_fetch_assoc($med_query)) {
                            $insert_med_query = mysqli_query($con, "insert into invoice_master(invoice_id,item,quantity,price,total) values('INV-" . $uid . "','MED/" . $row['ItemName'] . "'," . $row['dosage'] . "," . $row['unit_price'] . "," . $row['dosage'] * $row['unit_price'] . ");");
                        }

                        echo 1;
                    } else {
                        echo mysqli_errno($con);
                    }
                } else {
                    echo mysqli_errno($con);
                }
            } else {
                echo mysqli_errno($con);
            }
        } else {
            echo mysqli_errno($con);
        }

        break;
}
