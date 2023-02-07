<?php

$con = mysqli_connect("localhost", "root", "", "hospital");
$query_ = mysqli_query($con, "select * from items;");
$str = '';
while ($row = mysqli_fetch_assoc($query_)) {
    $str .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}


echo $str;
