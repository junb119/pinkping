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
    echo "<script>
    alert('카트를 비웠습니다.');
    location.href = '/pinkping/index.php';
  </script>";
} else{
    echo "<script>
    alert('실패, 다시 시도해주세요');
    history.back();
  </script>";
}

?>