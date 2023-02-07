<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

switch ($case) {
    case 'RegisterItem':
        $query = mysqli_query($con,"insert into items(unit_price,name,generic,description,strength) values(".setKey('price').",'".setKey('name')."','".setKey('generic')."','".setKey('description')."','".setKey('strength')."');");
        if ($query)
            echo 1;
        break;

    case 'UpdateItem':
        $query = mysqli_query($con,"update items set unit_price=".setKey('price').", strength='".setKey('strength')."', name='".setKey('name')."',generic='".setKey('generic')."',description='".setKey('details')."' where id=".setKey('id').";");
        if ($query)
            echo 1;
        break;

    case 'DeleteItem':
        $query = mysqli_query($con,"delete from items where id=".setKey('id').";");
        if ($query)
            echo 1;
        break;

    case 'FetchItems':
        $query = mysqli_query($con,"select * from items order by id desc;");
        $items = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $items .= '<tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['strength'].'</td>
            <td>'.$row['generic'].'</td>
            <td>Rs.'.$row['unit_price'].'</td>
            <td>
            <a id="'.$row['id'].'" href="Items.php?id='.$row['id'].'">Edit</a> |
            <a id="'.$row['id'].'" href="#" onclick="DeleteItem(this)">Delete</a>
            </td>
            </tr>';
        }

        echo $items;

        break;
}


?>