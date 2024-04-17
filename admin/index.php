<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/admin/inc/admin_check.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/header.php';

// $sql = "SELECT name FROM category ORDER BY name";

// $result = $mysqli->query($sql);
// while ($rs = $result->fetch_object()){
//   $cateArr[] = $rs;
// }


$sql = "SELECT c.name, count(p.pid) AS product_count 
FROM products p 
JOIN category c
ON p.cate LIKE CONCAT('%',c.code,'%')
GROUP BY c.name";

$result = $mysqli->query($sql);

while($rs = $result->fetch_object()){
  $resultArr[] = $rs;
}



$label =[];
$data =[];
foreach($resultArr as $item){
  array_push($label, $item->name);
  array_push($data, $item->product_count);
}
// print_r($cateNames);


print_r($resultArr);

?>


<style>
  #myChart{
    width: 500px;
    height: 400px;
  }
</style>

<div class="container">
  <h1>대쉬보드</h1>
  <div>
    <?php echo "반갑습니다.".$_SESSION['AUNAME']."님" ;?>
    <a href="logout.php">logout</a>
  </div>
  <div>
    <canvas id="myChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');
    const cateLabels = <?=json_encode($label)?>;
    const cateData = <?=json_encode($data)?>;
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: cateLabels,
        datasets: [{
          label: '카테고리별 상품수',
          data: cateData,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
 
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/footer.php';
?>