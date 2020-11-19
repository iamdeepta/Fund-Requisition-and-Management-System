<?php 
session_start();

if ($_SESSION['flag']=='ok') {

    include("config/connection.php");

    $msg = $_GET['msg'];

    $tbl_process = mysqli_query($conn, "SELECT * from tbl_process where id = $msg") or die(mysqli_error($conn));

    while($process=mysqli_fetch_array($tbl_process)){

        $process_name = $process['process_name'];
    }


    $tbl_category = mysqli_query($conn, "SELECT tp.*,tc.* from tbl_process as tp, tbl_category as tc where tc.id = tp.category_id and tp.id = $msg") or die(mysqli_error($conn));

    while($category=mysqli_fetch_array($tbl_category)){

        $category_name = $category['category_name'];
    }

   /*$msg_code = @$_GET['msg_code'];

   if (isset($msg_code)) {

    $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = $msg_code") or die(mysqli_error($conn));

    $add_economic_code_name = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg_code") or die(mysqli_error($conn));

    }else{

        $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = 0") or die(mysqli_error($conn));

    }*/
    $add_requisition_salary_table = mysqli_query($conn, "select id, category_id, substring_index( substring_index(code_id, ',', n), ',', -1 ) as code_id from tbl_process join numbers on char_length(code_id) - char_length(replace(code_id, ',', '')) >= n - 1 where id = $msg") or die(mysqli_error($conn));

    
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
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <?php 
                                            $sl1 = 0;
                                            while($requisition=mysqli_fetch_array($add_requisition_salary_table)){
                                                $sl1++;
                                                ?>
                                            <th><?=$requisition['code_id']?></th>
                                            
                                        <?php }?>

                                        <th>ID</th>
                                        <th>EmpID</th>
                                        <th>OfficeID</th>
                                        <th>OrderID</th>
                                        <th>InsertDate</th>
                                        <th>UpdateDate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 0;
                                        //while($row=mysqli_fetch_array($result)){
                                            $sl++;
                                            ?>
                                        <tr>
                                            <?php for($i=0; $i<$sl1; $i++){?>
                                           <td></td>
                                           <?php }?>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                            <!-- <td><?php echo $row['FullName'];?></td>
                                            <td><?php echo $row['DesignationName'];?></td>
                                            <td></td>
                                            <form action="add_economic_code.php?msg_code=<?=$add_code['parent_id']?>&msg_update=<?=$add_code['ID']?>" method="post">
                                            <td><button type="submit" class="btn btn-success btn-sm" name="btn_edit_code" style="border-radius: 5px">Edit</button></td>
                                            </form> -->
                                        </tr>
                                    <?php //}?>
                                        
                                    </tbody>
                                </table>
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
