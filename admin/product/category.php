<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';

$sql = "SELECT * FROM category where step = 1";
$result = $mysqli->query($sql);
while ($row = $result->fetch_object()) {
  $cate1[] = $row;
}

?>

<div class="container">

  <div class="category row">

    <div class="col-md-4">

      <select class="form-select" aria-label="대분류" id="cate1">
        <option selected>대분류</option>
        <?php
        foreach ($cate1 as $c1) {
        ?>

          <option value="<?= $c1->code; ?>"><?= $c1->name; ?></option>

        <?php
        }
        ?>

      </select>
    </div>
    <div class="col-md-4">

      <select class="form-select" aria-label="중분류" id="cate2">

      </select>
    </div>
    <div class="col-md-4">

      <select class="form-select" aria-label="소분류" id="cate3">

      </select>
    </div>

  </div>

  <div class="buttons mt-3">
    <!-- 대분류 등록 버튼 -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate1Modal">
      대분류 등록
    </button>

    <!--대분류 등록 Modal -->
    <div class="modal fade" id="cate1Modal" tabindex="-1" aria-labelledby="cate1ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cate1ModalLabel">대분류 등록</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body row">
            <div class="col">
              <input type="text" class="form-control" id="code1" name="code1" placeholder="코드명 입력">
            </div>
            <div class="col">
              <input type="text" class="form-control" id="name1" name="name1" placeholder="대분류명 입력">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            <button type="submit" class="btn btn-primary" data-step="1">등록</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 중분류 등록 버튼 -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate2Modal">
      중분류 등록
    </button>

    <!-- 중분류 등록 Modal -->
    <div class="modal fade" id="cate2Modal" tabindex="-1" aria-labelledby="cate2ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cate2ModalLabel">중분류 등록</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <select class="form-select" aria-label="대분류" id="pcode2">
                <option disabled>대분류를 선택해주세요</option>
                <?php
                foreach ($cate1 as $c1) {
                ?>
                  <option value="<?= $c1->code; ?>"><?= $c1->name; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="row mt-3">
              <div class="col">
                <input type="text" class="form-control" id="code2" name="code2" placeholder="코드명 입력">
              </div>
              <div class="col">
                <input type="text" class="form-control" id="name2" name="name2" placeholder="중분류명 입력">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            <button type="submit" class="btn btn-primary" data-step="2">등록</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 소분류 등록 버튼 -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cate3Modal">
      소분류 등록
    </button>

    <!--소분류 등록 Modal -->
    <div class="modal fade" id="cate3Modal" tabindex="-1" aria-labelledby="cate3ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cate3ModalLabel">소분류 등록</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col">
                <select class="form-select" aria-label="대분류" id="pcode2_1">
                  <option selected disabled>대분류를 선택해주세요</option>
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
                <select class="form-select" aria-label="중분류" id="pcode3">
                  <option selected disabled>대분류를 먼저 선택해주세요</option>
                </select>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col">
                <input type="text" class="form-control" id="code3" name="code3" placeholder="코드명 입력">
              </div>
              <div class="col">
                <input type="text" class="form-control" id="name3" name="name3" placeholder="대분류명 입력">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            <button type="submit" class="btn btn-primary" data-step="3">등록</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- //container -->

<script src="/pinkping/admin/js/makeoption.js"></script>
<script>
  let categorySubmitBtn = $(".modal button[type='submit']");

  categorySubmitBtn.click(function() {
    let step = $(this).attr('data-step');
    save_category(step);
  });

  function save_category(step) {
    let code = $(`#code${step}`).val();
    let name = $(`#name${step}`).val();
    let pcode = $(`#pcode${step} option:selected`).val();

    if (step > 1 && !pcode) {
      alert('부모 분류를 선택하세요');
      return;
    }
    if (!code) {
      alert('분류코드를 입력하세요');
      return;
    }
    if (!name) {
      alert('분류명을 입력하세요');
      return;
    }

    let data = {
      name: name,
      code: code,
      pcode: pcode,
      step: step
    }
    $.ajax({
      async: false,
      type: 'post',
      data: data,
      url: "save_category.php",
      dataType: 'json',
      error: function(error) {
        console.log(error);
      },
      success: function(data) {
        console.log(data.result, typeof(data.result));
        if (data.result === 1) {
          alert('등록 성공');
          location.reload(); // 새로고침
        } else if (data.result === '-1') {
          alert('코드가 중복됩니다.');
          location.reload(); //강제 새로고침
        } else if (data.result === 'member') {
          alert('관리자가 아닙니다.');
          location.href = '/pinkping/admin/login.php';
        } else {
          alert('등록 실패');
          location.reload(); // 새로고침
        }

      }
    }); //ajax
  }

  /*
  function makeOption(e, step, category, target) {
    let cate = e.val();
    //console.log(cate);
    // 비동기 방식으로 printOption 값 3개(cate, step, category) 일시키고, 결과가 나오면 target에 html 태그를 생성
    let data = {
      cate: cate,
      step: step,
      category: category
    }
    console.log(data);
    $.ajax({
      async: false, // sucess의 결과가 나오면 작업 수행
      type: 'post',
      data: data,
      url: 'printOption.php',
      dataType: 'html',
      success: function(result) {
        console.log(result);
        target.html(result);
      }
    })
  }
  */
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>