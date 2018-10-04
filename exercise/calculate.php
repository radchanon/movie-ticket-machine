<?php
if(empty($_GET)){
    header("Location:index.php");
}
/*echo ($_GET['chair']." ".$_GET['price']." ".$_GET['money']);
if ($_GET['chair'] == 'NaN') {
    echo ("chair = NaN");
}*/
//echo (gettype($chair)." ".gettype($price)." ".gettype($money));
//////////////////////////////////////
if ( $_GET['chair'] != 'NaN' || $_GET['price'] != 'NaN' || $_GET['money'] != 'NaN' ) {

    $chair = intval($_GET['chair']);//จำนวนตั๋ว
    $price = intval($_GET['price']);//จำนวนที่ต้องจ่าย
    $money = intval($_GET['money']);//จำนวนที่จจ่ายจริง
    if($money >= $price){
        $change = $money - $price;
        echo ("จำนวน: ". $chair ." ที่นั่ง<br>ราคาสุทธิ: ".$price." บาท<br>จำนวนเงินที่ใส่ตู้: ".$money." บาท<br>เงินทอนสุทธิ: " . $change."<br>");
        if($change >= 1000){
            echo ("แบงค์พัน ".floor($change / 1000)." ใบ<br>");
            $change = $change % 1000;
        }
        if($change >= 500){
            echo ("แบงค์ห้าร้อย ".floor($change / 500)." ใบ<br>");
            $change = $change % 500;
        }
        if($change >= 100){
            echo ("แบงค์ร้อย ".floor($change / 100)." ใบ<br>");
            $change = $change % 100;
        }
        if($change >= 50){
            echo ("แบงค์ห้าสิบ ".floor($change / 50)." ใบ<br>");
            $change = $change % 50;
        }
        if($change >= 20){
            echo ("แบงค์ยี่สิบ ".floor($change / 20)." ใบ<br>");
            $change = $change % 20;
        }
        if($change >= 10){
            echo ("เหรียญสิบ ".floor($change / 10)." เหรียญ<br>");
            $change = $change % 10;
        }
        if($change >= 5){
            echo ("เหรียญห้าบาท ".floor($change / 5)." เหรียญ<br>");
            $change = $change % 5;
        }
        if($change >= 2){
            echo ("เหรียญสองบาท ".floor($change / 2)." เหรียญ<br>");
            $change = $change % 2;
        }
        if($change >= 1){
            echo ("เหรียญบาท ".($change / 1)." เหรียญ<br>");
        }
    }else{
        echo ("กรุณาใส่จำนวนเงินให้ถูกต้อง");
    }
}else{
    echo ("กรุณากรอกข้อมูลให้ครบถ้วน");
}
?>