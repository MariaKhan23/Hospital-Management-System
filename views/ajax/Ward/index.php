<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return strtoupper($_REQUEST[$key]);
}

$case = $_GET['case'];

switch ($case) {
    case 'RegisterWard':
        $query = mysqli_query($con,"insert into ward(one_day_rent,bednos,name,description,department) values(".setKey('rent').",".setKey('bednos').",'".setKey('name')."','".setKey('details')."','".setKey('department')."');");
        if($query)
        {
            echo 1;
        }
        
        break;

    case 'DeleteWard':
        $query = mysqli_query($con,"delete from ward where id=".setKey('id').";");
        if($query)
        {
            echo 1;
        }
        
        break;

    case 'UpdateWard':
        $query = mysqli_query($con,"update ward set one_day_rent=".setKey('rent').", bednos=".setKey('bednos').", name='".setKey('name')."',description='".setKey('details')."',department='".setKey('department')."' where id=".setKey('id').";");
        
        if($query)
        {
            echo 1;
        }
        
        break;

    case 'FetchWard':
        $query = mysqli_query($con,"select * from ward;");
        $str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $str .= '<tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['bednos'].'</td>
            <td>'.$row['department'].'</td>
            <td>'.$row['one_day_rent'].'</td>
            <td><a href="Wards.php?id='.$row['id'].'">Edit</a> | <a onclick="DeleteThis(this)" href="#" id='.$row['id'].'>Delete</a></td>
            </tr>';
        }

        echo $str;

        break;
}

?>