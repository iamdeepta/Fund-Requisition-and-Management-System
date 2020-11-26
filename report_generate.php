<?php

session_start();

if (isset($_POST['btn_generate_report']) && $_SESSION["flag"] == "ok") {
  

require("config/connection.php");

        $msg = $_GET['msg'];

    $tbl_process = mysqli_query($conn, "SELECT * from tbl_process where id = $msg") or die(mysqli_error($conn));

    while($process=mysqli_fetch_array($tbl_process)){

        $process_name = $process['process_name'];
        $table_name = $process['table_name'];
    }

    $query_requisition_salary = "select tp.id, tp.category_id, tc.CodeNameBN, substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) as code_id from tbl_process as tp join numbers as num on char_length(tp.code_id) - char_length(replace(tp.code_id, ',', '')) >= num.n - 1 join tbl_code as tc on tc.ID= substring_index( substring_index(tp.code_id, ',', num.n), ',', -1 ) where tp.id = $msg";

    $add_requisition_salary_table1 = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));

    $add_requisition_salary_table = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));

    $add_requisition_salary_table2 = mysqli_query($conn, $query_requisition_salary) or die(mysqli_error($conn));



    $employee = mysqli_query($conn, "SELECT ".DBHR.".hrpersonnel.FullName,".DBHR.".hrpersonnel.EmpID from ".DBHR.".hrpersonnel") or die(mysqli_error($conn));


     $tbl_dynamic = mysqli_query($conn, "SELECT dynamic.*,".DBHR.".hrpersonnel.FullName, hd.DesignationName from $table_name as dynamic left outer join ".DBHR.".hrpersonnel on ".DBHR.".hrpersonnel.EmpID = dynamic.EmpID left outer join ".DBHR.".hrtpost as hp on ".DBHR.".hrpersonnel.EmpID = hp.EmpID left outer join ".DBHR.".hrtdesignation as hd on hp.DesignationID = hd.DesignationID") or die(mysqli_error($conn));

     $tbl_dynamic1 = mysqli_query($conn, "SELECT dynamic.*,".DBHR.".hrpersonnel.FullName, hd.DesignationName from $table_name as dynamic left outer join ".DBHR.".hrpersonnel on ".DBHR.".hrpersonnel.EmpID = dynamic.EmpID left outer join ".DBHR.".hrtpost as hp on ".DBHR.".hrpersonnel.EmpID = hp.EmpID left outer join ".DBHR.".hrtdesignation as hd on hp.DesignationID = hd.DesignationID") or die(mysqli_error($conn));


    $tbl_category = mysqli_query($conn, "SELECT tp.*,tc.* from tbl_process as tp, tbl_category as tc where tc.id = tp.category_id and tp.id = $msg") or die(mysqli_error($conn));

    while($category=mysqli_fetch_array($tbl_category)){

        $category_name = $category['category_name'];
    }


    class BanglaConverter {
    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    
    public static function bn2en($number) {
        return str_replace(self::$bn, self::$en, $number);
    }
    
    public static function en2bn($number) {
        return str_replace(self::$en, self::$bn, $number);
    }
}


function numtoletter($num){
$alphabet = range('A', 'Z');

return $alphabet[$num];

}






?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <link rel="shortcut icon" href="assets/images/favicon.png">

 <style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
  border-radius: 4px;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}

</style>
  <!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --> 

<!--Optional theme--> 
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

  
</head>

