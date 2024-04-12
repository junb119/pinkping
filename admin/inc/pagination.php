<?php
// 페이지네이션 시작
$cntsql = "SELECT COUNT(*) AS cnt FROM $pageNationTarget where 1=1"; 
$cntsql .= $search_where;
$cntresult = $mysqli->query($cntsql);
$cntrow = $cntresult->fetch_object();
$count = $cntrow -> cnt; //검색 개수 출력

$pageNumber = $_GET['pageNumber'] ?? 1;
$pageCount = $_GET['pageCount'] ?? 5;
$startLimit = ($pageNumber -1)*$pageCount;
$endLimit = $pageCount ;
$firstPageNumber = $_GET['firstPageNumber'] ?? 0;

$block_ct = 5;  //12345, 678910
$block_num = ceil($pageNumber/$block_ct);  //65개수 1/5 0.2 1
$block_start = (($block_num - 1) * $block_ct) + 1; 
$block_end = $block_start + $block_ct - 1;

?>