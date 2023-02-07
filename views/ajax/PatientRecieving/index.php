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
    case 'GetPatient':
        $query = mysqli_query($con, "select * from patient_recieving inner join patient on patient_recieving.mrno=patient.mrno where patient_recieving.ward='".$user_designation_and_ward['ward']."';");
        $b = '';

        while ($row = mysqli_fetch_assoc($query)) {
            $b .= '<tr>
            <td>' . $row['mrno'] . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['age'] . '</td>
            <td>' . $row['gender'] . '</td>
            <td>' . (empty($row['contactinfo'])?"---":$row['contactinfo']) . '</td>
            <td>' . (empty($row['cnic'])?"---":$row['cnic']) . '</td>
            <td>';
            if($row['is_admitted']==0)
            {
                $b.='<button id="' . $row['id'] . '" onclick="SetAdmission(this)" class="btn blue darken-4">Manage Admit Details</button>';
            }

            else
            {
                $b.= '<a id="'.$row['id'].'" onclick="GetDetailsForEdit(this)" href="#modalEdit" class="modal-trigger btn cyan">Edit</a>&nbsp;&nbsp;';
                $b.='<a id="'.$row['id'].'" onclick="GetDetails(this)" href="#modalView" class="modal-trigger btn green">View</a>';
            }

            $b.='</td>
            </tr>';
        }

        echo $b;

        break;

    case 'AdmitPatient':

        $query = mysqli_query($con, "select is_admitted from patient_recieving where id=" . setKey('id') . ";");
        $result_query = mysqli_fetch_assoc($query);

        if ($result_query['is_admitted'] == null) {
            echo 0;
        } else {
            $dataSubmissionQuery = mysqli_query($con, "update patient_recieving set submit_by='".$get_user_code['emp_code']."', bedno=" . setKey('bed') . ",gender='" . setKey('gender') . "', attendant_name='" . setKey('name') . "',attendant_cnic='" . setKey('cnic') . "',attendant_contactinfo='" . setKey('contact') . "', is_admitted=1 where id=" . setKey('id') . ";");
            if ($dataSubmissionQuery) {
                echo 1;
            }
        }

        break;

    case 'GenerateSheet':
        $query = mysqli_query($con, "select mrno,bedno,ward from patient_recieving where is_admitted=1 and ward='" . setKey('ward') . "';");

        $str = '<ul>';

        while ($_row = mysqli_fetch_assoc($query)) {
            $str .= '<li>Bed No: ' . $_row['bedno'] . ' &nbsp;&nbsp; Mr: ' . $_row['mrno'] . '</li>';
        }

        $str .= '</ul>';
        // echo $str;
        if (!$query) {
            echo mysqli_errno($con);
        } else {
            echo $str;
        }

        break;

    case 'GetSingleData':
        $query = mysqli_query($con,"select * from patient left join patient_recieving on patient.mrno=patient_recieving.mrno where patient.mrno='MR-".setKey('mr')."';");
        echo json_encode(mysqli_fetch_assoc($query));
        break;

    case 'UpdateRecieving':
        $query = mysqli_query($con,"update patient_recieving set attendant_name='".setKey('name')."',attendant_contactinfo='".setKey('contactinfo')."',attendant_cnic='".setKey('cnic')."' where mrno='".setKey('mr')."';");
        
        if($query)
        {
            echo 1;
        }

        break;
}
