<?php
ob_start(); //output buffering start
/*
ob_start()

"output buffering start → 출력 버퍼링 시작"
출력 버퍼링은 출력물이 php에 파싱되어 echo나 print에 의해 브라우저로 출력되는 방법이 일반적인데, 필요에 의해 출력 결과물을 바로 브라우저로 보내지 않고, 내용물을 잠깐 동안 버퍼에 보관해 두었다가 출력이 필요할 곳에 이를 사용할 수 있다.
(화면에 내용을 출력하기 전에 상품 정보를 쿠키에 담기 위해)
 */

session_start();
$title = 'Product Detail';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/head.php';

// setcookie('recent_viewed', '17,15', time()+86400);   // 쿠키가 24시간 지속됨
// print_r(json_encode($_COOKIE['recent_viewed']));
// print_r(json_decode($_COOKIE['recent_viewed']));


$pid = $_GET['pid'];
$rvcArr=[];
if(isset($_COOKIE['recent_viewed'])) {  // 쿠키가 존재할 때 !false == true
    $rvcArr = json_decode($_COOKIE['recent_viewed']);  // string -> array
    // $rvcArr = explode(",", $rvc);
    if (!in_array($pid, $rvcArr)) { // 이미 본 상품이 아니라면
        if(count($rvcArr) >= 3){
            array_shift($rvcArr);
        }
        array_push($rvcArr, $pid);
        $rbcStr = json_encode($rvcArr);
        setcookie('recent_viewed', $rbcStr, time()+86400, "/");   // 쿠키가 24시간 지속됨
    } 

} else {
    array_push($rvcArr, $pid);
    $rbcStr = json_encode($rvcArr);
    setcookie('recent_viewed', $rbcStr, time()+86400, "/");   // 쿠키가 24시간 지속됨
}

// 상품기본정보 조회 $sql1, $result1 $rs
$sql1 ="SELECT * FROM products WHERE pid={$pid}";
$result1 = $mysqli->query($sql1);
$rs = $result1->fetch_object();

// 추가이미지 조회 $sql2, $result2, $addedImgs
$sql2 = "SELECT * FROM product_image_table WHERE pid={$pid}";
$result2 = $mysqli->query($sql2);
while ($rs2 = $result2->fetch_object()) {
    $addedImgs[] = $rs2;
}

