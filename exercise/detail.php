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
<!-- BS 4
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
#ticketBox {
    display:none;
}
</style>
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
          <div class="container-fluid" id='ticketBox'>
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
                <button type="button" class="btn btn-primary col-md-offset-10 col-md-2" onclick='buy();'>ซื้อตั๋ว</button>            
            </div>
            
            <hr>
          </div>
          <div class="col-md-0 " alight="center">
            <!--button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" <.?php if($status == false){?> disabled <.?php  } ?> >ซื้อตั๋วชมภาพยนต์</button-->
            <button type="button" class="btn btn-info" onclick="ticketBox();" <?php if($status == false){?> disabled <?php  } ?> >ซื้อตั๋วชมภาพยนต์</button>
            <a href="index.php" class="btn btn-primary" role="button"> กลับสู่หน้าหลัก </a> 
          </div> 
      </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row form-group">
              <div class="col-md-4">จำนวนที่นั่ง:</div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="chair" value="" onkeyup="cal();">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">ราคา:</div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="price" value="" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">จำนวนเงืนที่ใส่:</div>
              <div class="col-md-8">
                <input type="text" class="form-control" id="money" value="">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
          <button type="button" class="btn btn-primary" onclick='buy();'>ซื้อตั๋ว</button>
          <!--a href="buy.php?id=" class="btn btn-primary" role="button"> ซื้อตั๋ว </a-->
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript"> 
function cal(){
  var chair = document.getElementById('chair').value;
  document.getElementById('price').value =<?php echo $price; ?>*chair;
}
function buy(){
  //window.location = "buy.php?id=<.?php echo $id ?>?chair="+document.getElementById('chair').value;
  var chair = parseInt(document.getElementById('chair').value);//จำนวนที่นั่ง  
  var price = parseInt(document.getElementById('price').value);//จำนวนที่ต้องจ่าย
  var money = parseInt(document.getElementById('money').value);//จำนวนเงินที่ใสตู้
  var thousand = 0;
  var fhundred  = 0;
  var ohundred = 0;
  var fifty = 0;
  var twenty = 0;
  var ten = 0;
  var five = 0;
  var two = 0;
  var one = 0;
  if(money >= price){
    
    var change = money - price;
    var a = change;
    //alert("เข้าโปรแกรมถอน\nต้องจ่าย"+ typeof price + "\nจ่ายจริง "+typeof money +"\nต้องถอน "+ typeof change);
    if(change >= 1000){
      thousand = change / 1000;
      thousand = Math.floor(thousand);
      change = change % 1000;
    }
    if(change >= 500){
      fhundred = change / 500;
      fhundred = Math.floor(fhundred);
      change = change % 500;
    }
    if(change >= 100){
      ohundred  = change / 100;
      ohundred = Math.floor(ohundred) ;  
      change = change % 100;
    }
    if(change >= 50){
      fifty = change / 50;
      fifty = Math.floor(fifty);
      change = change % 50;
    }
    if(change >= 20){
      twenty = change / 20;
      twenty = Math.floor(twenty);
      change = change % 20;
    }
    if(change >= 10){
      ten = change / 10;
      ten = Math.floor(ten);
      change = change % 10;
    }
    if(change >= 5){
      five = change / 5;
      five = Math.floor(five);
      change = change % 5;
    }
    if(change >= 2){
      two = change / 2;
      two = Math.floor(two);
      change = change % 2;
    }
    if(change >= 1){
      one = change;
    }
    alert("ต้องถอน:"+ a +" เป็น\n" +"แบงค์พัน:"+ thousand +"\n" + "แบงค์ห้าร้อย:"+ fhundred +"\n" + "แบงค์ร้อย:"+ ohundred +"\n" + "แบงค์ห้าสิบ:"+ fifty +"\n" + "แบงค์ยี่สิบ:"+ twenty +"\n" 
      +"เหรียญสิบ:"+ ten +"\n" + "เหรียญห้า:"+ five +"\n" + "เหรียญสองบาท:"+ two +"\n" + "เหรียญบาท:"+ one) ;  
  }else{
    alert("กรุณาใส่จำนวนเงินให้ถูกต้อง");    
  }
}

function ticketBox() { 
    var x = document.getElementById("ticketBox");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}
</script> 
</body>
</html>


