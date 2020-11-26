<?php 
session_start();

if ($_SESSION['flag']=='ok') {

    include("config/connection.php");

    $msg = $_GET['msg'];

    $tbl_process = mysqli_query($conn, "SELECT * from tbl_process where id = $msg") or die(mysqli_error($conn));

    while($process=mysqli_fetch_array($tbl_process)){

        $process_name = $process['process_name'];
        $table_name = $process['table_name'];
    }

    $query_requisition_salary = "select tp.id, tp.category_id, tc.CodeNameBN, substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) as code_id from tbl_process as tp join numbers as num on char_length(tp.code_id) - char_length(replace(tp.code_id, ',', '')) >= num.n - 1 join tbl_code as tc on tc.ID= substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) where tp.id = $msg";

    $add_requisition_salary_table1 = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));


    /*foreach($add_requisition_salary_table1 as $arst){

        $code_name_bn = $arst['CodeNameBN'];
    }*/

    $employee = mysqli_query($conn, "SELECT ".DBHR.".hrpersonnel.FullName,".DBHR.".hrpersonnel.EmpID from ".DBHR.".hrpersonnel") or die(mysqli_error($conn));


     $tbl_dynamic = mysqli_query($conn, "SELECT dynamic.*,".DBHR.".hrpersonnel.FullName from $table_name as dynamic left outer join ".DBHR.".hrpersonnel on ".DBHR.".hrpersonnel.EmpID = dynamic.EmpID") or die(mysqli_error($conn));


    $tbl_category = mysqli_query($conn, "SELECT tp.*,tc.* from tbl_process as tp, tbl_category as tc where tc.id = tp.category_id and tp.id = $msg") or die(mysqli_error($conn));

    while($category=mysqli_fetch_array($tbl_category)){

        $category_name = $category['category_name'];
    }


    /*$query = "SELECT       
                            ".DBHR.".hrpersonnel.GradationNo,
                            ".DBHR.".hrpersonnel.EmpID,
                            ".DBHR.".hrpersonnel.FullName,
                            ".DBHR.".hrpersonnel.OffEmail,
                            ".DBHR.".hrtdesignation.DesignationName,
                            ".DBHR.".hrtdesignation.DesignationID,
                            ".DBHR.".hrtoffice.OfficeName,
                            ".DBHR.".hrtoffice.OfficeID,
                            ".DBHR.".hrtpost.PostID,
                            ".DBHR.".hrposting.PostingID,
                            ".DBHR.".hrofficial.JobStatusRemarks,
                            ".DBHR.".hrofficial.JobStatusID,
                            ".DBHR.".hrjobstatus.JobStatus
                        FROM
                            
                            ".DBHR.".hrpersonnel   
                            INNER JOIN ".DBHR.".hrofficial ON ".DBHR.".hrpersonnel.EmpID=".DBHR.".hrofficial.EmpID 
                            LEFT JOIN ".DBHR.".hrtpost ON ".DBHR.".hrtpost.EmpID = ".DBHR.".hrpersonnel.EmpID
                            LEFT JOIN ".DBHR.".hrposting ON ".DBHR.".hrposting.PostID = ".DBHR.".hrtpost.postID
                            LEFT JOIN ".DBHR.".hrtdesignation ON ".DBHR.".hrtdesignation.DesignationID=".DBHR.".hrofficial.CurrentDesignationID
                            LEFT JOIN ".DBHR.".hrtoffice ON ".DBHR.".hrtoffice.OfficeID = ".DBHR.".hrtpost.OfficeID
                            LEFT JOIN ".DBHR.".hrjobstatus ON ".DBHR.".hrjobstatus.ID = ".DBHR.".hrofficial.JobStatusID
                        WHERE ".DBHR.".hrofficial.JobStatusID!=2 AND ".DBHR.".hrofficial.JobStatusID!=3 AND ".DBHR.".hrofficial.JobStatusID!=4 AND ".DBHR.".hrofficial.JobStatusID!=10 AND ".DBHR.".hrofficial.JobStatusID!=15
                        
                        AND ".DBHR.".hrpersonnel.OrderID!=0
                        AND ".DBHR.".hrtoffice.OfficeID=22
                        ORDER BY ".DBHR.".hrpersonnel.EmpID ASC;";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));*/

   /*$msg_code = @$_GET['msg_code'];

   if (isset($msg_code)) {

    $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = $msg_code") or die(mysqli_error($conn));

    $add_economic_code_name = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg_code") or die(mysqli_error($conn));

    }else{

        $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = 0") or die(mysqli_error($conn));

    }*/
    $add_requisition_salary_table = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));

    $add_requisition_salary_table2 = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));



    
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fund Requisition & Management System</title>
    <meta name="description" content="Human Resource Information System">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <?php include 'css_master.php';?>

