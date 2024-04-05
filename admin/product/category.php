<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';
$sql = "SELECT * FROM category where step = 1";
$result = $mysqli->query($sql);
while ($row = $result->fetch_object()) {
  $cate1[] = $row;
}

?>

<div class="container">
  <form action="">
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
  </form>
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
          <div class="modal-body row">
            <div class="col">
              <input type="text" class="form-control" id="code2" name="code2" placeholder="코드명 입력">
            </div>
            <div class="col">
              <input type="text" class="form-control" id="name2" name="name2" placeholder="중분류명 입력">
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
            <button type="submit" class="btn btn-primary" data-step="3">등록</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- //container -->

<script>
  $('#cate1').change(function() {
    makeOption($(this), 2, '중분류', $('#cate2'));
  });
  $('#cate2').change(function() {
    makeOption($(this), 3, '소분류', $('#cate3'));
  });
  $('#cate3').change(function() {

  });

  async function makeOption(e, step, category, target) {
    let cate = e.val();
    let data = new URLSearchParams({
      cate: cate,
      step: step,
      category: category
    });

    try {
      const response = await fetch('printOption.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: data
      });

      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const resultText = await response.text();

      target.html(resultText);
    } catch (error) {
      console.error('Error:', error);
    }
  }

  let categorySubmitBtn = $(".modal button[type='submit']");

  categorySubmitBtn.click(function() {
    let step = $(this).attr('data-step');
    save_category(step);
  });

  function save_category(step) {
    let code = $(`#code${step}`).val();
    let name = $(`#name${step}`).val();

    let data = {
      name: name,
      code: code,
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
        } else {
          alert('등록 실패');
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