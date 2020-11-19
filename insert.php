<?php

session_start();

/*insert into contract*/
if (isset($_POST['add_economic_code']) && $_SESSION["flag"] == "ok") {

	require("config/connection.php");

    $msg = @$_GET['msg'];

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
        

        $user_id = $_SESSION["UserID"];
        //$OfficeID = $_SESSION["OfficeID"];
  
    if (isset($msg)) {
        $parent_id = $msg;
    }else{

        $parent_id = 0;
    }
    
    $order_id = 0;
        

        $codeQuery = "INSERT INTO tbl_code 
                    SET 
                        `CodeNo` = '{$code_no}',
                        `CodeName` = '{$code_name}',
                        `CodeNoBN` = '{$code_no_bn}',
                        `CodeNameBN` = '{$code_name_bn}',
                        `head_office` = '{$head_office}',
                        `zone_office` = '{$zone_office}',
                        `circle_office` = '{$circle_office}',
                        `division_office` = '{$division_office}',
                        `training_academy` = '{$training_academy}',
                        `parent_id` = '{$parent_id}',
                        `Order_id` = '{$order_id}'
                        
                      
                ";

        

        $code = mysqli_query($conn, $codeQuery);


    //}



        /*$lastID = $connection->lastInsertID();
        $contract_id=$lastID;*/

        if(isset($msg)){

            $msg_code = "The code has been added successfully!";
    //echo $codeQuery;
        header("Location: add_economic_code.php?msg_code=".$msg."&msg_success=".$msg_code);

        }else{

	$msg_code = "The code has been added successfully!";
    //echo $codeQuery;
	header("Location: add_economic_code.php?msg_success=".$msg_code);

        }

}





if (isset($_POST['btn_process_create']) && $_SESSION["flag"] == "ok") {

    require("config/connection.php");


        $process_id = $_POST["process_id"];
        $code_checkbox = $_POST["code_checkbox"];
        $process_name = $_POST["process_name"];
        $table_name = 'tbl_'.str_replace(' ','_',strtolower($_POST["process_name"]));
        

        //$code_check = array();
        $code_check = implode(',', $code_checkbox);

        $user_id = $_SESSION["UserID"];
        //$OfficeID = $_SESSION["OfficeID"];
  
    /*if (isset($msg)) {
        $parent_id = $msg;
    }else{

        $parent_id = 0;
    }*/
    
    //$order_id = 0;
    $active = 1;
    $non_active = 0;
        

        $processQuery = "INSERT INTO tbl_process 
                    SET 
                        `category_id` = '{$process_id}',
                        `code_id` = '{$code_check}',
                        `process_name` = '{$process_name}',
                        `table_name` = '{$table_name}',
                        `active` = '{$active}'
                        
                      
                ";

        

        $proQuery = mysqli_query($conn, $processQuery);

        $lastID = mysqli_insert_id($conn);
        $p_id=$lastID;


        $tbl_process_tab = mysqli_query($conn, "SELECT * from tbl_process where id <> $p_id") or die(mysqli_error($conn));

        foreach($tbl_process_tab as $pro_tab){

            $pro_id = $pro_tab['id'];

            $activeQuery = "UPDATE tbl_process 
                    SET 
                        
                        `active` = '{$non_active}'

                        WHERE id = $pro_id
                        
                      
                ";

        

        $actQuery = mysqli_query($conn, $activeQuery);
        }



        $add_requisition = mysqli_query($conn, "select id, category_id, substring_index( substring_index(code_id, ',', n), ',', -1 ) as code_id from tbl_process join numbers on char_length(code_id) - char_length(replace(code_id, ',', '')) >= n - 1 where active = 1") or die(mysqli_error($conn));



        $createQuery = "CREATE TABLE $table_name (
                        ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";

        foreach($add_requisition as $requisition){

            $code_id = $requisition['code_id'];
            $id1 = $requisition['id'];

            $createQuery .= "`$code_id ($id1)` FLOAT NOT NULL,";
        } 


        $createQuery .= "EmpID INT(11) NOT NULL,
                        OfficeID INT(11) NOT NULL,
                        OrderID INT(11) NOT NULL,
                        InsertDate Date NOT NULL,
                        UpdateDate Date NOT NULL
                    )";
    
                        
        

        $crtQuery = mysqli_query($conn, $createQuery);


        //echo $createQuery;
    //}



        //echo $activeQuery;

    $msg_success = "The process has been created successfully!";
    //echo $processQuery;
    header("Location: create_process.php?msg_success=".$msg_success);


}


?>