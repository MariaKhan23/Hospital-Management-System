<?php

require_once '../../connection/connection.php';
require_once '../../connection/connection.php';
require_once '../../Email.php';
require_once '../vendor/autoload.php';

session_start();

function setKey($key)
{
        return $_REQUEST[$key];
}

$get_code_with_name = mysqli_query($con,"select emp_code,name from staff where email='".$_SESSION['email']."';");
$get_data = mysqli_fetch_assoc($get_code_with_name);

$case = $_GET['case'];

switch ($case) {
    case 'FetchStaff':
        $query = mysqli_query($con,"select * from staff;");
        $str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $str .= '<tr>
            <td>'.$row['emp_code'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['contactinfo'].'</td>
            <td>'.$row['cnic'].'</td>
            <td>
            <a id="'.$row['id'].'" onclick="SetData(this)" href="#modalStaffRoles" class="modal-trigger">Set Schedule</a>
            </td>
            </tr>';
        }

        echo $str;

        break;

    case 'GetStaff':
        $symbol = '-';
        $query = mysqli_query($con,"SELECT * FROM staff where id='".setKey('id')."';");
        if($query)
        {
            echo json_encode(mysqli_fetch_assoc($query));
        }

        else
        {
            echo mysqli_errno($con);
        }

        break;

    case 'GetTime':
        $query = mysqli_query($con,"SELECT * from schedules where emp_code='".setKey('code')."';");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'ShowDoctors':
        $query = mysqli_query($con,"SELECT * FROM doctor LEFT JOIN schedules ON doctor.emp_code = schedules.emp_code;");
        $shift_str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $shift_str.= '
            <tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['emp_code'].'</td>
            <td>'.$row['specialization'].'</td>
            <td><input type="time" style="border:none;" value="'.($row['starting_time']).'" readonly /></td>
            <td><input type="time" style="border:none;" value="'.$row['ending_time'].'" readonly /></td>
            </tr>';
            //On Pending... First We Need To Create The Doctor Panel..
        }

        echo $shift_str;

        break;

    case 'ShowDoctorss':
        $query = mysqli_query($con,"SELECT * FROM doctor LEFT JOIN schedules ON doctor.emp_code = schedules.emp_code;");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'SubmitShift':
        $query = mysqli_query($con,"SELECT * FROM schedules WHERE emp_code='".setKey('code')."';");
        $get_email = mysqli_query($con,"select email from staff where emp_code='".setKey('code')."';");
        $UserEmail = mysqli_fetch_assoc($get_email);
        $email = new \Pro\Emailing();
        if(mysqli_num_rows($query)==0)
        {
            $query = mysqli_query($con,"INSERT INTO schedules(emp_code,starting_time,ending_time) values('".setKey('code')."','".setKey('stime')."','".setKey('etime')."');");     
            if($query)
            {
                if($email->SendEmail($UserEmail['email'],'Shift Schedule','Your Shift Schedule Have Been Planned By '.$get_data['emp_code'].' ('.$get_data['name'].'). Following Is Your Shift Schedule..<br/> <table border="2"><thead><tr><th>Starting From</th><th>Ending At</th></tr></thead><tbody><td>'.setKey('stime').'</td><td>'.setKey('etime').'</td></tbody></table>'))
                {
                    echo 1;
                }
            }
        }

        else
        {
            $query = mysqli_query($con, "UPDATE schedules SET starting_time='" . setKey('stime') . "',ending_time='" . setKey('etime') . "' where emp_code='" . setKey('code') . "';");
            if($query)
            {
                if($email->SendEmail($UserEmail['email'],'Updated Shift Schedule','Your Shift Schedule Have Been Updated By '.$get_data['emp_code'].' ('.$get_data['name'].'). Following Is Your Shift Schedule..<br/> <table border="2"><thead><tr><th>Starting From</th><th>Ending At</th></tr></thead><tbody><td>'.setKey('stime').'</td><td>'.setKey('etime').'</td></tbody></table>'))
                {
                    echo 1;
                }
            }
        }

       // echo mysqli_errno($con);
        break;
}

?>