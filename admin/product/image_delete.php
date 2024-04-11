<?php

session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

// 관리자 검사
if (!isset($_SESSION['AUID'])) {
  $result_data = array('result'=>'member');
  echo json_encode($result_data);
  exit; //프로세스 멈추기
}

$imgid = $_POST['imgid'];
$sql = "SELECT * FROM product_image_table WHERE imgid = {$imgid}";
$result = $mysqli -> query($sql);
$rs = $result->fetch_object();

if ($rs-> userid !== $_SESSION['AUID']) {
    $result_data = array('result'=>'member');
    echo json_encode($result_data);
    exit; //프로세스 멈추기
}

$sql = "UPDATE product_image_table SET status = 0 WHERE imgid = {$imgid}";
$result = $mysqli->query($sql);

if ($result) {
  $delete_file = $_SERVER['DOCUMENT_ROOT'].'/pinkping/admin/upload/'.$rs->filename;
  unlink($delete_file);
  $result_data = array('result'=>'ok');
    echo json_encode($result_data);
} else {
  $result_data = array('result'=>'fail');
    echo json_encode($result_data);
}

?>