<?php 
session_start();

if ($_SESSION['flag']=='ok') {

include("config/connection.php");

$tbl_process = mysqli_query($conn, "SELECT * from tbl_category") or die(mysqli_error($conn));

$tbl_code = mysqli_query($conn, "SELECT * from tbl_code") or die(mysqli_error($conn));

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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
                        <h1>Create Process</h1>
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
                Select Category
            </div>

            

    
            <div class="card-body">

                <form action="insert.php" method="post" enctype="multipart/form-data" class="form-horizontal">

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

                <!-- select dropdown start -->
                <div class="row form-group">
                    <!-- <div class="col col-md-3"><label for="select" class=" form-control-label">Select</label></div> -->
                    <div class="col-12 col-md-12">
                        <select name="process_id" id="process_id" class="form-control">
                            <option value="">Choose Category</option>


                            <?php while($process=mysqli_fetch_array($tbl_process)){?>
                            <option value="<?=$process['id']?>"><?=$process['category_name']?></option>
                        <?php }?>
                            
                        </select>
                    </div>
                </div>


                <div class="col-md-12" id="input_process_name" style="display: none">
                    <div class="card">
                        <div class="card-header">
                            Process Name
                        </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col col-md-12"><!-- <label for="text-input" class=" form-control-label">Code No. <span style="color: red">*</span></label> -->
                            <div class="col-12 col-md-12"><input type="text" id="process_name" name="process_name" placeholder="" class="form-control" required><small class="form-text text-muted"></small></div>
                        </div>
                        </div>
                    </div>
                    </div>
                    </div>


                <!-- checkbox start -->
                <div class="col-md-12" id="checkbox" style="display: none;">
        <div class="card">
            <div class="card-header">
                Select Code (Columns)
            </div>
            <div class="card-body">
                <div class="col form-group" >
                            <div class="col col-md-12"><!-- <label for="text-input" class=" form-control-label">Access Level <span style="color: red"></span></label> -->
                            <?php while($code = mysqli_fetch_array($tbl_code)){?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="code_checkbox[]" name="code_checkbox[]" value="<?=$code['ID']?>" >
                                <label class="form-check-label" for="inlineCheckbox1"><?=$code['CodeNameBN']?></label>
                            </div>

                            <?php }?>

                        </div>

                            
                        </div>
                    </div>
                </div>
            </div>

            <div style="float: right;">
                <button type="submit" id="btn_process_create" name="btn_process_create" class="btn btn-primary" style="border-radius: 8px; display: none;">Create</button>
            </div>

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


    <script type="text/javascript">
        $(document).ready(function(){

            $("#process_id").change(function(){

                var test = $(this).val();

                if(test != ''){

                    $("#checkbox").show();
                    $("#btn_process_create").show();
                    $("#input_process_name").show();
                }else{
                    $("#checkbox").hide();
                    $("#btn_process_create").hide();
                    $("#input_process_name").hide();
                    $("#code_checkbox").val("");
                    $("#process_name").val("");
                    /*$("#code_checkbox").prop('checked', false);*/
                }
            });
        });
    </script>
