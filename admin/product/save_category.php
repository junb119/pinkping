<?php
session_start();
//$_SESSION["AUID"] = "admin"; //임시로 관리자 정보 저장.
//unset($_SESSION["AUID"]);

include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

// if (!$_SESSION["AUID"]) {
//   $return_data = array("result" => "member");
//   echo json_encode($return_data);
//   exit; //프로세스 멈추기
// }

$name = $_POST['name'];
$code = $_POST['code'];
$step = $_POST['step'];

//$pcode = $_POST['pcode'];
if (isset($_POST['pcode'])) {
  $pcode = $_POST['pcode'];
} else {
  $pcode = null;
}

$sql = "SELECT cid from category where code = '{$code}'";
$result = $mysqli->query($sql);
$rs = $result->fetch_object();


if (isset($rs->cid)) {
  $return_data = array("result" => "-1");
  echo json_encode($return_data);
  exit; //프로세스 멈추기
}

$sql = "INSERT INTO category (code, pcode, name, step) VALUES ('{$code}', '{$pcode}', '{$name}', {$step})";


$result = $mysqli->query($sql);

if ($result) {
  $return_data = array("result" => 1);
  echo json_encode($return_data);
} else {
  $return_data = array("result" => 0);
  echo json_encode($return_data);
}
