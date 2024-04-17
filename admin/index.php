<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';
?>
<div class="container">
  <h1>대쉬보드</h1>
  <div>
    <?php echo "반갑습니다.".$_SESSION['AUNAME']."님" ;?>
    <a href="logout.php">logout</a>
  </div>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>