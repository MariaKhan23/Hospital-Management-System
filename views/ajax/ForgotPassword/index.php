<?php

require_once '../../connection/connection.php';

require_once '../../connection/connection.php';
require_once '../../Email.php';
require_once '../vendor/autoload.php';

session_start();

$case = $_GET['case'];

switch($case)
{
    case 'CheckEmail':
        $query = mysqli_query($con,"select * from staff where email='".$_REQUEST['email']."';");
        
        if(mysqli_num_rows($query)>0)
        {
            $mail = new \Pro\Emailing();

            $random_number = mt_rand(1000, 9999);
            $a = $random_number;
            if($mail->SendEmail($_REQUEST['email'],'Email Verification','Your Email Verification Code Is '.$a))
            {
                $_SESSION['email_code'] = $a;
                echo 1;
            }

        }

        else
        {
            echo 2;
        }

        break;

    case 'ChangePass':
        $query = mysqli_query($con,"update staff set pasword='".$_REQUEST['pass']."' where email='".$_REQUEST['email']."';");

        if($query)
        {
            echo 1;
        }

        break;    

    case 'VerifyCode':
        
        if($_REQUEST['code']==$_SESSION['email_code'])
        {
            echo 1;
        }

        else
        {
            echo 2;
        }

        break;
}

?>