// 옵션 조회 $sql3, $result3, $optArr
$sql3 = "SELECT * FROM product_options WHERE pid={$pid}";
$result3 = $mysqli->query($sql3);
while ($rs3 = $result3->fetch_object()) {
    $optArr[] = $rs3;
}
?>
        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area Start <<<<<<<<<<<<<<<<<<<< -->
        <div class="breadcumb_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Dresses</a></li>
                            <li class="breadcrumb-item active">Long Dress</li>
                        </ol>
                        <!-- btn -->
                        <a href="#" class="backToHome d-block"><i class="fa fa-angle-double-left"></i> Back to Category</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<< Breadcumb Area End <<<<<<<<<<<<<<<<<<<< -->

        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area Start >>>>>>>>>>>>>>>>>>>>>>>>> -->
        <section class="single_product_details_area section_padding_0_100">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">

                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(<?= $rs->thumbnail?>);">
                                    </li>
                                    <?php
                                    if (isset( $addedImgs)) {
                                        $i=1;
                                        foreach($addedImgs as $ai) {
                                            
                                    ?>
                                    <li data-target="#product_details_slider" data-slide-to="<?=$i?>" style="background-image: url('/pinkping/admin/upload/<?= $ai->filename;?>');">
                                    </li>
                                    <?php
                                        $i++;
                                        }}
                                    ?>
                                </ol> 

                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="<?= $rs->thumbnail;?>">
                                        <img class="d-block w-100" src="<?= $rs->thumbnail;?>" alt="First slide">
                                    </a>
                                    </div>
                                    <?php
                                    if (isset( $addedImgs)) {
                                        foreach($addedImgs as $ai) {
                                    ?>
                                        <div class="carousel-item ">
                                            <a class="gallery_img" href="/pinkping/admin/upload/<?=$ai->filename;?>">
                                            <img class="d-block w-100" src="/pinkping/admin/upload/<?= $ai->filename;?>" alt="slide">
                                        </a>
                                        </div>
                                    <?php
                                        }}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="single_product_desc">

                            <h4 class="title"><a href="#"><?=$rs->name?></a></h4>

                            <h4 class="price"><?=$rs->price?></h4>

                            <p class="available">Available: <span class="text-muted">In Stock</span></p>

                            <div class="single_product_ratings mb-15">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>

                            <div class="widget size mb-50">
                                <h6 class="widget-title"><?php
                                if(isset($optArr[0])){
                                    echo $optArr[0]->cate;
                                }
                                ?>
                                </h6>
                                <div class="widget-desc">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>선택</th>
                                                <th>옵션명</th>
                                                <th>재고</th>
                                                <th>가격</th>
                                                <th>이미지</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(isset($optArr)) {
                                                    foreach($optArr as $oa){
                                            ?>
                                            <tr>
                                                <td><input type="radio" name="option1" id="option1_<?=$oa->poid;?>" value="<?=$oa->poid;?>" data-value="<?=$oa->option_price?>" data-name="<?=$oa->option_name;?>" ></td>
                                                <td><label for="option1_<?=$oa->poid;?>"><?=$oa->cate?></label></td>
                                                <td><?=$oa->option_cnt?></td>
                                                <td><?=$oa->option_price?></td>
                                                <td>
                                                    <img src="<?=$oa->image_url?>" alt="">
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Add to Cart Form -->
                            <form class="cart clearfix mb-50 d-flex" method="post">
                                <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                                <button type="submit" name="addtocart" value="5" class="btn cart-submit d-block">Add to cart</button>
                            </form>
                            <div>
                                <h6 class="widget-title total">Total : <span><?=$rs->price
                                
                                ?></span></h6>
                            </div>
                            <div id="accordion" role="tablist">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Information</a>
                                        </h6>
                                    </div>

                                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <?=$rs->content?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cart Details</a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos nemo, nulla quaerat. Quibusdam non, eos, voluptatem reprehenderit hic nam! Laboriosam, sapiente! Praesentium.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia magnam laborum eaque.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">shipping &amp; Returns</a>
                                        </h6>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint repudiandae suscipit ab soluta delectus voluptate, vero vitae, tempore maxime rerum iste dolorem mollitia perferendis distinctio. Quibusdam laboriosam rerum distinctio. Repudiandae fugit odit, sequi id!</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae qui maxime consequatur laudantium temporibus ad et. A optio inventore deleniti ipsa.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area End >>>>>>>>>>>>>>>>>>>>>>>>> -->

        <!-- ****** Quick View Modal Area Start ****** -->
        <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    <div class="modal-body">
                        <div class="quickview_body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-5">
                                        <div class="quickview_pro_img">
                                            <img src="img/product-img/product-1.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-7">
                                        <div class="quickview_pro_des">
                                            <h4 class="title">Boutique Silk Dress</h4>
                                            <div class="top_seller_product_rating mb-15">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <h5 class="price">$120.99 <span>$130</span></h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita quibusdam aspernatur, sapiente consectetur accusantium perspiciatis praesentium eligendi, in fugiat?</p>
                                            <a href="#">View Full Product Details</a>
                                        </div>
                                        <!-- Add to Cart Form -->
                                        <form class="cart" method="post">
                                            <div class="quantity">
                                                <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>

                                                <input type="number" class="qty-text" id="qty2" step="1" min="1" max="12" name="quantity" value="1">

                                                <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                            </div>
                                            <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                            <!-- Wishlist -->
                                            <div class="modal_pro_wishlist">
                                                <a href="wishlist.html" target="_blank"><i class="ti-heart"></i></a>
                                            </div>
                                            <!-- Compare -->
                                            <div class="modal_pro_compare">
                                                <a href="compare.html" target="_blank"><i class="ti-stats-up"></i></a>
                                            </div>
                                        </form>

                                        <div class="share_wf mt-30">
                                            <p>Share With Friend</p>
                                            <div class="_icon">
                                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Quick View Modal Area End ****** -->

        <section class="you_may_like_area clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2>related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="you_make_like_slider owl-carousel">

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-1.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-2.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-3.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-4.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>

                            <!-- Single gallery Item -->
                            <div class="single_gallery_item">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <img src="img/product-img/product-5.jpg" alt="">
                                    <div class="product-quicview">
                                        <a href="#" data-toggle="modal" data-target="#quickview"><i class="ti-plus"></i></a>
                                    </div>
                                </div>
                                <!-- Product Description -->
                                <div class="product-description">
                                    <h4 class="product-price">$39.90</h4>
                                    <p>Jeans midi cocktail dress</p>
                                    <!-- Add to Cart -->
                                    <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<script>
    document.addEventListener('DOMContentLoaded', ()=>{
        $('.widget-desc input[type="radio"]').change(function(){
            calcTotal();
        });
        $('.quantity span').click(function(){
            calcTotal();
        });
        let target = $('.widget-desc input[type="radio"]:checked');
        function calcTotal(){
            let optprice = Number(target.attr('data-value')) ;
            let qty = Number($('#qty').val());
            console.log(optprice, qty);

            let total = optprice * qty;
            $('.total span').text(total);
        }
        $('.cart').on('submit', function(e) {
            e.preventDefault();
            //상품코드, 옵션명, 수량
            
            let pid = <?=$pid;?>
            let optname = target.attr('data-name')
            let qty = Number($('#qty').val())
            let data = {
                pid : pid,
                optname : optname,
                qty : qty
            }
            $.ajax({
                url :'cart_insert.php',
                async : false,
                data : data,
                dataTyle : 'json',
                error: function(){

                },
                sucess : function(data) {
                    if(data.result = 'ok') {
                        alert('장바구니 상품을 담았습니다.');
                    } else {
                        alert('담기 실패, 다시 시도하세요..');

                    }
                }
            })
        })
    });
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/tail.php';
?>