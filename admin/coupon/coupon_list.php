<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';

$search_where = "";
$search_keyword = $_GET['keyword'] ?? '';

if($search_keyword){
  $search_where .= " and (coupon_name LIKE '%{$search_keyword}%')";
}

$paginationTarget = 'coupons';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/pagination.php';

$sql = "SELECT * FROM coupons where 1=1"; //모든 상품 조회 쿼리
$sql .= $search_where;
$order = " order by cid desc";
$sql .= $order;
$limit = " LIMIT $startLimit, $endLimit";
$sql .= $limit;

$result = $mysqli->query($sql);

while ($rs = $result->fetch_object()) {
  $rsArr[] = $rs;
}
?>
<!--  -->
<div class="container">
  <h3>쿠폰리스트</h3>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>"> <!--이 페이지 자기자신한테 돌려줄 때. 생략가능-->
    <input class="form-control" type="text" id="search_keyword" name="keyword" placeholder="쿠폰명 입력">
    <button class="btn btn-primary text-nowrap">검색</button>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">사진</th>
          <th scope="col">쿠폰명</th>
          <th scope="col">타입</th>
          <th scope="col">할인가</th>
          <th scope="col">할인율</th>
          <th scope="col">최소사용금액</th>
          <th scope="col">최대할인금액</th>
          <th scope="col">등록자</th>
          <th scope="col">상태</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($rsArr)) {
          foreach($rsArr as $value) {
        ?>
          <tr>
            <td>
              <img src="<?=$value->coupon_image?>" alt="">  
            </td>
            <td><?=$value->coupon_name?></td>
            <td><?=$value->coupon_type?></td>
            <td><?=$value->coupon_price?></td>
            <td><?=$value->coupon_ratio?></td>
            <td><?=$value->use_min_price?>< /td>
            <td><?=$value->max_value?></td>
            <td><?=$value->userid?></td>
            <td><?=$value->status?></td>
          </tr>
        <?php
        }}
        ?>
      </tbody>
  </table>
  <a href="coupon.up.php" class="btn btn-primary">쿠폰 등록</a>
  </form>
</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';

?>