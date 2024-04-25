<?php

$title = 'Cart';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/head.php';

//print_r($cartArr);
?>

        <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix">
            <div class="container">
                <?php
                if(isset($cartArr)) {

                
                foreach($cartArr as $c){
                    $cpidArr[] = $c->pid;
                    print_r($cpidArr);
                }} else {
                    echo "<script>alert('장바구니 담긴 상품이 없습니다.');history.back();</script>";
                }
                ?>
                <form action="checkout.php" method="POST">
                    <input type="hidden" name="userid" value="<?=$userid;?>">
                    <input type="hidden" name="pid" id="pidArr" value="<?php echo implode(",", $cpidArr)?>">
                    <input type="hidden" name="grand_total" id="grand_total_final" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="cart-table clearfix">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(isset($cartArr)){
                                                foreach($cartArr as $ca){
                                        ?>

                                        <tr>
                                            <td class="cart_product_img d-flex align-items-center">
                                                <a href="#"><img src="<?= $ca-> thumbnail; ?>" alt="<?= $ca-> name; ?>"></a>
                                                <h6>Yellow Cocktail Dress</h6>
                                            </td>
                                            <td class="price"><span><?= $ca-> price; ?></span></td>
                                            <td class="qty">
                                                <div class="quantity">
                                                    <span class="qty-minus"
                                                        onclick="var effect = document.getElementById('qty-<?= $ca -> cartid;?>'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i
                                                            class="fa fa-minus" aria-hidden="true"></i></span>
                                                    <input type="number" class="qty-text" data-id="<?= $ca -> cartid;?>" id="qty-<?= $ca -> cartid;?>" step="1" min="1" max="99"
                                                        name="qty[<?= $ca -> cartid;?>]" value="<?= $ca-> cnt; ?>">
                                                    <span class="qty-plus"
                                                        onclick="var effect = document.getElementById('qty-<?= $ca -> cartid;?>'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i
                                                            class="fa fa-plus" aria-hidden="true"></i></span>
                                                </div>
                                            </td>
                                            <td class="total_price"><span></span><button class="cart_item_del"> x
                                                </button>
                                            </td>
                                        </tr>

                                        <?php         
                                                }
                                            }
                                        ?>                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-footer d-flex mt-30">
                                <div class="back-to-shop w-50">
                                    <a href="shop-grid-left-sidebar.html">Continue shooping</a>
                                </div>
                                <div class="update-checkout w-50 text-right">
                                    <a href="cart_clear_ok.php" id="clearCart">clear cart</a>
                                    <a href="#" id="updateCart">Update cart</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="coupon-code-area mt-70">
                                <div class="cart-page-heading">
                                    <h5>Cupon code</h5>
                                    <p>Enter your cupone code</p>
                                </div>
                                <?php
                                $cSql = "SELECT uc.ucid, c.coupon_name, c.coupon_price FROM user_coupons uc JOIN coupons c ON c.cid = uc.couponid WHERE uc.userid='{$userid}' AND uc.use_max_date >= now() AND uc.status=1";
                                // echo $cSql;
                                $result = $mysqli->query($cSql);
                                
                                while ($cRow = $result->fetch_object()) {
                                    $cpArr[] = $cRow;
                                }

                                ?>                            
                                <select class="form-select" aria-label="쿠폰선택" name="coupon" id="coupon">
                                <?php
                                if (isset($cpArr)) {
                                    foreach($cpArr as $ca){
                                    ?>    
                                <option selected disabled>쿠폰 선택</option>                                    
                                <option data-price="<?=$ca->coupon_price?>" value="<?=$ca->ucid?>"><?=$ca->coupon_name?></option>                                    
                                
                                <?php
                                }}
                                    ?>   
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="shipping-method-area mt-70">
                                <div class="cart-page-heading">
                                    <h5>Shipping method</h5>
                                    <p>Select the one you want</p>
                                </div>

                                <div class="custom-control custom-radio mb-30">
                                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label d-flex align-items-center justify-content-between"
                                        for="customRadio1"><span>Next day delivery</span><span>$4.99</span></label>
                                </div>

                                <div class="custom-control custom-radio mb-30">
                                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label d-flex align-items-center justify-content-between"
                                        for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label d-flex align-items-center justify-content-between"
                                        for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="cart-total-area mt-70">
                                <div class="cart-page-heading">
                                    <h5>Cart total</h5>
                                    <p>Final info</p>
                                </div>

                                <ul class="cart-total-chart">
                                    <li><span>Subtotal</span> <span id="subtotal">$59.90</span></li>
                                    
                                    <li><span id="coupon-name"></span> <span id="coupon-price"></span></li>
                                    
                                    <li><span>Shipping</span> <span>Free</span></li>
                                    <li><span><strong>Total</strong></span> <span><strong id="grandtotal">$59.90</strong></span></li>
                                </ul>
                                <button class="btn karl-checkout-btn">Proceed to checkout</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- ****** Cart Area End ****** -->
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    $('.quantity span').click(function(){
        calcTotal();
    });
    $('.cart_item_del').click(function(){
        $(this).closest('tr').remove();
        calcTotal();
        let cartid =  $(this).closest('tr').find('.qty-text').attr('data-id');
        let data = {
            cartid :cartid
        }
        $.ajax({
            url:'cart_del.php',
            async:false,
            type: 'POST',
            data:data,
            dataType:'json',
            error:function(){},
            success:function(data){
            console.log(data);
            if(data.result=='ok'){
                alert('장바구니가 업데이트 되었습니다');
                location.reload()                     
            }else{
                alert('오류, 다시 시도하세요');                        
                }
            }
        });
    })
    // 쿠폰 적용 계산
    $('#coupon').change(function() {
            let cname = $(this).find('option:selected').text();
            let cprice = $(this).find('option:selected').attr('data-price');
            $('#coupon-name').text(cname)
            $('#coupon-price').text('-'+cprice)
            calcTotal()
        })
    function calcTotal(){
        let cartItem = $('.cart-table tbody tr');
        let subtotal = 0;
        cartItem.each(function(){
            let price = Number($(this).find('.price span').text());
            let qty =  Number($(this).find('.qty-text').val());
            let total_price = $(this).find('.total_price span');
            total_price.text(price*qty);
            subtotal = subtotal+(price * qty);
            
        });
        let discount = Number($('#coupon-price').text());
        let grand_total =subtotal+discount;
        $('#subtotal').text(subtotal);
        $('#grandtotal').text(grand_total );
        $('#grand_total_final').val(grand_total);
    }
    calcTotal();

    //카트 일괄 업데이트
    $('#updateCart').click(function(e){
        e.preventDefault();
        let cartItem = $('.cart-table tbody tr');
        let cartIdArr = [];
        let qtyArr = [];

        cartItem.each(function(){
            let cartid = Number($(this).find('.qty-text').attr('data-id'));
            cartIdArr.push(cartid);

            let qty = Number($(this).find('.qty-text').val());
            qtyArr.push(qty);
        })
        console.log(cartIdArr, qtyArr);
        data = {
            cartid:cartIdArr,
            qty:qtyArr
        }
        $.ajax({
            url:'cart_update.php',
            async:false,
            type: 'POST',
            data:data,
            dataType:'json',
            error:function(){},
            success:function(data){
            console.log(data);
            if(data.result=='ok'){
                alert('장바구니가 업데이트 되었습니다');
                location.reload();
            }else{
                alert('오류, 다시 시도하세요');                        
                }
            }
        });

    });

    /*
    //카트 삭제 업데이트
    $('#clearCart').click(function(e){
        e.preventDefault();

        $.ajax({
            url:'cart_clear.php',
            async:false,
            dataType:'json',
            error:function(){},
            success:function(data){
            console.log(data);
            if(data.result=='ok'){
                alert('장바구니가 비웠습니다.');     
                location.reload();                   
            }else{
                alert('오류, 다시 시도하세요');                        
                }
            }
        });
    })
    */
    
});    
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/tail.php';
?>