</head>

<body>


    <?php include 'sidebar.php';?>

  

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php include 'navbar.php';?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Category: <?=$category_name?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            

                            <li class="active">Process</li>
                       
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><?=$process_name?></strong>
                                <form action="add_requisition_salary.php?msg=<?=$msg?>&msg_add_new=<?php echo uniqid($msg);?>" method="post" class="form-horizontal">
                                <button class="btn btn-primary btn-sm" name="add_new_salary" style="float: right;border-radius: 6px;margin-top: -19px">Add New</button>
                                </form>
                            </div>
                            <div class="card-body">

                                <!-- update salary starts -->

                                <?php if(isset($_POST['btn_update_salary'])){

                                    $msg_update = $_GET['msg_update'];

                                    ?>

                                    <form action="update.php?msg=<?=$msg?>&msg_update=<?=$msg_update?>" method="post">

                                        <?php $tbl_dynamic1 = mysqli_query($conn, "SELECT dynamic.* from $table_name as dynamic where dynamic.ID = $msg_update") or die(mysqli_error($conn));

                                                $dyn = mysqli_fetch_array($tbl_dynamic1);

                                                ?>

                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="select" class=" form-control-label">Employee Name<span style="color: red">*</span></label></div>
                                        <div class="col-12 col-md-9">
                                            <select name="emp_id" id="emp_id" class="form-control" required>
                                                <option value="">Choose Employee</option>

                                    

                                                <?php while($emp=mysqli_fetch_array($employee)){?>
                                                <option value="<?=$emp['EmpID']?>" <?php if($dyn['EmpID']==$emp['EmpID']){echo 'selected';}?>><?=$emp['FullName']?></option>
                                            <?php }?>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <?php while($requisition2=mysqli_fetch_array($add_requisition_salary_table2)){

                                    ?>
                                    <td hidden><?php $code_name_bn1 = $requisition2['CodeNameBN'];?></td>

                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label"><?=$requisition2['CodeNameBN']?> <span style="color: red"></span></label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="salary<?=$requisition2['code_id']?>" name="salary<?=$requisition2['code_id']?>" value="<?=$dyn["$code_name_bn1"]?>" placeholder="" class="form-control" ><small class="form-text text-muted"></small></div>
                                    </div>

                                <?php } ?>

                                <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Remarks <span style="color: red">*</span></label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="remarks" name="remarks" value="<?=$dyn['Remarks']?>" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                                    </div>

                                <div class="">
                                    <button type="submit" class="btn btn-success" name="update_wages" style="float: right; border-radius: 5px;background-color: darkviolet"> 
                                        <i class="fa fa-dot-circle-o"></i> Update
                                    </button>
                                    <!-- <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button> -->
                                </div>

                                </form>

                                <?php }else{?>

                                    <!-- add new salaries start -->

                                <?php if(isset($_POST['add_new_salary'])){?>


                                <form action="insert.php?msg=<?=$msg?>" method="post">


                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="select" class=" form-control-label">Employee Name<span style="color: red">*</span></label></div>
                                        <div class="col-12 col-md-9">
                                            <select name="emp_id" id="emp_id" class="form-control" required>
                                                <option value="">Choose Employee</option>


                                                <?php while($emp=mysqli_fetch_array($employee)){?>
                                                <option value="<?=$emp['EmpID']?>"><?=$emp['FullName']?></option>
                                            <?php }?>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <?php while($requisition2=mysqli_fetch_array($add_requisition_salary_table2)){

                                    ?>

                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label"><?=$requisition2['CodeNameBN']?> <span style="color: red"></span></label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="salary<?=$requisition2['code_id']?>" name="salary<?=$requisition2['code_id']?>" placeholder="" class="form-control" ><small class="form-text text-muted"></small></div>
                                    </div>

                                <?php } ?>

                                <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Remarks <span style="color: red">*</span></label></div>
                                        <div class="col-12 col-md-9"><input type="text" id="remarks" name="remarks" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                                    </div>

                                <div class="">
                                    <button type="submit" class="btn btn-success" name="add_new_wages" style="float: right; border-radius: 5px;background-color: darkviolet"> 
                                        <i class="fa fa-dot-circle-o"></i> Add
                                    </button>
                                    <!-- <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button> -->
                                </div>

                                </form>

                            <?php }else{?>

                                <!-- view table data starts -->

                                <?php if(isset($_GET['msg_success'])){?>
                                                    <div class="col-sm-12">
                                            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                                                <span class="badge badge-pill badge-success"></span> <?php echo $_GET['msg_success'];?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>

                                    <?php }?>


                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <?php 
                                            $sl1 = 0;
                                            while($requisition=mysqli_fetch_array($add_requisition_salary_table)){

                                                //$code_name_bn = $requisition['CodeNameBN'];
                                                $sl1++;
                                                ?>
                                                <!-- <th  style="display: none"></th> -->
                                            <th><?=$requisition['CodeNameBN']?></th>
                                            
                                        <?php }?>

                                        <!-- <th>ID</th> -->
                                        <th>Emp Name</th>
                                        <th>Action</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 0;
                                        //while($row=mysqli_fetch_array($result)){
                                            $sl++;
                                            ?>

                                            <?php while($dynamic=mysqli_fetch_array($tbl_dynamic)){?>
                                        <tr>
                                            
                                            <?php //while($requisition1=mysqli_fetch_array($add_requisition_salary_table1)){

                                                foreach($add_requisition_salary_table1 as $arst){?>

                                                        
                                                    <?php //}

                                            //for($i=0; $i<$sl1; $i++){
                                                
                                                ?>
                                                <p style="display: none"><?php $code_name_bn = $arst['CodeNameBN'];?></p>

                                           <td><?=$dynamic["$code_name_bn"]?></td>
                                           <?php }   ?>
                                           <td><?=$dynamic['FullName']?></td>
                                           <td><form action="add_requisition_salary.php?msg=<?=$msg?>&msg_update=<?=$dynamic['ID']?>" method="post"><button class="btn btn-secondary btn-sm" name="btn_update_salary" style="background-color: #a66eb8;border-radius: 6px;">Edit</button></form></td>
                                       
                                           
                                        </tr>
                                    <?php }?>
                                        
                                    </tbody>

                                </table>

                                <!-- <button type="submit" name="btn_generate_report" class="btn btn-primary btn-sm" style="margin-top: 4%; float: right;">Generate Report</button> -->


                            <?php } }?>
                            </div>
                        </div>


                    </div>


            
                    <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <form action="report_generate.php?msg=<?=$msg?>" method="post">
                                            <button type="submit" name="btn_generate_report" class="btn btn-primary btn-sm" style="float: right;">Generate Report</button>
                                            </form>
                                        </div>
                                        
                                    </div>
                     </div>
        
    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <?php include 'js_master.php';?>

</body>

</html>

<?php }elseif($_SESSION["flag"] == "error_pass")
    {
      $msg = "The password is incorrect!";
        header("Location: index.php?msg=".$msg);

    }elseif ($_SESSION["flag"] == "captcha") {
     $msg = "Your given number is incorrect!";
        header("Location: index.php?msg=".$msg);

    }elseif ($_SESSION["flag"] == "error_username") {
     $msg = "The username is incorrect!";
        header("Location: index.php?msg=".$msg);

      }else {
        $msg = "The username and password are incorrect!";
        header("Location: index.php?msg=".$msg);
      }
    ?>
