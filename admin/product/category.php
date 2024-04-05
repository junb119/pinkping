<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/pinkping/inc/header.php';
  $sql = "SELECT * FROM category WHERE step=1";

  $result = $mysqli->query($sql);

  while($row = $result->fetch_object()) {
    $cate1[] = $row;
  }

?>
<div class="container">
  <form action="">
    <div class="category row">
      <div class="col-md-4">
          <select class="form-select" aria-label="대분류">
            <option selected>대분류</option>
            <?php
            foreach($cate1 as $c1) {
              
            ?>
            <option value="1"><?=$c1->name?></option>
            <?php
              } 

            ?>
            <!-- <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option> -->
          </select>
      </div>      
      <div class="col-md-4">
          <select class="form-select" aria-label="중분류">
            <option selected>중분류</option>
            <!-- <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option> -->
          </select>
      </div>
      <div class="col-md-4">
          <select class="form-select" aria-label="소분류">
            <option selected>소분류</option>
            <!-- <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option> -->
          </select>
      </div>
    </div>
  </form>
</div>

<?php
  include_once $_SERVER['DOCUMENT_ROOT'].'/pinkping/inc/footer.php';
?>