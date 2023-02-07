<?php

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = $_GET['case'];

session_start();

$get_user_code = mysqli_query($con,"select * from staff where email='".$_SESSION['email']."';");
$user_code = mysqli_fetch_assoc($get_user_code);

switch ($case) {
    case 'GenerateViews':
        $query = mysqli_query($con,"select * from views;");

        $check_str = '';

        while($row = mysqli_fetch_assoc($query))
        {
            $check_str .= "<tr>
            <td>".$row['view_name']."</td>
            <td><label><input type='checkbox'";
            $check_str.="id='".$row['id']."' /><span></span></label>
            </td>
            </tr>";
            
            // print_r($view_array);
        }
        
        echo $check_str;

        break;

    case 'Delete':
        $query = mysqli_query($con,"delete from allowed_views where emp_code='".setKey('uid')."';");
        break;    

    case 'Save':
        $query = mysqli_query($con,"select * from views where id=".setKey('vid').";");
        $view_name = mysqli_fetch_assoc($query);

        if($query)
        {
            $a_query = mysqli_query($con,"insert into allowed_views(emp_code,view_name,is_allowed) values('".setKey('uid')."','".$view_name['view_name']."',".setKey('allow').");");

            if($a_query)
            {
                echo 1;
            }
        }

        break;
}


function GetCheck($view,$connection)
{
    //$view_array = array();
    $view_query = mysqli_query($connection,"SELECT * FROM allowed_views where emp_code='".setKey('uid')."';");
    //$total_allowed_views = mysqli_num_rows($view_query);

    while($arr_view = mysqli_fetch_array($view_query))
    {
    //    for ($i=0; $i <$total_allowed_views ; $i++) { 
            if($arr_view['view_name']==$view)
            {
                return 'checked';
            }
        
    }
}

?>