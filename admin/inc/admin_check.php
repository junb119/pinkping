<?php

//관리자 검사
if (!isset($_SESSION['AUID'])) {
  echo "<script>alert('권한이 없습니다.'); location.href='/pinkping/admin/login.php'</script>";
}

?>