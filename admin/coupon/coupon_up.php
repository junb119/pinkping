<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';

?>

<div class="container">
  <h2>쿠폰등록</h2>
  <form action="coupon_ok.php" enctype="multipart/form-data" method="POST">
    <table class="table">
        <tbody>
          <tr>
            <th scope="row">
              <label for="coupon_name">쿠폰명</label>
            </th>
            <td>
              <input type="text" name="coupon_name" class="form-control" id="coupon_name" required>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="coupon_image">쿠폰이미지</label>
            </th>
            <td>
              <input type="file" name="coupon_image" class="form-control" id="coupon_image" required>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="coupon_type">쿠폰타입</label>
            </th>
            <td>
              <select class="form-select" name="coupon_type" id="coupon_type" aria-label="쿠폰타입선택">
                <option value="1" selected>정액</option>
                <option value="2">정률</option>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="coupon_price">할인금액</label>
            </th>
            <td>
              <input type="text" name="coupon_price" class="form-control" id="coupon_price">
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="coupon_ratio">할인비율</label>
            </th>
            <td>
              <input type="text" name="coupon_ratio" class="form-control" id="coupon_ratio" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="status">상태</label>
            </th>
            <td>
              <select name="status" class="form-select" id="status">
                  <option value="1" selected>대기</option>
                  <option value="2">사용중</option>
                  <option value="3">폐기</option>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="max_value">최대할인금액</label>
            </th>
            <td>
              <input type="text" name="max_value" class="form-control" id="max_value" required>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="use_min_price">최소사용금액</label>
            </th>
            <td>
              <input type="text" name="use_min_price" class="form-control" id="use_min_price" required>
            </td>
          </tr>
        </tbody>
    </table>
    <button class="btn btn-primary">쿠폰 등록</button>
  </form>
</div>

<script>
    $('#coupon_type').change(function() {

      $('#coupon_ratio, #coupon_price').prop('disabled', false)
      if( $(this).val() ==1 ) {
        $('#coupon_ratio').prop('disabled', true)
      } else {
        $('#coupon_price').prop('disabled', true)
      }
    })
</script>


<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>

