<?php

session_start();

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

$get_user_code = mysqli_fetch_assoc(mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';"));

$get_user_designation_and_ward = mysqli_query($con,"select designation,ward from staff_roles where emp_code='".$get_user_code['emp_code']."'");
$user_designation_and_ward = mysqli_fetch_assoc($get_user_designation_and_ward);

switch ($case) {
    case 'GetInPatients':
        $query = mysqli_query($con,"select * from patient_outcome;");
        $str_ = '';

        if(mysqli_num_rows($query)>0)
        {
            while($row = mysqli_fetch_assoc($query))
            {
                $str_ .= '
                <tr>
                    <td>'.$row['mrno'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['outcome'].'</td>
                    <td>'.$row['outcome_date'].'</td>
                    <td>
                    <a class="btn yellow darken-2 modal-trigger" href="#modalEdit" onclick="SetEdit(this)" id="'.$row['mrno'].'">Edit</a>
                    <a class="btn cyan modal-trigger" href="#modalView" onclick="SetOutcome(this)" id="'.$row['mrno'].'">View</a>
                    </td>
                </tr>';
            }
        }

        else
        {
            $str_ = '';
        }


        echo $str_;

        break;

    case 'GetPatientData':
        $query = mysqli_query($con,"select * from patient_recieving where is_admitted=1 and mrno='".setKey('mr')."';");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'SaveOutcome':
        $query = mysqli_query($con,"insert into patient_outcome(mrno,outcome,outcome_date,final_notes,name,submit_by) values('".setKey('mr')."','".setKey('outcome')."','".setKey('date')."','".setKey('final_notes')."','".setKey('name')."','".$get_user_code['emp_code']."');");

        if($query)
        {
            echo 1;
        }

        else
        {
            mysqli_errno($con);
        }

        break;

    case 'GetData':
        $query = mysqli_query($con,"select * from patient_outcome where mrno='".setKey('mr')."';");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'UpdateOutcome':
        $query = mysqli_query($con,"update patient_outcome set updated_by='".$get_user_code['emp_code']."', outcome='".setKey('outcome')."',final_notes='".setKey('final_notes')."',outcome_date='".setKey('date')."' where mrno='".setKey('mr')."';");
        
        if($query)
        {
            echo 1;
        }
        
        break;
}
