<?php

session_start();

error_reporting(0);

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

$get_user_code = mysqli_fetch_assoc(mysqli_query($con, "select emp_code from staff where email='" . $_SESSION['email'] . "' or cnic='" . $_SESSION['email'] . "';"));

$get_user_designation_and_ward = mysqli_query($con, "select designation,ward from staff_roles where emp_code='" . $get_user_code['emp_code'] . "'");
$user_designation_and_ward = mysqli_fetch_assoc($get_user_designation_and_ward);

switch ($case) {
    case 'CreateAppointment':

        $query1 = mysqli_query($con, "select name,contactinfo from appointments where cnic='" . setKey('cnic') . "';");

        if (mysqli_num_rows($query1) > 0) {
            $data = mysqli_fetch_assoc($query1);

            if ($data['name'] != setKey('name') || $data['contactinfo'] != setKey('contactinfo')) {
                echo 12;
            }
        } else {
            $query = mysqli_query($con, "insert into appointments(consult_to,name,age,contactinfo,cnic,appointment_date,appointment_time,stats) values('" . setKey('doctor') . "','" . strtoupper(setKey('name')) . "'," . setKey('age') . ",'" . setKey('contactinfo') . "','" . setKey('cnic') . "','" . setKey('date') . "','" . setKey('time') . "',0);");

            if ($query) {
                echo 1;
            } else {
                echo mysqli_errno($con);
            }
        }

        break;

    case 'GetAppointments':
        $query = mysqli_query($con, "select appointments.id,appointments.name as MyName,appointments.age,appointments.cnic,staff.name,appointments.appointment_date,appointments.appointment_time,appointments.stats from appointments left join staff on appointments.consult_to=staff.emp_code where appointments.cnic='" . setKey('cnic') . "' or appointments.stats=0;");
        $str = '';
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $str .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['MyName'] . '</td>
                <td>' . $row['age'] . '</td>
                <td>' . $row['cnic'] . '</td>
                <td>' . $row['appointment_date'] . '</td>
                <td>' . $row['appointment_time'] . '</td>
                <td>DR-' . $row['name'] . '</td>
                <td>';
                if ($row['stats'] == 0) {
                    $str .= '<span style="color:cyan;">Pending</span>';
                    $str .= '</td>
                    <td>
                    <button id="' . $row['id'] . '" class="btn red" onclick="DeleteAppointment(this)">Delete Appointment</button>
                    </td>
    
                    </tr>';
                } else if ($row['stats'] == 1) {
                    $str .= '<span style="color:#dc3545;">Rejceted</span></td><td>----</td>';
                } else {
                    $str .= '<span style="color:#198754;">Approved</span></td><td>----</td>';
                }
            }

            echo $str;
        } else {
            echo 0;
        }

        break;

    case 'Delete':
        $query = mysqli_query($con, "delete from appointments where id=" . setKey('id') . ";");

        if ($query) {
            echo 1;
        }

        break;

    case 'GetDoctors':
        $query = mysqli_query($con, "SELECT staff.emp_code,staff.name,schedules.starting_time,schedules.ending_time,doctor.specialization FROM staff LEFT JOIN schedules ON staff.emp_code=schedules.emp_code INNER JOIN doctor ON schedules.emp_code=doctor.emp_code;");

        $a = '';
        while ($row = mysqli_fetch_assoc($query)) {
            $a .= '<tr>
            <td>' . $row['emp_code'] . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['specialization'] . '</td>
            <td>' . $row['starting_time'] . '</td>
            <td>' . $row['ending_time'] . '</td>
            </tr>';
        }

        echo $a;

        break;

    case 'ApproveAppointment':
        $query = mysqli_query($con,"update appointments set stats=2 where id=".setKey('id').";");
        echo 1;
        break;

    case 'RejectAppointment':
        $query = mysqli_query($con,"update appointments set stats=1 where id=".setKey('id').";");
        echo 1;
        break;  
        
    case 'FetchPatients':
        $query = mysqli_query($con, "select * from appointments where stats=0 and consult_to='" . $get_user_code['emp_code'] . "';");

        $my_str = '';

        while ($row = mysqli_fetch_assoc($query)) {
            $my_str .= '<tr>
            <td>' . $row['name'] . '</td>
            <td>' . $row['age'] . '</td>
            <td>' . $row['contactinfo'] . '</td>
            <td>' . $row['cnic'] . '</td>
            <td>' . $row['appointment_time'] . '</td>
            <td>' . $row['appointment_date'] . '</td>
            <td>
            <button class="btn green"  id='.$row['id'].' onclick="Approve(this)">Approve</button>
            <button class="btn red" id='.$row['id'].' onclick="Reject(this)">Reject</button>
            </td>
            </tr>';
        }

        echo $my_str;

        break;
}
