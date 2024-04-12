<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$pid = $_REQUEST['pid'];
$ismain = $_REQUEST['ismain'] ?? [];
$isnew = $_REQUEST['isnew'] ?? [];
$isbest = $_REQUEST['isbest'] ?? [];
$isrecom = $_REQUEST['isrecom'] ?? [];
$status = $_REQUEST['status'] ?? [];

foreach($pid as $p) {
  $ismain[$p] = $ismain[$p] ?? 0;
  $isnew[$p] = $isnew[$p] ?? 0;
  $isbest[$p] = $isbest[$p] ?? 0;
  $isrecom[$p] = $isrecom[$p] ?? 0;
  $status[$p] = $status[$p] ?? 0;

  $sql = "UPDATE products SET ismain = {$ismain[$p]}, isnew = {$isnew[$p]}, isbest = {$isbest[$p]}, isrecom = {$isrecom[$p]} , status = {$status[$p]} WHERE pid = {$p}";
  $result = $mysqli -> query($sql);

}
if ($result) {
  echo "<script>alert('일괄 수정 완료');history.back();</script>";
  
} else {
  echo "<script>alert('일괄 수정 실패');history.back();</script>";

}
?>