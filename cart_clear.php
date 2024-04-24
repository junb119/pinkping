<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

if(isset($_SESSION['UID'])){
    $userid = $_SESSION['UID'];
} else {
    $ssid = session_id();
    $userid = '';
}
//pid	userid	ssid	options	cnt	regdate	

$sql = "DELETE FROM cart WHERE (ssid = '{$ssid}' or userid = '{$userid}')";

$result = $mysqli -> query($sql);
if($result){
    $data = array('result' => 'ok');
} else{
    $data = array('result' => 'fail');
}
echo json_encode($data);

?>