<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

session_start();

$code_query = mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';");
$data_query = mysqli_fetch_assoc($code_query);

switch ($case) {
    case 'SetPrescription':
        $query = mysqli_query($con,"select * from prescriptions where mrno='".setKey('mr')."';");

        {
            $query = mysqli_query($con,"insert into prescriptions(mrno,item,med_time,days,doctor) values('".setKey('mr')."','".setKey('name')."','".setKey('schedule')."',".setKey('days').",'".$data_query['emp_code']."');");
            $update = mysqli_query($con,"update patient set flag=1 where mrno='".setKey('mr')."'");
        }

        echo setKey('mr');

        break;
    
    case 'value':
        # code...
        break;
}

?>