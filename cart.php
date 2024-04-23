<?php
$title = 'Cart';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/head.php';

//print_r($cartArr);
?>

        <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                          <form action="#" id="cartTable">
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
                                                    name="qty[-<?= $ca -> cartid;?>]" value="<?= $ca-> cnt; ?>">
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
                          </form>
                        </div>
                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="shop-grid-left-sidebar.html">Continue shooping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <a href="#" id="clearCart">clear cart</a>
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
                            <form action="#">
                                <input type="search" name="search" placeholder="#569ab15">
                                <button type="submit">Apply</button>
                            </form>
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
                                <li><span>Shipping</span> <span>Free</span></li>
                                <li><span><strong>Total</strong></span> <span><strong id="grandtotal">$59.90</strong></span></li>
                            </ul>
                            <a href="checkout.html" class="btn karl-checkout-btn">Proceed to checkout</a>
                        </div>
                    </div>
                </div>
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
            }else{
                alert('오류, 다시 시도하세요');                        
                }
            }
        });
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
        $('#subtotal').text(subtotal);

    }
    calcTotal();

    //카트 일괄 업데이트

    $('#updateCart').click(function(e) {
      e.preventDefault();
      let cartItem = $('.cart-table tbody tr');
      let cartIdArr = []
      let qtyArr = []
      cartItem.each(function(){
        let cartid = Number($(this).find('.qty-text').attr('data-id'))
        cartIdArr.push(cartid)

        let qty = Number($(this).find('.qty-text').val())
        qtyArr.push(qty)
      })
      
      data = {
        cartid:cartIdArr,
        qty:qtyArr
      }
      console.log('test',data)
      $.ajax({
        url : 'cart_update.php',
        async : false,
        type :'POST',
        data : data,
        dataType:'json',
        error: function(){},
        success:function(data){
          console.log(data);
          if(data.result=='ok'){
              alert('장바구니를 업데이트했습니다.');                        
          }else{
              alert('담기 실패, 다시 시도하세요');                        
          }
        }
      })

    });
});    
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/tail.php';
?>