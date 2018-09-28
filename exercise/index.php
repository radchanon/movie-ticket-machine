<!DOCTYPE html>
<html>
<head>
<title>MovieTicketMachine</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
   .jumbotron {
    background-image: url("bg/bg.jpg");
    color: #ff6600;
    padding: 150px 25px;
    background-attachment: fixed;
    font-family: Montserrat, sans-serif;
    box-shadow: 0px 5px 10px 10px rgba(50,50,50,.4) inset;     
  }
</style>
</head>
<body>
<form action="#" method="get">
<div class="jumbotron">
  <div class="container text-center">
    <h1 style="font-size:100px;font-weight: 900;" >MOVIES LIST</h1>      
    <p>______________________</p>
  </div>
</div>
<div class="container">
    <div class="row">
        <ul class="thumbnails">
        <?php
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
              //echo $result['id']."<br>";
              echo "<div class='col-md-4'><div class='thumbnail'>";
              echo "<a href='detail.php?id=".$result['id']."'><img  src='".$result['image']."'style='height:450px;'></a>";
              if(strlen($result['name'])> 25){
                echo "<div class='caption'><h3>".substr_replace($result['name'],'...',25)."</h3>";
              }else{
                echo "<div class='caption'><h3>".$result['name']."</h3>";
              }
              echo "<p>ราคา: ".$result['price']." บาท</p>";
              echo "<p align='center'><a href='detail.php?id=".$result['id']."' class='btn btn-primary btn-block'>รายละเอีด</a></p></div></div></div>";
            }
        ?>
        </ul>
    </div>
</div>
</form>
</body>
</html>