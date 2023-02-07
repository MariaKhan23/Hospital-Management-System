<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

switch($case)
{
    case 'GetSpecialization':
        $query = mysqli_query($con,"select emp_code,specialization from doctor where emp_code='".setKey('code')."';");

        $data = mysqli_fetch_assoc($query);

        echo '<tr><td>'.$data['emp_code'].'</td><td>'.$data['specialization'].'</td></tr>';

        break;
}

?>