<?php

session_start();

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

$code_query = mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';");
$data_query = mysqli_fetch_assoc($code_query);

switch ($case) {
    case 'SetTest':
        $query = mysqli_query($con,"insert into test(name,description) values('".strtoupper(setKey('name'))."','".strtoupper(setKey('details'))."');");
        echo 1;
        break;

    case 'UpdateTest':
        $query = mysqli_query($con,"update test set name='".strtoupper(setKey('name'))."',description='".strtoupper(setKey('details'))."' where id=".setKey('id')."");
        echo 1;
        break;

    case 'DeleteTest':
        $query = mysqli_query($con,"delete from test where id=".setKey('id').";");
        echo 1;
        break;

    case 'SaveTest':
        $query = mysqli_query($con,"insert into lab_test(mrno,name,lab_test,doctor_code) values('".setKey('mr')."','".setKey('name')."','".setKey('test')."','".$data_query['emp_code']."');");
        if ($query)
            echo 1;
        else
            echo mysqli_errno($con);
        break;    

    case 'GetTest':
        $query = mysqli_query($con,"select * from test order by id desc;");
        $a = '';

        while($row = mysqli_fetch_assoc($query))
        {
            $a.= '<tr>
            <td>LAB-'.$row['id'].'</td>
            <td>'.$row['name'].'</td>
            <td>
            <a onclick="UpdateTest(this)" href="Tests.php?id='.$row['id'].'">EDIT</a> |
            <a onclick="DeleteTest(this)" href="#" id='.$row['id'].'>DELETE</a>
            </td>
            </tr>';
        }

        echo $a;

        break;
}

?>