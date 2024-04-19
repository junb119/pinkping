<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$pid = $_POST['pid'];
$optname = $_POST['optname'];
$qty =  $_POST['qty'];
if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
} else {
    $ssid = session_id();
    $userid = '';
}
//pid	userid	ssid	options	cnt	regdate	

$sql = "INSERT INTO cart (pid,userid,ssid,options,cnt,regdate) VALUES (
    {$pid},
    '{$userid}',
    '{$ssid}',
    '{$optname}',
    '{$qty}',
    now()
)";

$result = $mysqli -> query($sql);
if($result){
    $data = array('result' => 'ok');
} else{
    $data = array('result' => 'fail');
}
echo json_encode($data);

?>