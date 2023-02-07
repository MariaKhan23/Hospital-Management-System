<?php

require_once '../connection/connection.php';

?>
    <div class="row">
        <div class="col s6">
            <span>Department</span>
            <select class="select" style="display:block;" name="department" id="txtDepartment">
                <?php
                $query = mysqli_query($con, "select * from department;");
            //    $str = '';
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<option value=" . $row['name'] . ">" . $row['name'] . "</option>";
                }

            
                ?>
            </select>
        </div>
        <div class="col s6">
            Designation
            <select name="designation"  style="display:block;" id="txtDesignation">
                <?php $query = mysqli_query($con, "select * from designation;");

                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<option value=" . $row['name'] . ">" . $row['name'] . "</option>";
                }

              //  echo $str; ?>
            </select>
        </div>
            </div>
            <br><br>
            <div class="row">
        <div class="col s6">
            Ward
            <select name="ward" style="display:block;" id="txtWard">
                <?php $query = mysqli_query($con, "select * from ward;");
            
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<option value=" . $row['name'] . ">" . $row['name'] . "</option>";
                }

               // echo $str; ?>
            </select>
        </div>
        <div class="col s6">
            <button onclick="SaveRoles()" class="btn mt-5 blue">Save</button>
        </div>
    </div>
             <script>
                function SaveRoles()
                {
                    $.ajax({
                        url:"../ajax/Staff?case=SetRoles",
                        type:"GET",
                        data:{
                            department:$('#txtDepartment').val(),
                            designation:$('#txtDesignation').val(),
                            ward:$('#txtWard').val(),
                            emp_code:'E-'+<?php session_start(); echo $_SESSION['key'] ?>
                        },
                        success:function(resp)
                        {
                            console.log(resp)
                           
                            {
                                swal('Success','Roles Have Assigned To The Employee..','success')
                            }
                        }
                    })
                }
             </script>