<?php
session_start();

if (isset($_POST['update_economic_code']) && $_SESSION["flag"] == "ok") {

    require("config/connection.php");
    
$msg = $_GET['msg_update'];

$update_economic_code1 = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg") or die(mysqli_error($conn));

$update_code1=mysqli_fetch_array($update_economic_code1);

        $code_no = $_POST["code_no"];
        $code_name = mysqli_real_escape_string($conn,$_POST["code_name"]);
        $code_no_bn = $_POST["code_no_bn"];
        $code_name_bn = $_POST["code_name_bn"];
        $head_office = @$_POST["head_office"];
        if($head_office==''){
            $head_office = 0;
        }
        
        $zone_office = @$_POST["zone_office"];
        if($zone_office==''){
            $zone_office = 0;
        }
        
        $circle_office = @$_POST["circle_office"];
        if($circle_office==''){
            $circle_office = 0;
        }
        
        $division_office = @$_POST["division_office"];
        if($division_office==''){
            $division_office=0;
        }
        
        $training_academy = @$_POST["training_academy"];
        if($training_academy==''){
            $training_academy=0;
        }

//$msg_success = "The contract has been removed successfully";
    
    //$remove_status1 = 2;
    

        $query_update = "UPDATE tbl_code
                 SET 
                        `CodeNo` = '{$code_no}',
                        `CodeName` = '{$code_name}',
                        `CodeNoBN` = '{$code_no_bn}',
                        `CodeNameBN` = '{$code_name_bn}',
                        `head_office` = '{$head_office}',
                        `zone_office` = '{$zone_office}',
                        `circle_office` = '{$circle_office}',
                        `division_office` = '{$division_office}',
                        `training_academy` = '{$training_academy}'
                        
                        WHERE ID = $msg " ;

        $update_code = mysqli_query($conn, $query_update);

        //echo $query_update;

        $msg_success = "The code has been updated successfully!";

        header("Location: add_economic_code.php?msg_code=".$update_code1['parent_id']."&msg_update=".$msg."&msg_success=".$msg_success);

    }




    if (isset($_POST['update_wages']) && $_SESSION["flag"] == "ok") {

    require("config/connection.php");

    $msg_update = @$_GET['msg_update'];
    $msg = @$_GET['msg'];


    $add_requisition = mysqli_query($conn, "select tp.id, tp.category_id, tc.CodeNameBN, substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) as code_id from tbl_process as tp join numbers as num on char_length(tp.code_id) - char_length(replace(tp.code_id, ',', '')) >= num.n - 1 join tbl_code as tc on tc.ID= substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) where tp.id=$msg") or die(mysqli_error($conn));



        $emp_id = $_POST['emp_id'];
        $remarks = $_POST['remarks'];
        

        $user_id = $_SESSION["UserID"];
        //$OfficeID = $_SESSION["OfficeID"];
  
    
        $tbl_process1 = mysqli_query($conn, "SELECT * from tbl_process where id = $msg") or die(mysqli_error($conn));

    while($process1=mysqli_fetch_array($tbl_process1)){

        $process_name = $process1['process_name'];
        $table_name = $process1['table_name'];
    }


    /*$add_requisition = mysqli_query($conn, "select tp.id, tp.category_id, tc.CodeNameBN, substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) as code_id from tbl_process as tp join numbers as num on char_length(tp.code_id) - char_length(replace(tp.code_id, ',', '')) >= num.n - 1 join tbl_code as tc on tc.ID= substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) where tp.id=$msg") or die(mysqli_error($conn));*/
        

        $office_id = 22;
        $order_id = 0;

        $tbl_dynamic2 = mysqli_query($conn, "SELECT dynamic.* from $table_name as dynamic where dynamic.ID = $msg_update") or die(mysqli_error($conn));

        $dyn2 = mysqli_fetch_array($tbl_dynamic2);


            $insert_date = $dyn2['InsertDate'];
       
        $update_date = date("Y-m-d");

        $salaryQuery = "UPDATE $table_name 
                    SET";

            foreach($add_requisition as $ar){

                /*$code_id = $ar['code_id'];
                $id1 = $ar['id'];
                $code_names = $ar['CodeNameBN'];*/

                //for($i=0; $i<$count;$i++){?>

                    <td hidden><?php $code_id1 = $ar['code_id'];?></td>
                    <td hidden><?php $code_names = $ar['CodeNameBN'];?></td>
                    <td hidden><?php $salary = $_POST["salary$code_id1"];?></td>

                <td hidden><?php $salaryQuery .= "`$code_names` = '{$salary}',";?></td> 
          
           <?php }
            //}


            $salaryQuery .= "
                        `EmpID` = '{$emp_id}',
                        `OfficeID` = '{$office_id}',
                        `OrderID` = '{$order_id}',
                        `InsertDate` = '{$insert_date}',
                
                        `UpdateDate` = '{$update_date}',
                        `Remarks` = '{$remarks}'

                        WHERE ID = $msg_update

            "; 

        

        $add_salary = mysqli_query($conn, $salaryQuery);


    //}



        /*$lastID = $connection->lastInsertID();
        $contract_id=$lastID;*/


            $msg_success = "The salaries of the employee has been updated successfully!";
    //echo $salaryQuery;
        header("Location: add_requisition_salary.php?msg=".$msg."&msg_success=".$msg_success);





}

?>