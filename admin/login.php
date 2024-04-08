<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';
?>

<div class="container">
  <form action="login_ok.php" method="POST">
    <h1 class="text-center">관리자 로그인</h1>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="userid" name="userid" placeholder="아이디">
      <label for="userid">아이디</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="passwd" name="passwd" placeholder="비밀번호">
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