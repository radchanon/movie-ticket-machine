<!-- ***อยู่ระหว่างการปรับปรุงให้พร้องการส่งงาน*** -->
<?php 
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
    
    <div class="col-md-8">
      <img class="img-fluid" src="<?php echo $img; ?>" alt="">
    </div>

    <div class="col-md-4">
      <h3 class="my-3"><?php echo $name; ?> </h3>
      <p>เรื่องย่อ: <?php echo $des; ?></p>
      <p>ราคา: <?php echo $price; ?> </p>
      <p>สถานะ: 
        <?php
          if($status == true){
            echo "กำลังฉายในขณะนี้";
          }else{
            echo "หมดเวลาเข้าฉาย";
          } 
        ?> 
      </p>
    </div>

</div>

    <div class="col-md-offset-11 " alight="center"><a href="index.php" class="btn btn-primary" role="button">กลับสู่หน้าหลัก</a> </div>


</body>
</html>

<!-- อยู่ระหว่างการปรับปรุงให้พร้องการส่งงาน -->
