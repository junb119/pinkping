<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/coupon_func.php';

$userid = trim($_POST['userid']);
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$passwd = trim($_POST['passwd']);
$passwd = hash('sha512', $passwd);

$sql = "INSERT INTO members (userid,	email,	username,	passwd,	regdate	
) VALUES (
  '{$userid}','{$email}','{$username}','{$passwd}', now()
  )";
// echo $sql;
$result = $mysqli->query($sql);
if ($result) {
  // 회원가입 축하 쿠폰 발행
  issue_coupon($mysqli, $userid, 1, '회원가입');
  
} else {
  echo "<script>
    alert('회원가입 실패');
    history.back();    
  </script>";
  exit();
}
?>