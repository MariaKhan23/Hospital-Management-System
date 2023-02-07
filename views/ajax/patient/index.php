<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

session_start();
$get_user_code = mysqli_query($con,"select name,emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';");
$user_data = mysqli_fetch_assoc($get_user_code);

switch ($case) {
    case 'RegisterPatient':
        $query = mysqli_query($con,"insert into patient(consult_to,gender,name,age,contactinfo,cnic,flag,created_by) values('".setKey('doctor')."','".setKey('gender')."','".setKey('name')."',".setKey('age').",'".setKey('contactinfo')."','".setKey('cnic')."',0,'".$user_data['emp_code']."');");
        if($query)
        {
            $last_id = mysqli_insert_id($con);
            $query_ = mysqli_query($con,"update patient set mrno='MR-".$last_id."' where id=".$last_id.";");
            if($query_)
            {
                echo 'MR-'.$last_id;
            }

            else
            {
                echo mysqli_errno($con);
            }
        }

        else
        {
            echo mysqli_errno($con);
        }

        break;

    case 'UpdatePatient':
        $query = mysqli_query($con, "update patient set consult_to='".setKey('doctor')."', name='".setKey('name')."',age=".setKey('age').",contactinfo='".setKey('contactinfo')."',cnic='".setKey('cnic')."',gender='".setKey('gender')."' where mrno='".setKey('mrno')."';");
        
        if($query)
        {
            echo 1;
        }

        else
        {
            echo mysqli_errno($con);
        }

        break;

    case 'FetchPatients':
        $query = mysqli_query($con,"select * from patient;");
        $patient_str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $patient_str .= '<tr>
            <td>'.$row['mrno'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['age'].'</td>
            <td>'.$row['gender'].'</td>
            <td>
            <a href="Patients.php?mr='.$row['mrno'].'">Edit</a> |
            <a href="../pages/Reciept.php?mr='.$row['mrno'].'">Print Reciept</a>
            </td>
            </tr>';
        }

        echo $patient_str;

        break;

    case 'GetApprovedAppointments':
        $query = mysqli_query($con,"SELECT appointments.appointment_date,appointments.consult_to,appointments.appointment_time,appointments.name,appointments.age,appointments.contactinfo,appointments.cnic,doctor.name AS Doc FROM appointments LEFT JOIN doctor ON appointments.consult_to=doctor.emp_code WHERE stats=2;");

        $patient = '';

        while($row = mysqli_fetch_assoc($query))
        {
            $patient.= '<tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['age'].'</td>
            <td>'.$row['contactinfo'].'</td>
            <td>'.$row['cnic'].'</td>
            <td>'.$row['consult_to'].' &nbsp;('.$row['Doc'].')</td>
            <td>'.$row['appointment_date'].'</td>
            <td>'.$row['appointment_time'].'</td>
            <td>
            <button onclick="RegisterOnlinePatient(this)" class="btn cyan">Set Data</button>
            </td>
            </tr>';
        }

        echo $patient;

        break;

        case 'GetPendingAppointments':
            $query = mysqli_query($con,"SELECT appointments.appointment_date,appointments.consult_to,appointments.appointment_time,appointments.name,appointments.age,appointments.contactinfo,appointments.cnic,doctor.name AS Doc FROM appointments LEFT JOIN doctor ON appointments.consult_to=doctor.emp_code WHERE stats=0;");
    
            $patient1 = '';
    
            while($row = mysqli_fetch_assoc($query))
            {
                $patient1 .= '<tr>
                <td id="name">'.$row['name'].'</td>
                <td id="age">'.$row['age'].'</td>
                <td id="contactinfo">'.$row['contactinfo'].'</td>
                <td id="cnic">'.$row['cnic'].'</td>
                <td>'.$row['consult_to'].' &nbsp;('.$row['Doc'].')</td>
                <td>'.$row['appointment_date'].'</td>
                <td>'.$row['appointment_time'].'</td>
                <td>
                <a onclick="ManagePendingAppointment(this)" href="#modalPending" class="modal-trigger btn turquoise">Assign Doctor</a>
                </td>
                </tr>';
            }
    
            echo $patient1;
    
            break;

    case 'RegisterNew':
        $query = mysqli_query($con,"insert into patient(name,age,contactinfo,cnic,consult_to,created_by,flag) values('".setKey('name')."',".setKey('age').",'".setKey('contactinfo')."','".setKey('cnic')."','".setKey('doctor')."','".$user_data['emp_code']."',0);");
        
        if($query)
        {
            $mr_id = mysqli_insert_id($con);
            $query = mysqli_query($con,"update patient set mrno='MR-".$mr_id."';");

            if($query)
            {
                echo 1;
            }

            else
            {
                echo mysqli_errno($con);
            }
        }

        else
        {
            echo mysqli_errno($con);
        }
        
        break;
}

?>