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
            //echo count($DATA['data']);
            foreach($DATA['data'] as $result) {
              if($result['id'] == $id){
                $name = $result['name'];
                $img = $result['image'];
                $des = $result['shot_description'];
                $price = $result['price'];
                $status = $result['now_showing']; 
                break;
              }
            }
            if(empty($name)){
              header("Location:index.php");
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
          <div class="container-fluid" id='ticketBox' style='display:none;'>
            <div class="row form-group">
              <div class="col-md-4">จำนวนที่นั่ง:</div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="chair" value="" onkeyup="cal();">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">ราคา:</div>
              <div class="col-md-8"><input type="text" class="form-control" id="price" value="" readonly></div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">จำนวนเงืนที่ใส่:</div>
              <div class="col-md-8"><input type="text" class="form-control" id="money" value=""></div>
            </div>
            <div class="row form-group">
                <button type="button" class="btn btn-primary col-md-offset-10 col-md-2" id="buy">ซื้อตั๋ว</button>            
            </div>            
            <hr>
          </div>
          <div class="col-md-0 " alight="center">  
            <button type="button" class="btn btn-info" id="toggle" <?php if($status == false){?> disabled <?php  } ?> >ซื้อตั๋วชมภาพยนต์</button>
            <a href="index.php" class="btn btn-primary" role="button"> กลับสู่หน้าหลัก </a> 
          </div> 
      </div>
  </div>
  <!-- DIALOG -->
  <div id="dialog" ></div>
  <script>
    $(document).ready(function(){
        //ใส่จำนวนตั๋ว แล้วสรุปจำนวนที่ต้องจ่าย
        $('#chair').keyup(function(){
            var chair = parseInt($('#chair').val());
            $('#price').val(chair * <?php echo $price ?>);
        });
        //เปิด-ปิด ช่องซื้อตั๋ว
        $('#toggle').click(function(){
            $('#ticketBox').toggle(700);
        });
        //คำนวณเงินถอน
        $('#buy').click(function(){
            var chair = parseInt($('#chair').val());
            var price = parseInt($('#price').val());
            var money = parseInt($('#money').val());
            $.ajax({
                type:'GET',
                url:'calculate.php',
                data:{chair:chair,
                      price:price,
                      money:money},
                success: function(data){
                  alert(data);
                  $('#dialog').html(data);
                  //$('#dialog').dialog('open');
                }

            });
        });
        //ไดอร็อค
        /*$("#dialog").dialog({
            autoOpen: false,
            modal: true,
            title: "Details",
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });*/
    });
  </script>
</body>
</html>


