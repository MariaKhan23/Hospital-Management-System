<?php

require_once '../connection/connection.php';

$query = mysqli_query($con,"select * from patient where mrno='".$_GET['mr']."';");

if(mysqli_num_rows($query)>0)
{
    $data = mysqli_fetch_assoc($query);
}

else
{
    echo '<script>window.location.href="../admin_panel/ListPatients.php"</script>';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Receipt example</title>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 100px;
            max-width: 100px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <img src="../images/hospital-logo-template-hospital-logo-template-117487677.jpg" height="120" alt="Logo">
        <h4>Hospital Management System</h4>
        <p class="centered">OPD SLIP</p>
        <table>
            <tbody>
                <tr>
                    <td class="description">Patient MR:</td>
                    <td class="price"><?php echo $data['mrno']; ?></td>
                </tr>
                <tr>
                    <td class="description">Patient Name</td>
                    <td class="price"><?php echo $data['name']; ?></td>
                </tr>
                <tr>
                    <td class="description">Age</td>
                    <td class="price"><?php echo $data['age']; ?></td>
                </tr>
                <tr>
                    <td class="description">Gender: </td>
                    <td class="price"><?php echo $data['gender']; ?></td>
                </tr>
                <tr>
                    <td class="description">Registration Date: </td>
                    <td class="price"><?php echo $data['updated_at']; ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <center>Advised:</center>
        <pre>









        </pre>
    </div>
    <button id="btnPrint" class="hidden-print">Print</button>
</body>

<script>
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>

</html>