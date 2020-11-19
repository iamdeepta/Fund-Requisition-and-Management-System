<?php 
session_start();

if ($_SESSION['flag']=='ok') {

    include("config/connection.php");

   /*$msg_code = @$_GET['msg_code'];

   if (isset($msg_code)) {

    $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = $msg_code") or die(mysqli_error($conn));

    $add_economic_code_name = mysqli_query($conn, "SELECT * from tbl_code where ID = $msg_code") or die(mysqli_error($conn));

    }else{

        $add_economic_code = mysqli_query($conn, "SELECT * from tbl_code where parent_id = 0") or die(mysqli_error($conn));

    }*/

   $query = "SELECT 
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
						AND ".DBHR.".hrtoffice.OfficeID=".$_SESSION["OfficeID"]."
						ORDER BY ".DBHR.".hrpersonnel.EmpID ASC;";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));

/* AND (".DBHR.".hrofficial.ClassID=4 OR ".DBHR.".hrofficial.ClassID=5) */
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
                        <h1>List of Employees</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            

                            <li class="active">List of Employees</li>
                       
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Economic Codes</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Designation</th>
                                            <th>Joining Date</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 0;
                                        while($row=mysqli_fetch_array($result)){
                                            $sl++;
                                            ?>
                                        <tr>
                                           
                                            <td><?php echo $row['FullName'];?></td>
                                            <td><?php echo $row['DesignationName'];?></td>
                                            <td></td>
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
