<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$pid = $_POST['pid'];

$cate1 = $_POST['cate1'] ?? '';
$cate2 = $_POST['cate2'] ?? '';
$cate3 = $_POST['cate3'] ?? '';
$orgcate = $_POST['orgcate'] ?? '';
$cate = $cate1 . $cate2 . $cate3 ;

if(strlen($cate) == 0){
  $cate = $orgcate;
}

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
$sql = "UPDATE products SET 
  name= '{$name}',
  cate= '{$cate}',
  content = '{$content}',
  thumbnail = '{$thumbnail}',
  price =   '{$price}',
  sale_price =   '{$sale_price}',
  sale_ratio =   '{$sale_ratio}',
  cnt = '{$cnt}',
  sale_cnt = '{$sale_cnt}',
  ismain = '{$ismain}',
  isnew = '{$isnew}',
  isbest = '{$isbest}',
  isrecom = '{$isrecom}',
  locate = '{$locate}',
  userid = '{$userid}',
  sale_end_date = '{$sale_end_date}',
  reg_date = now(),
  status = '{$status}',
  delivery_fee = '{$delivery_fee}'
  WHERE pid = {$pid}";

$result = $mysqli->query($sql);
//$pid = $mysqli->insert_id;

if ($result) { //상품 등록 하면

  if(strlen($addedImg_id) > 0){ //추가 이미지가 있다면 12,13
    $sql = "UPDATE product_image_table SET pid = {$pid} where imgid in ({$addedImg_id})";
    $result = $mysqli->query($sql);
  }

  //추가 옵션이 있다면
  
  $optionName1 = $_REQUEST['optionName1'] ?? ''; //옵션명

  if(isset($optionName1)){
    $optionCnt1 = $_REQUEST['optionCnt1'] ?? ''; //옵션 재고
    $optionPrice1 = $_REQUEST['optionPrice1'] ?? ''; //옵션 가격

    if($_FILES['optionImage1']['name'][0]){ //옵션에 이미지 있다면
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
    }

    // $pid에 대한 $poid 값을 조회하는 쿼리
    $pid_query = "SELECT poid FROM product_options WHERE pid = {$pid}";
    $pid_result = $mysqli->query($pid_query);

    // 조회 결과를 배열에 저장
    while ($row = $pid_result->fetch_assoc()) {
        $poid_array[] = $row['poid'];
    }

    $x = 0;
    foreach($optionName1 as $opt){
        $optsql = "UPDATE product_options SET 
                    cate='{$optionCate1}',
                    option_name='{$opt}', 
                    option_cnt='{$optionCnt1[$x]}', 
                    option_price='{$optionPrice1[$x]}', 
                    image_url='{$upload_option_image[$x]}'        
                    WHERE pid={$pid} AND poid = {$poid_array[$x]}";
    
        echo $optsql; // 쿼리문이 제대로 생성되었는지 확인하기 위한 코드
        $optresult = $mysqli->query($optsql); // 쿼리 실행
        $x++;
    }    
  }


  echo "<script>
  alert('상품 등록 완료');
//location.href = '/pinkping/admin/product/product_list.php';
  </script>";
} else {
  echo "<script>
  alert('상품 등록 실패');
history.back();
  </script>";
}
