<?php
function issue_coupon($mysqli, $uid, $num, $reason){

    $csql = "SELECT * FROM coupons WHERE cid={$num}";//축하 쿠폰 조회
    $cresult = $mysqli -> query($csql);
    $crs =  $cresult->fetch_object();

    $due_date = date("Y-m-d 23:59:59", strtotime("+30 days"));

    $ucSql = "INSERT INTO user_coupons (couponid,userid,status,use_max_date,regdate,reason) VALUES (
        '{$crs->cid}',
        '{$uid}',
        {$num},
        '{$due_date}',
        now(),
        '{$reason}'
    )";
    $ucResult = $mysqli -> query($ucSql);
    $couponName = $crs->coupon_name;

    echo "<script>
        alert('회원가입 완료!, $couponName 쿠폰이 발행되었습니다.');
        location.href='/pinkping/index.php';
    </script>";


}
?>