<body>

            
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Report</h4>
                  </div>
                  <div class="row" >

                    
                    
                      
                   
                  </div>
                  <div class="row" >
                    <p style="font-weight: bold;">Report Date: <?php echo date('d/m/yy');?></p><!-- <p style="margin-left: 5px;"><?php echo date('d/m/yy');?></p> -->
                  </div>
                  <div class="">
                    <div class="table-responsive">
                      <table id="bootstrap-data-table-export" class="table table-striped table-hover table-bordered" >
                                    <thead>
                                        <tr>

                                          <th>ক্রমিক</th>
                                          <th>কর্মকর্তা/কর্মচারীর নাম</th>
                                          <th>পদবী</th>
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
                                        <th>মোট মাসিক বেতন</th>
                                        <th>১২ মাসের মোট বেতন</th>
                                        <th>বাংলা নববর্ষ ভাতা</th>
                                        <th>উৎসব ভাতা</th>
                                        <th>বাৎসরিক মোট বেতন</th>
                                        <th>মন্তব্য (if any)</th>
                                      
                                      
                                        
                                        </tr>

                                        <tr>
                                          <th>A</th>
                                          <th>B</th>
                                          <th>C</th>
                                          <?php
                                          $letter=2;
                                           for($i=0; $i<$sl1; $i++){
                                            $letter++; ?>
                                            <th><?=numtoletter($letter)?></th>
                                          <?php }

                                            $letter1 = $letter+1;
                                            $letter2 = $letter1+1;
                                            $letter3 = $letter2+1;
                                            $letter4 = $letter3+1;
                                            $letter5 = $letter4+1;
                                            $letter6 = $letter5+1;
                                          ?>

                                          <th><?=numtoletter($letter1)?></th>
                                          <th><?=numtoletter($letter2)?></th>
                                          <th><?=numtoletter($letter3)?></th>
                                          <th><?=numtoletter($letter4)?></th>
                                          <th><?=numtoletter($letter5)?></th>
                                          <th><?=numtoletter($letter6)?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sl = 0;
                                        $sum_officer_salary = 0;
                                        $sum_monthly_salary = 0;
                                        $sum_yearly_salary = 0;
                                        $sum_percent_salary = 0;
                                        $sum_multiply_salary = 0;
                                        $sum_total_yearly_salary = 0;
                                        
                                        //while($row=mysqli_fetch_array($result)){
                                            
                                            ?>

                                            <?php while($dynamic=mysqli_fetch_array($tbl_dynamic)){
                                              $sl++; 
                                              $sum_officer_salary = 0;
                                              ?>
                                        <tr>

                                          <td><?=BanglaConverter::en2bn($sl)?></td>
                                          <td><?=$dynamic['FullName']?></td>
                                          <td><?=$dynamic['DesignationName']?></td>
                                            
                                            <?php //while($requisition1=mysqli_fetch_array($add_requisition_salary_table1)){
                                                $serial = 0;
                                                $sum = 0;
                                                $yearly_sum = 0;
                                                foreach($add_requisition_salary_table1 as $arst){
                                                  $serial++;
                                                  
                                                  ?>

                                                        
                                                    <?php //}

                                            //for($i=0; $i<$sl1; $i++){
                                                
                                                ?>
                                                <p style="display: none"><?php $code_name_bn = $arst['CodeNameBN'];?></p>

                                           <td><?=$dynamic["$code_name_bn"]?></td>



                                           <?php 

                                           $dyn_code_salary[$sl][$serial] = $dynamic["$code_name_bn"];

                                           if($serial==1){

                                            if($dynamic["$code_name_bn"]!=""){
                                            $main_salary = BanglaConverter::bn2en($dynamic["$code_name_bn"]);
                                            $main_salary_another = BanglaConverter::bn2en($dynamic["$code_name_bn"]);
                                          }else{

                                            $dynamic["$code_name_bn"] = 0;
                                          }
                                           }elseif($serial==3){

                                            if($dynamic["$code_name_bn"]!=""){

                                            $main_salary = BanglaConverter::bn2en($dynamic["$code_name_bn"]);
                                            $main_salary_another = BanglaConverter::bn2en($dynamic["$code_name_bn"]);
                                          }else{

                                            $dynamic["$code_name_bn"]=0;
                                          }
                                           }
                                            ?>

                                           <?php
                                           $sum = $sum+BanglaConverter::bn2en($dynamic["$code_name_bn"]);
                                           $sum_bn = BanglaConverter::en2bn($sum);

                                           $yearly_sum = $sum*12;
                                           $yearly_sum_bn = BanglaConverter::en2bn($yearly_sum);


                                           if($serial==1){
                                           if($dynamic["$code_name_bn"]!=""){
                                           $main_salary1 = ($main_salary*20)/100;
                                           $main_salary_bn = BanglaConverter::en2bn($main_salary1);

                                           $main_salary_another1 = $main_salary_another*2;
                                           $main_salary_another_bn = BanglaConverter::en2bn($main_salary_another1);


                                           $total_yearly_salary = $yearly_sum+$main_salary1+$main_salary_another1;
                                           $total_yearly_salary_bn = BanglaConverter::en2bn($total_yearly_salary);
                                         }
                                         
                                       }elseif($serial==3){
                                        if($dynamic["$code_name_bn"]!=""){
                                           $main_salary1 = ($main_salary*20)/100;
                                           $main_salary_bn = BanglaConverter::en2bn($main_salary1);

                                           $main_salary_another1 = $main_salary_another*2;
                                           $main_salary_another_bn = BanglaConverter::en2bn($main_salary_another1);


                                           $total_yearly_salary = $yearly_sum+$main_salary1+$main_salary_another1;
                                           $total_yearly_salary_bn = BanglaConverter::en2bn($total_yearly_salary);
                                       }
                                     }



                                            }   ?>
                                           
                                           <td><?=$sum_bn?></td>
                                           <td><?=$yearly_sum_bn?></td>
                                           <td><?=$main_salary_bn?></td>
                                           <td><?=$main_salary_another_bn?></td>
                                           <td><?php echo $total_yearly_salary_bn?></td>
                                           <td><?=$dynamic['Remarks']?></td>
                                       
                                           
                                        </tr>

                                      <?php 
                                      $sum_monthly_salary = $sum_monthly_salary+$sum;
                                      $sum_monthly_salary_bn = BanglaConverter::en2bn($sum_monthly_salary);

                                      $sum_yearly_salary = $sum_yearly_salary+$yearly_sum;
                                      $sum_yearly_salary_bn = BanglaConverter::en2bn($sum_yearly_salary);

                                      $sum_percent_salary = $sum_percent_salary+$main_salary1;
                                      $sum_percent_salary_bn = BanglaConverter::en2bn($sum_percent_salary);

                                      $sum_multiply_salary = $sum_multiply_salary+$main_salary_another1;
                                      $sum_multiply_salary_bn = BanglaConverter::en2bn($sum_multiply_salary);

                                      $sum_total_yearly_salary = $sum_total_yearly_salary+$total_yearly_salary;
                                      $sum_total_yearly_salary_bn = BanglaConverter::en2bn($sum_total_yearly_salary);

                                      
                                      
                                      
                                      //for($k=1; $k<$sl;$k++){
                                      /*$sum_officer_salary = $sum_officer_salary+BanglaConverter::bn2en($dyn_code_salary[$sl][$serial]);
                                      $sum_officer_salary_bn = BanglaConverter::en2bn($sum_officer_salary);*/
                                      
                                    //}
                                    
                                  
                                      ?>
                                  

                                      
                                      
                                    <?php }?>

                                    <tr>
                                      <td style="font-weight: bold"><?=BanglaConverter::en2bn($sl+1)?></td>
                                      <td style="font-weight: bold">মোট=</td>
                                      <td></td>

                                      <?php 
                                      $sl3=0;
                                      foreach($add_requisition_salary_table2 as $arst2){
                                        $sl3++;
                                        $sum_officer_salary = 0;
                                        $sl4=0;

                                        foreach($tbl_dynamic1 as $dyn){
                                          $sl4++;

                                          if($sl3==1){
                                            if ($dyn_code_salary[$sl4][$sl3]=="") {
                                              $dyn_code_salary[$sl4][$sl3] = 0;
                                            }
                                          }elseif($sl3==3){
                                            if ($dyn_code_salary[$sl4][$sl3]=="") {
                                              $dyn_code_salary[$sl4][$sl3] = 0;
                                            }

                                          }

                                        $sum_officer_salary = $sum_officer_salary+BanglaConverter::bn2en($dyn_code_salary[$sl4][$sl3]);

                                        $sum_officer_salary_bn = BanglaConverter::en2bn($sum_officer_salary);
                                      }
                                       
                                        ?>

                                        <td style="font-weight: bold"><?=$sum_officer_salary_bn?></td>
                                        
                                      <?php }?>

                                      <td style="font-weight: bold"><?=$sum_monthly_salary_bn?></td>
                                      <td style="font-weight: bold"><?=$sum_yearly_salary_bn?></td>
                                      <td style="font-weight: bold"><?=$sum_percent_salary_bn?></td>
                                      <td style="font-weight: bold"><?=$sum_multiply_salary_bn?></td>
                                      <td style="font-weight: bold"><?=$sum_total_yearly_salary_bn?></td>
                                      <td></td>

                                    </tr>
                                        
                                    </tbody>

                                </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <style type="text/css">
              td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
}
            </style>

      

      <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
  
</body>


<!-- Mirrored from www.radixtouch.in/templates/logicswave/jiva/source/light/datatables.html by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 13 May 2020 10:16:48 GMT -->
</html>

<?php
}
?>