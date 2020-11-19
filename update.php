<?php
session_start();

if (isset($_POST['update_economic_code']) && $_SESSION["flag"] == "ok") {

    require("config/connection.php");
    
$msg = $_GET['msg_update'];

$update_economic_code1 = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg") or die(mysqli_error($conn));

$update_code1=mysqli_fetch_array($update_economic_code1);

        $code_no = $_POST["code_no"];
        $code_name = $_POST["code_name"];
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

?>