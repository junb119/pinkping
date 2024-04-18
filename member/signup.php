<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';
?>
<div class="container">
    <h2>회원가입</h2>
    <form action="signup_ok.php" method="POST">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="username">
            <label for="username">username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="userid" id="userid" placeholder="userid">
            <label for="userid">userid</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="email">
            <label for="email">email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="passwd" id="passwd" placeholder="passwd">
            <label for="passwd">passwd</label>
        </div>
        <button class="btn btn-primary">회원가입</button>
    </form>
</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>