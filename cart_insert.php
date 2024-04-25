<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$pid = $_POST['pid'];
$optname = $_POST['optname'] ?? '';
$qty =  $_POST['qty'];
$total =  $_POST['total'];

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
    $ssid = '';
} else {
    $ssid = session_id();
    $userid = '';
}
//pid	userid	ssid	options	cnt	regdate	

$sql = "SELECT COUNT(*) AS cnt FROM cart WHERE pid = '{$pid}' AND (userid = '{$userid}' OR ssid='{$ssid}')";
$result = $mysqli -> query($sql);
$row = $result -> fetch_object(); // $row->cnt

if($result){    
    if($row->cnt > 0){
        $data = array('result' => '중복');
        echo json_encode($data);
    }else {
        $cartsql = "INSERT INTO cart (pid,userid,ssid,options,cnt,total,regdate) VALUES (
            {$pid},
            '{$userid}',
            '{$ssid}',
            '{$optname}',
            '{$qty}',
            '{$total}',
            now()
        )";
        
        $cartresult = $mysqli -> query($cartsql);
        if($cartresult) {
            $data = array('result' => 'ok');
        } else {
            $data = array('result' => 'fail');
        }
        echo json_encode($data);
    }
}      

?>