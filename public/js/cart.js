
(function($){
 
        $('#add-to-cart').on('click',function(e){
            e.preventDefault();
            var form = $('#cart-form');
            $.post(form.attr('action'),form.serialize() , function(response){
                // alert(response.message);
                if(response.status == 200)
                {
                    Swal.fire('Done!',response.data.message,'success');
                    var cartList = $('#cart-list');
                    cartList.empty();
                    $('#cart-count').text(response.data.cart.length);
                    for(var i in response.data.cart){
                        var item = response.data.cart[i];
                        cartList.append(`<div class="ps-cart-item"><a class="ps-cart-item__close" href="${item.product.id}"></a>
                        <div class="ps-cart-item__thumbnail"><a href="${item.product.id}"></a><img
                                src="${item.product.image_url}" alt=""></div>
                        <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="">
                            ${item.product.name}</a>
                            <p><span>Quantity:<i>${item.quantity}</i></span><span>Total:<i>${item.quantity * item.product.price }</i></span></p>
                        </div>
                    </div>`);
                    var cartListitemCount = $('#cart-item-count');
                    cartListitemCount.empty();
                    cartListitemCount.append(`
                    <div class="ps-cart__total" id="cart-item-count">
                    <p>Number of items:<span>${response.data.cart.length}</span></p>
                    <p>Item Total:<span>${response.data.total}</span></p>
                </div>`
                );
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href="">Why do I have this issue?</a>'
                      });
                      $("#cart-list").load(location.href + " #cart-list>*", "");
                }
                
            });  //ajax request from myform
        });

})(jQuery);
