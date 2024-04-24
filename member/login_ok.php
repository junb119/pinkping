<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$userid = trim($_POST['userid']);
$passwd = trim($_POST['passwd']);
$passwd = hash('sha512', $passwd);

$sql = "SELECT * FROM members where userid='{$userid}' and passwd = '{$passwd}'";

$result = $mysqli->query($sql);
$rs = $result->fetch_object();

// $rs -> idx

if ($rs) {
  $_SESSION['UID'] = $rs->userid;
  $_SESSION['UNAME'] = $rs->username;
  $ssid= session_id();

  $cartSql = "UPDATE cart SET userid='{$_SESSION['UID']}', ssid=null WHERE ssid='{$ssid}'";
  $result = $mysqli->query($cartSql);

  echo "<script>
    alert('".$_SESSION['UID']."님 반갑습니다');
    location.href = '/pinkping/index.php';
  </script>";
  exit();
} else {
  echo "<script>
    alert('아이디 또는 비번을 다시 확인해주세요');
    history.back();    
  </script>";
  exit();
}
