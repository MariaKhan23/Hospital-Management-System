<?php

require_once '../../connection/connection.php';


function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

session_start();
$code_query = mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';");
$code_data = mysqli_fetch_array($code_query);
$code = $code_data[0];

switch ($case) {
    case 'GetPatients':
        $query = mysqli_query($con,"select created_by,mrno,name,age from patient where consult_to='".$code."' and flag=0 order by id desc;");

        $patient_str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $patient_str .= "
            <tr>
            <td>".$row['mrno']."</td>
            <td>".$row['name']."</td>
            <td>".$row['age']."</td>
            <td>".$row['created_by']."</td>
            <td>
            <button id='".$row['mrno']."' onclick='SetMedicines(this)' class='btn small btn-sm blue'>Manage Prescription</button>
            <button id='".$row['mrno']."' onclick='SetLabTest(this)' class='btn small btn-sm green'>Manage Lab Tests</button>
            <a id='".$row['mrno']."' onclick='SetAdmission(this)' class='btn modal-trigger small btn-sm magenta' href='#modalData'>Admit Request</a>
            </td>
            </tr>";
        }

        echo $patient_str;

        break;

    case 'SendRequest':
        $q = mysqli_query($con,"insert into patient_recieving(mrno,name,age,ward,is_admitted) values('".setKey('mr')."','".setKey('name')."',".setKey('age').",'".setKey('ward')."',0);");
        
        if($q)
        {
            
            $q_ = mysqli_query($con,"update patient set flag=1 where mrno='".setKey('mr')."';");
            
            if($q_)
            {
                echo 1;
            }
        }

        break;
}

?>