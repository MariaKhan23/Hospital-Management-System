<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

switch($case)
{
    case 'RegisterDepartment':
        $query = mysqli_query($con,"insert into department(name,description) values('".strtoupper(setKey('name'))."','".setKey('details')."');");
        
        if($query)
        {
            echo 1;
        }

        else
        {
            echo mysqli_errno($con);
        }

        break;

    case 'FetchDepartments':
        $query = mysqli_query($con,"select * from department;");
        $recs = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $recs.= '<tr>
                <td>'.$row['name'].'</td>
                <td>'.$row['description'].'</td>
                <td><a href="Departments.php?id='.$row['id'].'">Edit</a> | <a onclick="DeleteThis(this)" id='.$row['id'].' href="#">Delete</a></td>
            </tr>';
        }
        echo $recs;
    break;

    case 'DeleteDepartment':
        $query = mysqli_query($con,"delete from department where id=".setKey('id').";");
        if($query)
        {
            echo 1;
        }
    break;

    case 'UpdateDepartment':
        $query = mysqli_query($con,"update department set name='".strtoupper(setKey('name'))."', description='".setKey('details')."' where id=".setKey('id').";");
        if($query)
        {
            echo 1;
        }
    break;
}

?>