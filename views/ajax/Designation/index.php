<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

switch($case)
{
    case 'RegisterDesignation':
        $query = mysqli_query($con,"insert into designation(name,description) values('".strtoupper(setKey('name'))."','".setKey('details')."');");
        
        if($query)
        {
            echo 1;
        }

        else
        {
            echo mysqli_errno($con);
        }

        break;

    case 'FetchDesignation':
        $query = mysqli_query($con,"select * from designation where name!='Super Admin' order by name;");
        $recs = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $recs.= '<tr>
                <td>'.$row['name'].'</td>
                <td>'.$row['description'].'</td>
                <td><a href="Designations.php?id='.$row['id'].'">Edit</a> | <a onclick="DeleteThis(this)" id='.$row['id'].' href="#">Delete</a></td>
            </tr>';
        }
        echo $recs;
    break;

    case 'DeleteDesignation':
        $query = mysqli_query($con,"delete from designation where id=".setKey('id').";");
        if($query)
        {
            echo 1;
        }
    break;

    case 'UpdateDesignation':
        $query = mysqli_query($con,"update designation set name='".setKey('name')."', description='".setKey('details')."' where id=".setKey('id').";");
        if($query)
        {
            echo 1;
        }
    break;
}

?>