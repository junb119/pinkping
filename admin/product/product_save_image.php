<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';


//관리자 검사
if (!isset($_SESSION['AUID'])) {
  $result_data = array('result' => 'member'); //php 연관배열
  echo json_encode($result_data);
  exit; //프로세스 멈추기
}
//파일 사이즈 검사
if ($_FILES['savefile']['size'] > 10240000) {
  $result_data = array('result' => 'size');
  echo json_encode($result_data);
  exit;
}
//이미지 여부 검사
if (strpos($_FILES['savefile']['type'], 'image') === false) {
  $result_data = array('result' => 'image');
  echo json_encode($result_data);
  exit;
}
//파일 업로드
$save_dir = $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/upload/';
$fiename = $_FILES["savefile"]["name"]; //insta.jpg
$ext = pathinfo($fiename, PATHINFO_EXTENSION); //jpg
$newfilename = date("YmdHis") . substr(rand(), 0, 6); //202404111137.123123 -> 202404111137123123 
$savefile = $newfilename . '.' . $ext;  //202404111137123123.jpg

if (move_uploaded_file($_FILES["savefile"]["tmp_name"], $save_dir . $savefile)) {
  $sql = "INSERT INTO product_image_table (userid, filename) VALUES ('{$_SESSION['AUID']}', '{$savefile}')";
  $result = $mysqli->query($sql);
  $imgid = $mysqli->insert_id; //자동생성되는 id 번호

  $result_data = array('result' => 'success', 'imgid' => $imgid, 'savefile' => $savefile);
  echo json_encode($result_data);
  exit;
}
