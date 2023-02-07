<?php

require_once '../../connection/connection.php';
require_once '../../Email.php';
require_once '../vendor/autoload.php';

session_start();

function setKey($key)
{
    if($key=='')
    {
        return $_REQUEST;
    }

    else
    {
        return $_REQUEST[$key];
    }
}

$get_code_with_name = mysqli_query($con,"select emp_code,name from staff where email='".$_SESSION['email']."';");
$get_data = mysqli_fetch_assoc($get_code_with_name);

$case = $_GET['case'];

switch ($case) {
    case 'RegisterStaff':
         $query = mysqli_query($con,"insert into staff(name,fname,age,address,contactinfo,cnic,gender,email,stats) values('".setKey('name')."','".setKey('fname')."',".setKey('age').",'".setKey('address')."','".setKey('contactinfo')."','".setKey('cnic')."','".setKey('gender')."','".setKey('email')."','".setKey('status')."')");
        if($query)
        {
            $id = mysqli_insert_id($con);
            mysqli_query($con,"update staff set emp_code='E-".$id."' where id=".$id.";");

            $email = new \Pro\Emailing();

            if($email->SendEmail(setKey('email'),'Account Registration','Your Account Has Successfully Created. Please Register Your Account.'))
            {
                echo 1;
            }

        }
       break;

    case 'UpdateStaff':
        $acc_mail = setKey('email');
        $query = mysqli_query($con,"update staff set name='".setKey('name')."',fname='".setKey('fname')."',age=".setKey('age').",stats=".setKey('status').",address='".setKey('address')."',gender='".setKey('gender')."',email='".setKey('email')."',contactinfo='".setKey('contactinfo')."',cnic='".setKey('cnic')."' where id=".setKey('id').";");
        if($query)
        {
            $umail = new \Pro\Emailing();

            if($umail->SendEmail($acc_mail,'User Profile Updation.','<span>Dear User,</span><br />Your Account Details Have Been Updated By '.$get_data['emp_code'].'('.$get_data['name'].')'))
            {
                echo 1;
            }

        }

        break;

    case 'DeleteStaff':
        $query = mysqli_query($con,"delete from staff where id=".setKey('id').";");

        $get_code_by_id = mysqli_query($con,"select email from staff where id=".setKey('id').";");
        $id_data = mysqli_fetch_assoc($get_code_by_id);

        if($query)
        {
            $uid = new \Pro\Emailing();

            if($uid->SendEmail($id_data['email'],'Account Deletion..','<span>Dear User,</span><br /><b>Your Account Has Been Deleted By '.$get_data['emp_code'].' ('.$get_data['name'].'). Contact Super Admin or Any Other Administration Staff for further query..</b>'))
            {
                echo 1;
            }
        }

        break;    

    case 'SetRoles':
        $query = mysqli_query($con,"select * from staff_roles where emp_code  = '".setKey('emp_code')."';");

        $get_email_with_code = mysqli_query($con,"select email from staff where emp_code='".setKey('emp_code')."';");
        $get_user_email = mysqli_fetch_assoc($get_email_with_code);

        if(mysqli_num_rows($query)==1)
        {
            $query_ = mysqli_query($con,"update staff_roles set department='".setKey('department')."',designation='".setKey('designation')."',ward='".setKey('ward')."' where emp_code='".setKey('emp_code')."';");
            if($query_)
            {
                $emails = new \Pro\Emailing();

                if($emails->SendEmail($get_user_email['email'],'Roles/Designation Assesment','Dear User,<br />New Roles Have Been Assigned To You By '.$get_data['emp_code'].' ('.$get_data['name'].').<br /><table border="2"><thead><tr><th>Department</th><th>Designation</th><th>Ward</th></tr></thead><tbody><td>'.setKey('department').'</td><td>'.setKey('designation').'</td><td>'.setKey('ward').'</td></tbody></table>'))
                {
                    echo 2;
                }

            }

            else
            {
                echo mysqli_errno($con);
            }
        }

        else
        {
            $query = mysqli_query($con,"insert into staff_roles(emp_code,department,designation,ward) values('".setKey('emp_code')."','".setKey('department')."','".setKey('designation')."','".setKey('ward')."');");
            if($query)
            {
                $emails = new \Pro\Emailing();

                if($emails->SendEmail($get_user_email['email'],'Roles/Designation Assesment','Dear User,<br />New Roles Have Been Assigned To You By '.$get_data['emp_code'].' ('.$get_data['name'].').<br /><table border="2"><thead><tr><th>Department</th><th>Designation</th><th>Ward</th></tr></thead><tbody><td>'.setKey('department').'</td><td>'.setKey('designation').'</td><td>'.setKey('ward').'</td></tbody></table>'))
                {
                    echo 1;
                }
            }

            else
            {
                echo mysqli_errno($con);
            }
        }

        break;

    case 'ChangePassword':
        $query = mysqli_query($con,"update staff set pasword='".md5(setKey('pasword'))."' where email='".$_SESSION['email']."';");
        break;

    case 'SetDoctor':
        $query = mysqli_query($con,"select * from doctor where emp_code='".setKey('code')."';");
        $count = mysqli_num_rows($query);

        if($count==1)
        {
            $query = mysqli_query($con,"update doctor set specialization='".setKey('specialization')."' where emp_code='".setKey('code')."';");
        }

        else
        {
            $query = mysqli_query($con,"insert into doctor(name,emp_code,specialization) values('".setKey('name')."','".setKey('code')."','".setKey('specialization')."');");
        }

        
        if($query)
        {
            echo 1;
        }

        break;

    case 'FetchStaff':
        $query = mysqli_query($con,"select * from staff where id>1 order by id desc;");
        $str = '';
        while($row = mysqli_fetch_assoc($query))
        {
            $str .= '<tr>
            <td>'.$row['emp_code'].'</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['fname'] . '</td>
            <td>' . $row['gender'] . '</td>
            <td>'.$row['contactinfo'].'</td>
            <td>'.$row['cnic'].'</td>
            <td>';
            if($row['stats']==1)
            {
                $str.= '<span class="badge " style="color:#00c853;">Active</span>';
            }

            else
            {
                $str.='<span class="  badge  " style="color:#d50000;">InActive</span>';
            }

            $str.='</td>
            <td>
            <a href="Staff.php?id='.$row['id'].'">Edit</a> |
            <a id="'.$row['id'].'" class="modal-trigger waves-effect waves-light" onclick="GenerateRoles(this)" href="#modalStaffRoles">Set Roles</a> |
            <a id="'.$row['id'].'" onclick="DeleteStaff(this)" href="#">Delete</a>
            </td>
            </tr>';
        }

        echo $str;

        break;
}

?>