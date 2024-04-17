<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$mysqli->autocommit(FALSE);//커밋이 안되도록 지정
try{
  
  $cate1 = $_POST['cate1'] ?? '';
  $cate2 = $_POST['cate2'] ?? '';
  $cate3 = $_POST['cate3'] ?? '';
  $cate = $cate1 . $cate2 . $cate3;

  $name  = $_POST['name'];
  $content  = rawurldecode($_POST['contents']);
  // $thumbnail  = $_POST['thumbnail'];
  $price = $_POST['price'];
  $sale_price = $_POST['sale_price'] ?? 0;
  $sale_ratio = $_POST['sale_ratio'] ?? 0;
  $cnt = $_POST['cnt'] ?? 0;
  $sale_cnt = $_POST['sale_cnt'] ?? 0;

  $ismain = $_POST['ismain'] ?? 0;
  $isnew = $_POST['isnew'] ?? 0;
  $isbest = $_POST['isbest'] ?? 0;
  $isrecom = $_POST['isrecom'] ?? 0;

  $locate = $_POST['locate'] ?? 0;
  $userid = $_SESSION['AUID'];
  $sale_end_date = $_POST['sale_end_date'];

  $status = $_POST['status'] ?? 0;
  $delivery_fee = $_POST['delivery_fee'] ?? 0;
  $addedImg_id = rtrim($_POST['product_image'], ',');

  $optionCate1 = $_POST['optionCate1'] ?? '';//옵션 분류



  //파일 사이즈 검사
  if ($_FILES['thumbnail']['size'] > 10240000) {
    echo "<script>
      alert('10MB 이하만 업로드해주세요');
      history.back();
    </script>";
    exit;
  }
  //이미지 여부 검사
  if (strpos($_FILES['thumbnail']['type'], 'image') === false) {
    echo "<script>
      alert('이미지만 업로드해주세요');
      history.back();
    </script>";
    exit;
  }
  //파일 업로드
  $save_dir = $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/upload/';
  $fiename = $_FILES["thumbnail"]["name"]; //insta.jpg
  $ext = pathinfo($fiename, PATHINFO_EXTENSION); //jpg
  $newfilename = date("YmdHis") . substr(rand(), 0, 6); //202404111137.123123 -> 202404111137123123 
  $savefile = $newfilename . '.' . $ext;  //202404111137123123.jpg

  if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $save_dir . $savefile)) {
    $thumbnail = "/pinkping/admin/upload/" . $savefile;
  } else {
    echo "<script>
    alert('썸네일 등록에 실패했습니다. 관리자에게 문의해주세요');
    history.back();
    </script>";
    exit;
  }
  $sql = "INSERT INTO products (name,cate,content,thumbnail,price,sale_price,sale_ratio,cnt,sale_cnt,	ismain,isnew,isbest,isrecom,locate,userid,sale_end_date,reg_date,status,delivery_fee) VALUES (
    '{$name}',
    '{$cate}',
    '{$content}',
    '{$thumbnail}',
    '{$price}',
    '{$sale_price}',
    '{$sale_ratio}',
    '{$cnt}',
    '{$sale_cnt}',
    '{$ismain}',
    '{$isnew}',
    '{$isbest}',
    '{$isrecom}',
    '{$locate}',
    '{$userid}',
    '{$sale_end_date}',
    now(),
    '{$status}',
    '{$delivery_fee}'
  )";

  $result = $mysqli->query($sql);
  $pid = $mysqli->insert_id;

  if ($result) { //상품 등록 하면

    if(strlen($addedImg_id) > 0){ //추가 이미지가 있다면 12,13
      $sql = "UPDATE product_image_table SET pid = {$pid} where imgid in ({$addedImg_id})";
      $result = $mysqli->query($sql);
    }

    //추가 옵션이 있다면
    $optionName1 = $_REQUEST['optionName1'] ?? ''; //옵션명
    
    if (strlen($optionName1[0]) > 1) {

    $optionCnt1 = $_REQUEST['optionCnt1'] ?? ''; //옵션 재고
    $optionPrice1 = $_REQUEST['optionPrice1'] ?? ''; //옵션 가격

    for($i=0; $i<count($_FILES['optionImage1']['name']); $i++){
      //파일 사이즈 검사
      if ($_FILES['optionImage1']['size'][$i] > 10240000) {
        echo "<script>
          alert('10MB 이하만 업로드해주세요');
          history.back();
        </script>";
        exit;
      }
      //이미지 여부 검사
      if (strpos($_FILES['optionImage1']['type'][$i], 'image') === false) {
        echo "<script>
          alert('이미지만 업로드해주세요');
          history.back();
        </script>";
        exit;
      }
      //파일 업로드
      $save_dir = $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/upload/optiondata/';
      $fiename = $_FILES["optionImage1"]["name"][$i]; //insta.jpg
      $ext = pathinfo($fiename, PATHINFO_EXTENSION); //jpg
      $newfilename = date("YmdHis") . substr(rand(), 0, 6); //202404111137.123123 -> 202404111137123123 
      $savefile = $newfilename . '.' . $ext;  //202404111137123123.jpg

      if (move_uploaded_file($_FILES["optionImage1"]["tmp_name"][$i], $save_dir . $savefile)) {
        $upload_option_image[] = "/pinkping/admin/upload/optiondata/" . $savefile;
      } else {
        echo "<script>
        alert('썸네일 등록에 실패했습니다. 관리자에게 문의해주세요');
        history.back();
        </script>";
        exit;
      }
    } //for 반복문

    $x = 0;
    foreach($optionName1 as $opt){
      $optsql = "INSERT INTO product_options 
      (pid, cate, option_name, option_cnt, option_price, image_url) 
      VALUES (
        {$pid}, '{$optionCate1}', '{$opt}', '{$optionCnt1[$x]}', '{$optionPrice1[$x]}', '{$upload_option_image[$x]}'
      )";
      $optresult = $mysqli -> query($optsql);
      $x++;
    }    
  }
    $mysqli->commit();//디비에 커밋한다.

    echo "<script>
    alert('상품 등록 완료');
    location.href = '/pinkping/admin/product/product_list.php';
    </script>";
    }

} catch (Exception $e) {
   $mysqli->rollback();//커밋을 롤백(되돌린다)한다.

    echo "<script>
    alert('상품 등록 실패');
    history.back();
    </script>";
}
