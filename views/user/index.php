<?php

session_start();

require_once './../connection/connection.php';

if($_SESSION['email']==null)
{
    echo '<script>window.location.href="../login.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - User</title>
    <?php include_once '../include/style.php'; ?>
</head>
<body>

<?php include_once '../include/header.php'; ?>
<?php include_once '../include/userbar.php'; ?>



</body>
<?php include_once '../include/scripts.php'; ?>
</html>