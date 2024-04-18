<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/coupon_func.php';

$username = $_POST['username'];
$userid = $_POST['userid'];
$email = $_POST['email'];
$passwd = $_POST['passwd'];
$passwd = hash('sha512',$passwd);

$sql = "INSERT INTO members (username, userid, email, passwd, regdate) VALUES ('{$username}', '{$userid}','{$email}','{$passwd}',now())";
$result = $mysqli -> query($sql);
if($result){
    //회원가입 축하 쿠폰 발행
    issue_coupon($mysqli, $userid, 1, '회원가입');
}
?>