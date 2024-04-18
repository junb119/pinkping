<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';

//관리자 검사
if (isset($_SESSION['AUID'])) {
  echo "<script>
    alert('이미 로그인되어 있습니다.');
    location.href='/pinkping/admin/index.php';
  </script>";
}
?>

<div class="container">
  <form action="login_ok.php" method="POST">
    <h1 class="text-center">관리자 로그인</h1>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" name="userid" id="userid" placeholder="아이디">
      <label for="userid">아이디</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="passwd" id="passwd" placeholder="비밀번호">
      <label for="passwd">비밀번호</label>
    </div>
    <div class="mt-3 text-end">
      <button class="btn btn-primary">로그인</button>
    </div>
  </form>
</div>


<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>