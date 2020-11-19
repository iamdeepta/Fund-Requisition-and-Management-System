<?php 
session_start();

if ($_SESSION['flag']=='ok') {

    include("config/connection.php");

   $msg_code = @$_GET['msg_code'];

   if (isset($msg_code)) {

    $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = $msg_code") or die(mysqli_error($conn));

    $add_economic_code_name = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg_code") or die(mysqli_error($conn));

    }else{

        $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = 0") or die(mysqli_error($conn));

        //$add_economic_code_name = mysqli_query($conn, "SELECT * from tbl_code where ID = 0") or die(mysqli_error($conn));
    }

    
   

    
    //$add_code=mysqli_fetch_array($add_economic_code);



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
                        <h1>Add Economic code</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <?php if(isset($msg_code)){
                                while($add_code_name=mysqli_fetch_array($add_economic_code_name)){

                                    $codename = $add_code_name['CodeName'];
                                    $codeid = $add_code_name['parent_id'];

                                    
                                ?>
                                <a href="add_economic_code.php?msg_code=<?=$codeid?>"><li class="active"><?=$codename?></li></a>

                                <?php 
                                $add_economic_code_name1 = mysqli_query($conn, "SELECT * from tbl_code where ID = $codeid") or die(mysqli_error($conn));

                                while($add_code_name1=mysqli_fetch_array($add_economic_code_name1)){

                                    $codename1 = $add_code_name1['CodeName'];
                                    $codeid1 = $add_code_name1['parent_id'];
                                ?>
                                <-
                                <a href="add_economic_code.php?msg_code=<?=$codeid1?>"><li class="active"><?=$codename1?></li></a>


                                <?php 
                                $add_economic_code_name2 = mysqli_query($conn, "SELECT * from tbl_code where ID = $codeid1") or die(mysqli_error($conn));

                                while($add_code_name2=mysqli_fetch_array($add_economic_code_name2)){

                                    $codename2 = $add_code_name2['CodeName'];
                                    $codeid2 = $add_code_name2['parent_id'];
                                ?>
                                <-
                                <a href="add_economic_code.php?msg_code=<?=$codeid2?>"><li class="active"><?=$codename2?></li></a>

                            <?php } } } }else{?>
                            <li class="active">Add Economic code</li>
                        <?php }?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Economic Codes</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Code No.</th>
                                            <th>Name</th>
                                            <th>Code No. (BN)</th>
                                            <th>Name (BN)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 0;
                                        while($add_code=mysqli_fetch_array($add_economic_code)){
                                            $sl++;
                                            ?>
                                        <tr>
                                            <td><?=$sl?></td>
                                            <td><a href="add_economic_code.php?msg_code=<?=$add_code['ID']?>" style="text-decoration: underline;color: black"><?=$add_code['CodeNo']?></a></td>
                                            <td><?=$add_code['CodeName']?></td>
                                            <td><?=$add_code['CodeNoBN']?></td>
                                            <td><?=$add_code['CodeNameBN']?></td>
                                            <form action="add_economic_code.php?msg_code=<?=$add_code['parent_id']?>&msg_update=<?=$add_code['ID']?>" method="post">
                                            <td><button type="submit" class="btn btn-success btn-sm" name="btn_edit_code" style="border-radius: 5px">Edit</button></td>
                                            </form>
                                        </tr>
                                    <?php }?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


            <?php if(isset($_POST['btn_edit_code'])){

                $msg_update = $_GET['msg_update'];

                $update_economic_code = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg_update") or die(mysqli_error($conn));


                $update_code=mysqli_fetch_array($update_economic_code);

                ?>



                <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Code</strong> 
                </div>
                <div class="card-body card-block">
                    <form action="update.php?msg_update=<?=$msg_update?>" method="post" enctype="multipart/form-data" class="form-horizontal">


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
                        
                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code No. <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_no" name="code_no" value="<?=$update_code['CodeNo']?>" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code Name <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_name" name="code_name" value="<?=$update_code['CodeName']?>" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code No. in BN <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_no_bn" name="code_no_bn" value="<?=$update_code['CodeNoBN']?>" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code Name in BN <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_name_bn" name="code_name_bn" value="<?=$update_code['CodeNameBN']?>" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>


                        <div class="col form-group" style="margin-left: -30px">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Access Level <span style="color: red"></span></label></div>
                            <?php //while($access = mysqli_fetch_array($access_level)){?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="head_office" name="head_office" value="1" <?php if($update_code['head_office']==1){echo 'checked';}else{echo '';}?> >
                                <label class="form-check-label" for="inlineCheckbox1">Head Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="zone_office" name="zone_office" value="1" <?php if($update_code['zone_office']==1){echo 'checked';}else{echo '';}?> >
                                <label class="form-check-label" for="inlineCheckbox1">Zone Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="circle_office" name="circle_office" value="1" <?php if($update_code['circle_office']==1){echo 'checked';}else{echo '';}?> >
                                <label class="form-check-label" for="inlineCheckbox1">Circle Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="division_office" name="division_office" value="1" <?php if($update_code['division_office']==1){echo 'checked';}else{echo '';}?> >
                                <label class="form-check-label" for="inlineCheckbox1">Division Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="training_academy" name="training_academy" value="1" <?php if($update_code['training_academy']==1){echo 'checked';}else{echo '';}?> >
                                <label class="form-check-label" for="inlineCheckbox1">Training Academy</label>
                            </div>

                        <?php //}?>
                            
                        </div>
                        
                        
                   
                            
                           
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-sm" name="update_economic_code" style="float: right; border-radius: 5px"> 
                        <i class="fa fa-dot-circle-o"></i> Update
                    </button>
                    <!-- <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Reset
                    </button> -->
                </div>
                </form>
            </div>
            
        </div>


            <?php }else{?>


                


        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <strong>Add Code</strong> 
                </div>
                <div class="card-body card-block">
                    <form <?php if(isset($_GET['msg_code'])){?>action="insert.php?msg=<?=$msg_code?>"<?php }else{?>action="insert.php"<?php }?> method="post" enctype="multipart/form-data" class="form-horizontal">


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
                        
                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code No. <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_no" name="code_no" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code Name <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_name" name="code_name" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code No. in BN <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_no_bn" name="code_no_bn" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-4"><label for="text-input" class=" form-control-label">Code Name in BN <span style="color: red">*</span></label></div>
                            <div class="col-12 col-md-8"><input type="text" id="code_name_bn" name="code_name_bn" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>

                        <div class="col form-group" style="margin-left: -30px">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Access Level <span style="color: red"></span></label></div>
                            <?php //while($access = mysqli_fetch_array($access_level)){?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="head_office" name="head_office" value="1" >
                                <label class="form-check-label" for="inlineCheckbox1">Head Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="zone_office" name="zone_office" value="1" >
                                <label class="form-check-label" for="inlineCheckbox1">Zone Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="circle_office" name="circle_office" value="1" >
                                <label class="form-check-label" for="inlineCheckbox1">Circle Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="division_office" name="division_office" value="1" >
                                <label class="form-check-label" for="inlineCheckbox1">Division Office</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="training_academy" name="training_academy" value="1" >
                                <label class="form-check-label" for="inlineCheckbox1">Training Academy</label>
                            </div>

                        <?php //}?>
                            
                        </div>
                        
                        
                   
                            
                           
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm" name="add_economic_code" style="float: right; border-radius: 5px"> 
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <!-- <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Reset
                    </button> -->
                </div>
                </form>
            </div>
            
        </div>

    <?php }?>

        
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
