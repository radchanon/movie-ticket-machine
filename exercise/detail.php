
<?php 
if(empty($_GET)){
  header("Location:index.php");
}
$id = $_GET['id'];
$curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://www.mocky.io/v2/5bab559f3000006800a68762',
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            // Close request to clear up some resources
            curl_close($curl);

            $DATA= json_decode($resp, true);
            foreach($DATA['data'] as $result) {
              if($result['id'] == $id){
                $name = $result['name'];
                $img = $result['image'];
                $des = $result['shot_description'];
                $price = $result['price'];
                $status = $result['now_showing'];
              }
            }
            
?>
<!DOCTYPE html>
<html>
<head>
<title>MovieTicketMachine</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
  <h1 class="my-4">รายละเอียดภาพยนต์</h1>
  <div class="row well">
    
    <div class="col-md-6">
      <img class="img-fluid" src="<?php echo $img; ?>" style="widht:auto;height:680px;">
    </div>

      <div class="col-md-6">
        <h2><?php echo $name; ?></h2>
        <hr>
        <div class="row">
          <!-- Description -->
          <div class="col-md-2"><h4>เรื่องย่อ: </h4></div>
          <div class="col-md-10"><h4><?php echo $des; ?></h4></div> 
          <!-- Price --> 
          <div class="col-md-2"><h4>ราคา: </h4></div>
          <div class="col-md-10"><h4><?php echo $price." บาท"; ?></h4></div>
          <!-- Status -->
          <div class="col-md-2"><h4>สถานะ: </h4></div>
          <div class="col-md-10">
            <h4>
              <?php
                if($status == true){
                  echo "<h4 style='color:green;'>กำลังฉายในขณะนี้</h4>";
                }else{
                  echo "<h4 style='color:red;'>หมดเวลาเข้าฉาย</h4>";
                } 
              ?>
            </h4>
          </div>
        </div>
        <hr>
          <div class="col-md-0 " alight="center">
            <a href="index.php" class="btn btn-primary" role="button">
              <span class="glyphicon glyphicon-home"> กลับสู่หน้าหลัก
            </a> 
          </div> 
      </div>
  </div>
</div>


</body>
</html>

