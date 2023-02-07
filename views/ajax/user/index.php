<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

switch ($case) {
    case 'CheckData':
        $query = mysqli_query($con,"select * from staff where email='".setKey('email')."' and contactinfo='".setKey('contact')."' and cnic='".setKey('cnic')."';");
        if(mysqli_num_rows($query)==1)
        {
            echo 1;
        }

        else
        {
            echo 0;
        }

        break;

    case 'SetPassword':
        $query = mysqli_query($con,"update staff set pasword='".setKey('pass')."' where email='".setKey('email')."';");
        if($query)
        {
            echo 1;
        }
        
        break;
}
