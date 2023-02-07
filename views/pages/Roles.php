<div id="frm">

    <button onclick="ShowForm()" class="btn float-right primary">ADD</button>
    <table class="table table-border table-striped table-borderless w-100">
    <thead>
        <tr>
            <th>Department</th>
            <th>Designation</th>
            <th>Ward</th>
        </tr>
    </thead>
    <tbody>
        
    <?php require_once '../connection/connection.php';
            
            $query = mysqli_query($con,"select * from staff_roles where emp_code='E-".$_GET['uid']."';");
    session_start();
    $_SESSION['key'] = $_GET['uid'];
            if(mysqli_num_rows($query)==0)
            {
                echo "<tr>
        <td colspan='3'>No Roles Has Been Assigned To This Employee..</td>
        <td></td>
        <td></td>
        </tr>";
    }
    
    else
    {
        while($row = mysqli_fetch_assoc($query))
        {
            echo "<tr>
            <td>".$row['department']."</td>
            <td>".$row['designation']."</td>
            <td>".$row['ward']."</td>
            </tr>";
        }
    }
    
    ?>
    </tbody>
</table>

</div>
<script>
    function ShowForm()
    {
      //  alert(134)
        $('#frm').load('../pages/RoleForm.php')
    }
</script>