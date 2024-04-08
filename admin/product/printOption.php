<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/dbcon.php';

$cate = $_POST['cate'];
$step = $_POST['step'];
$category = $_POST['category'];

$html = "<option selected disabled>" . $category . "</option>";
$sql = "SELECT * FROM category where step = {$step} and pcode = '{$cate}'";
$result = $mysqli->query($sql);

while ($row = $result->fetch_object()) {
  //$html .= "<option value=\"" . $row->code . "\">" . $row->name . "</option>";
  $html .= "<option value=\"$row->code\">  $row->name </option>";
}

echo $html;
