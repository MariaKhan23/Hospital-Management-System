<?php

session_start();

require_once '../../connection/connection.php';

function setKey($key)
{
    return $_REQUEST[$key];
}

$case = setKey('case');

$get_user_code = mysqli_fetch_assoc(mysqli_query($con,"select emp_code from staff where email='".$_SESSION['email']."' or cnic='".$_SESSION['email']."';"));

$get_user_designation_and_ward = mysqli_query($con,"select designation,ward from staff_roles where emp_code='".$get_user_code['emp_code']."'");
$user_designation_and_ward = mysqli_fetch_assoc($get_user_designation_and_ward);

switch ($case) {
    case 'GetAdmittedPatients':
        $query = mysqli_query($con,"select patient_recieving.mrno,patient_recieving.name,patient_recieving.age,patient.contactinfo,patient.cnic from patient_recieving inner join patient on patient.mrno=patient_recieving.mrno where ward='".$user_designation_and_ward['ward']."' and is_admitted=1;");

        $str = '';

        while ($a = mysqli_fetch_assoc($query)) {
            $str .= '
            <tr>
            <td>'.$a['mrno'].'</td>
            <td>'.$a['name'].'</td>
            <td>'.$a['age'].'</td>
            <td>'.(empty($a['contactinfo'])?"---":$a['contactinfo']).'</td>
            <td>'.(empty($a['cnic'])?"---":$a['cnic']).'</td>
            <td>';

          //  if($a['OutMR']==null)
            {
                $str.='<button class="btn cyan darken-2" id="'.$a['mrno'].'" onclick="SetDossage(this)">Manage Dossage</button>
                </td>
                </tr>';
            }

        }

        echo $str;

        break;

    case 'GetDosage':
        $query = mysqli_query($con,"select * from dosage where mrno='".setKey('mrno')."';");
        $id = mysqli_fetch_assoc($query);

        if($id==null)
        {
            echo 2;
        }

        else
        {
            $dataQuery = mysqli_query($con,"select * from dosage_master where dosage_id=".$id['id'].";");
    
            $abc = '';
    
            if(mysqli_num_rows($dataQuery)>0)
            {
                while($row = mysqli_fetch_assoc($dataQuery))
                {
                    $abc .= '<tr>
                    <td>'.$row['item'].'</td>
                    <td>';
                    
                    if($abc['dosage']==1)
                    {
                        $abc .= 'OD(1)';
                    }
        
                    if($abc['dosage']==2)
                    {
                        $abc .= 'BD(2)';
                    }
        
                    if($abc['dosage']==3)
                    {
                        $abc .= 'TDS(3)';
                    }
        
                    if($abc['dosage']==4)
                    {
                        $abc .= 'QID(4)';
                    }
        
                    $abc.='</td>
                    </tr>';
                }
            }

            echo $abc;
        }

        break;    

    case 'SendPatient':
        $query = mysqli_query($con,"insert into dosage(mrno,name,age,is_issued,created_at) values('".setKey('mrno')."','".setKey('name')."',".setKey('age').",0,'".date("Y-m-d H:i:s")."');");

        if($query)
        {
            echo mysqli_insert_id($con);
        }

        break;

    case 'SendItems':
        $query = mysqli_query($con,"insert into dosage_master(dosage_id,item,dosage) values(".setKey('id').",'".setKey('name')."',".setKey('dosage').");");
       
        if($query)
        {
            $q = mysqli_query($con,"update dosage set is_issued=1 where id=".setKey('id').";");
            if ($q)
                echo 1;
            // echo 1;
        }

        else
        {
            echo mysqli_errno($con,);
        }
       
        break;    

    case 'GetOneItem':
        $query = mysqli_query($con,"select * from items where id=".setKey('id').";");
        $items = '';

        while($row = mysqli_fetch_assoc($query))
        {
            $items .= '<tr>
            <td>' . $row['name'] . '</td>
            <td>' . $row['generic'] . '</td>
            <td>' . $row['strength'] . '</td>
            <td>';
            if(setKey('dosage')==1)
            {
                $items .= 'OD (1)';
            }

            if(setKey('dosage')==2)
            {
                $items .= 'BD (2)';
            }

            if(setKey('dosage')==3)
            {
                $items .= 'TDS (3)';
            }

            if(setKey('dosage')==4)
            {
                $items .= 'QID (4)';
            }
            $items.='</td>
            <td>
            <button onclick="RemoveItem(this)" class="btn red">Remove</button>
            </td>
            </tr>';
        }

        echo $items;

        break;
}

?>