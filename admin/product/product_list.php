<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/category_func.php';

$cates1 = $_GET['cate1'] ?? '';
$cate2 = $_GET['cate2'] ?? '';
$cate3 = $_GET['cate3'] ?? '';
$ismain = $_GET['ismain'] ?? '';
$isnew = $_GET['isnew'] ?? '';
$isbest = $_GET['isbest'] ?? '';
$isrecom = $_GET['isrecom'] ?? '';
$sale_end_date = $_GET['sale_end_date'] ?? '';
$search_keyword = $_GET['search_keyword'] ?? '';
$cates = $cates1.$cate2.$cate3;

$search_where = "";

if($cates){
  $search_where .= " and cate LIKE '%{$cates}%'";
}
if($ismain){
  $search_where .= " and ismain = 1";
}
if($isnew){
  $search_where .= " and isnew = 1";
}
if($isbest){
  $search_where .= " and isbest = 1";
}
if($isrecom){
  $search_where .= " and isrecom = 1";
}
if($sale_end_date){
  $search_where .= " and sale_end_date >= CAST('{$sale_end_date}' AS datetime )";
}
if($search_keyword){
  $search_where .= " and (name LIKE '%{$search_keyword}%' or content LIKE '%{$search_keyword}%')";
}


$sql = "SELECT * FROM products where 1=1"; //모든 상품 조회 쿼리
$sql .= $search_where;
$order = " order by pid desc";
$sql .= $order;
$result = $mysqli->query($sql);

$cntsql = "SELECT COUNT(*) AS cnt FROM products where 1=1"; //모든 상품 조회 쿼리
$cntsql .= $search_where;
$cntresult = $mysqli->query($cntsql);
$cntrow = $cntresult->fetch_object();
$count = $cntrow -> cnt;

while ($rs = $result->fetch_object()) {
  $rsArr[] = $rs;
}
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<div class="container">
  <h1>상품 목록</h1>
  <form action="" id="search_form">
    <div class="category row">
      <div class="col">

        <select class="form-select" aria-label="대분류" id="cate1" name="cate1" required>
          <option selected disabled>대분류</option>
          <?php
          foreach ($cate1 as $c1) {
          ?>

            <option value="<?= $c1->code; ?>"><?= $c1->name; ?></option>

          <?php
          }
          ?>

        </select>
      </div>
      <div class="col">

        <select class="form-select" aria-label="중분류" id="cate2" name="cate2">

        </select>
      </div>
      <div class="col">

        <select class="form-select" aria-label="소분류" id="cate3" name="cate3">

        </select>
      </div>
    </div>
    <div class="d-flex gap-3 mt-3 justify-content-between align-items-center">
      <div class="group">
        <input class="form-check-input" type="checkbox" value="1" id="ismain" name="ismain">
        <label class="form-check-label" for="ismain">메인</label>

        <input class="form-check-input" type="checkbox" value="1" id="isnew" name="isnew">
        <label class="form-check-label" for="isnew">신제품</label>

        <input class="form-check-input" type="checkbox" value="1" id="isbest" name="isbest">
        <label class="form-check-label" for="isbest">베스트</label>

        <input class="form-check-input" type="checkbox" value="1" id="isrecom" name="isrecom">
        <label class="form-check-label" for="isrecom">추천</label>
      </div>
      <div class="group d-flex align-items-center">
        <label class="form-label text-nowrap" for="end_date">판매종료일</label>
        <input class="form-control" type="text" id="end_date" name="sale_end_date">
      </div>
      <div class="group d-flex align-items-center">
        <input class="form-control" type="text" id="search_keyword" name="search_keyword" placeholder="상품명 또는 내용 입력">
        <button class="btn btn-primary text-nowrap">검색</button>
      </div>
    </div>
  </form>
  <hr>
  <div>
    검색결과 : <?= $count; ?>
  </div>
  <hr>
  <form action="plist_update.php">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">썸네일</th>
          <th scope="col">제품명</th>
          <th scope="col">가격</th>
          <th scope="col">재고</th>
          <th scope="col">메인</th>
          <th scope="col">신제품</th>
          <th scope="col">베스트</th>
          <th scope="col">추천</th>
          <th scope="col">상태</th>
          <th scope="col">보기</th>
          <th scope="col">수정</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($rsArr)) {
          foreach ($rsArr as $item) {
        ?>
            <tr>
              <th scope="row">
                <input type="hidden" name="pid[]" value="<?= $item->pid ?>">
                <img src="<?= $item->thumbnail ?>" alt="" width="150">
              </th>
              <td><?= $item->name ?></td>
              <td><?= $item->price ?></td>
              <td><?= $item->cnt ?></td>
              <td>
                <input class="form-check-input" type="checkbox" value="<?= $item->ismain ?>"  
                  <?php 
                  if($item->ismain){ echo "checked";} 
                  ?>
                id="ismain[<?= $item->pid ?>]" name="ismain <?= $item->ismain ?>" >
              </td>
              <td>
                <input class="form-check-input" type="checkbox" value="<?= $item->isnew ?>" id="isnew[<?= $item->pid ?>]" name="isnew"
                <?php 
                  if($item->isnew){ echo "checked";} 
                  ?>
                >
              </td>
              <td>
                <input class="form-check-input" type="checkbox" value="<?= $item->isbest ?>"  id="isbest[<?= $item->pid ?>]" name="isbest"
                <?php 
                  if($item->isbest){ echo "checked";} 
                  ?>
                >
              </td>
              <td>
                <input class="form-check-input" type="checkbox" value="<?= $item->isrecom ?>"  id="isrecom[<?= $item->pid ?>]" name="isrecom"
                <?php if($item->isrecom){ echo "checked";} ?>
                >             
             
              </td>
              <td>
                <select class="form-select" aria-label="판매상태" name="status[<?= $item->pid ?>]" id="status">
                  <option value="-1"<?php if($item->status == -1){ echo "selected";} ?>>판매중지</option>
                  <option value="0" <?php if($item->status == 0){ echo "selected";} ?>>대기</option>
                  <option value="1" <?php if($item->status == 1){ echo "selected";} ?>>판매중</option>
                </select>
              </td>
              <td><a href="product_view.php?pid=<?= $item->pid; ?>" class="btn btn-info">보기</a></td>
              <td><a href="product_edit.php?pid=<?= $item->pid; ?>" class="btn btn-info">수정</a></td>
            </tr>
        <?php
          }
        }
        ?>
  
      </tbody>
    </table>
    <div class="text-end"><button class="btn btn-primary">일괄 수정</button></div>
  </form>
  <a href="product_up.php" class="btn btn-primary">상품 등록</a>
</div>

<script src="/pinkping/admin/js/makeoption.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  $("#end_date").datepicker({
    dateFormat: "yy-mm-dd"
  });
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>