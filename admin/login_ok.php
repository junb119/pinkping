<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$userid = trim($_POST['userid']);
$passwd = trim($_POST['passwd']);
$passwd = hash('sha512', $passwd);

$sql = "SELECT * FROM admins where userid='{$userid}' and passwd = '{$passwd}'";
echo $sql;
$result = $mysqli->query($sql);
$rs = $result->fetch_object();

// $rs -> idx

if ($rs) {
  $sql = "UPDATE admins set last_login=now() where idx = {$rs->idx}";
  $result = $mysqli->query($sql);
  $_SESSION['AUID'] = $rs->userid;
  echo "<script>
    alert('관리자님 반갑습니다');
    location.href = '/pinkping/admin/product/product_list.php';
  </script>";
  exit();
} else {
  echo "<script>
    alert('아이디 또는 비번을 다시 확인해주세요');
    history.back();    
  </script>";
  exit();
}
