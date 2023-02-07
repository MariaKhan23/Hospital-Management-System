<?php 

session_start();

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

// $get_user_code = mysqli_fetch_assoc(mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';"));

// $get_user_designation_and_ward = mysqli_query($con,"select designation,ward from staff_roles where emp_code='".$get_user_code['emp_code']."'");
// $user_designation_and_ward = mysqli_fetch_assoc($get_user_designation_and_ward);

switch ($case) {
    case 'GetPatients':
        $query = mysqli_query($con,"select distinct mrno,name,doctor_code,created_at from lab_test;");

        $test = '';

        while($row = mysqli_fetch_assoc($query))
        {
            $test .= '<tr>
            <td>'.$row['mrno'].'</td>
            <td>'.$row['name'].'</td>
            <td>'.$row['doctor_code'].'</td>
            <td>'.$row['created_at'].'</td>
            <td>
            <button class="btn indigo" onclick="ManageResult(this)" id="'.$row['mrno'].'">Manage Results</button>
            </td>
            </tr>';
        }

        echo $test;

        break;
    
    case 'SubmitResults':

      //  $query = mysqli_query($con,"update lab_test set results='' where id=".setKey('id').";");
        print_r($_FILES[setKey('name')]);
        break;

    case 'GenerateResults':
        $query = mysqli_query($con,"select * from lab_test where mrno='".setKey('uid')."';");
   
        if(mysqli_num_rows($query)>0)
        {
            $result_data = mysqli_fetch_assoc($query);
            echo json_encode($result_data);
        }

        else
        {
            echo 0;
        }

        break;
}

?>