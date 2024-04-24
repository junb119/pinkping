<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$cartid = $_POST['cartid']; //[15,16]
$qty = $_POST['qty'];//[3,4]
$i = 0;
foreach($cartid as $cart){
    $sql = "UPDATE cart SET cnt={$qty[$i]} WHERE cartid= {$cart}";
    $result = $mysqli -> query($sql);
    $i++;
}
if($result){
    $data = array('result'=>'ok');
}else{
    $data = array('result'=>'no');
}
echo json_encode($data);
