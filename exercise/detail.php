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
  <h1 class="my-4">รายละเอียดภาพยนตร์</h1>
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
              <?php
                if($status == true){
                  echo "<h4 style='color:green;'>กำลังฉายในขณะนี้</h4>";
                }else{
                  echo "<h4 style='color:red;'>หมดเวลาเข้าฉาย</h4>";
                } 
              ?>
          </div>
        </div>
        <hr>
          <!-- Stsrt Ticket Box -->
          <div class="container-fluid" id='ticketBox' style='display:none;'>
            <div class="row form-group">
              <div class="col-md-4">จำนวนตั๋ว:</div>
              <div class="col-md-8">
                <input type="text" placeholder="กรอกตัวเลข 0-9 เท่านั้น" class="form-control" id="chair" value="" autofocus>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">ราคาสุทธิ:</div>
              <div class="col-md-8"><input type="text" class="form-control" id="price" value="" readonly></div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">จำนวนเงินที่ใส่ตู้:</div>
              <div class="col-md-8">
                <input type="text" placeholder="กรอกตัวเลข 0-9 เท่านั้น" class="form-control" id="money" value="" disabled>
                <p id="alert" style="color:red"></p>
              </div>
            </div>
            <div class="row form-group">
              <button type="button" class="btn btn-primary col-md-offset-10 col-md-2" id="buy" disabled>ซื้อตั๋ว</button>          
            </div>
            <hr>             
          </div>
          <!-- End Ticket Box -->          
          <!-- Button group --> 
          <div class="col-md-0 " alight="center">  
            <button type="button" class="btn btn-info" id="toggle" <?php if($status == false){?> disabled <?php  } ?> >ซื้อตั๋วชมภาพยนต์</button>
            <a href="index.php" class="btn btn-primary" role="button"> กลับสู่หน้าหลัก </a> 
          </div>
                
      </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalbox">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ภาพยนตร์เรื่อง: <?php echo $name ?></h4>
        </div>
        <div class="modal-body" >
          <p id="data"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='finish'>ตกลง</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->
  <script>
    //start jQuery
    $(document).ready(function(){ 
        ///////////////////////////////////////////////เปิด-ปิด ช่องซื้อตั๋ว///////////////////////////////////////
        $('#toggle').click(function(){
            $('#ticketBox').toggle(600);
        });
        ///////////////////////////////////////////////กำหนดให้ใส่เฉพาะตัวเลข///////////////////////////////////////
        //ref link: https://stackoverflow.com/questions/995183/how-to-allow-only-numeric-0-9-in-html-inputbox-using-jquery 
        //ไม่ป้องกันการก็อปปี้มาวาง ตรวจสอบได้เฉพาะตอนกดเท่านั้น
        $("input").keypress(function(event) {
          return /\d/.test(String.fromCharCode(event.keyCode));
        });//end กำหนดให้ใส่เฉพาะตัวเลข
        ///////////////////////////////////////////////ใส่จำนวนตั๋ว แล้วสรุปจำนวนเงินสุทธิ///////////////////////////////////////
        $('#chair').keyup(function(){
            var chair = $('#chair').val();
            if(chair.length == 0){
              $('#money').prop('disabled',true);
              $('#price').val("");
            }else{
              chair = parseInt(chair);
              $('#price').val(chair * <?php echo $price ?>);
              $('#money').prop('disabled',false);
            }
        });
        ///////////////////////////////////////////////ตรวจสอบจำนวนเงินที่ใส่ตู้///////////////////////////////////////
        $('#money').keyup(function() {
            var money = $('#money').val();//จำนวนเงินที่ใส่ตู้
            var price = $('#price').val();//จำนวนเงินสุทธิ
            if (money.length == 0) {
                $('#buy').prop('disabled',true);
                $('#alert').html("กรุณาใส่จำนวนเงินในช่องนี้");
            }else{
              money = parseInt(money);//แปลงจาก string -> Int
              price = parseInt(price);
              if (money < price) {
                $('#alert').html("กรุณาใส่จำนวนเงินให้มากกว่า หรือเท่ากับราคาเงินสุทธิ");
                $('#buy').prop('disabled',true);
              }else{
                $('#alert').html("");
                $('#buy').prop('disabled',false);
              } 
            }            
        });
        ///////////////////////////////////////////////start คำนวณเงินทอน///////////////////////////////////////
        $('#buy').click(function(){            
            var chair = $('#chair').val();
            var price = $('#price').val();
            var money = $('#money').val();
                $.ajax({
                  type:'GET',
                  url:'calculate.php',
                  data:{chair:chair,
                        price:price,
                        money:money},
                  success: function(data){
                    //alert(data);
                    $('#data').html(data);
                    $('#modalbox').modal('show');                  
                  }
                });//end AJAX           
        });//end คำนวณงินทอน 
        ///////////////////////////////////////////////start finish/////////////////////////////////////// 
        $('#finish').click(function(){
            window.location.href = "index.php"; 
        });     
    });//end jQuery
  </script>
</body>
</html>


