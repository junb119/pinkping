<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$userid = $_POST['userid'];
$email = $_POST['email'];

$sql = "SELECT COUNT(*) AS cnt FROM members WHERE userid = '{$userid}' or email = '{$email}'";
$result = $mysqli -> query($sql);
$row = $result -> fetch_object(); // $row->cnt
if($result){
    $data = array('cnt' => $row->cnt);
}else{
    $data = array('cnt' => 0);
}
echo json_encode($data);

