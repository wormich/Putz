/*
 * Модуль корзины для ImageCMS
 * Автор: Чуйков Константин
 * www.chuikoff.ru
 */




var Cart = new Object({
    show_cart: function() {
        
            $.ajax({
            url: '/basket/cart_empty',
            type: 'post',
            success: function(data) {
            if (data==0){
                
              $('.row_final').hide()
                 $('.js-add-webforms-cart,.cart-info').hide();
                 $('#empty').html('<p>Ваша корзина пуста</p>')
            }else{
                            $.ajax({
            url: '/basket/total_sum',
            type: 'post',
            success: function(data) {
                $('.totalx').html(data);
                
                 $('.totalx').priceFormat({
    prefix: '',
      clearPrefix: true,
    clearSuffix: true,
    centsSeparator: '.',
    thousandsSeparator: '&nbsp;'
});                                
              
            }
        });
                
                    $.ajax({
            url: '/basket/show_cart',
            type: 'post',
            success: function(data) {
                $('.cart').empty().html(data);
              
            },
            error: function(data) {
                $('.cart').empty().text('Нет данных');
            }
        });
                
                                                                
            }
            
            
            
            }
           
        });
        
        
    
    },
    add_cart: function(id, title, price, number) {
        $.ajax({
            url: '/basket/add_cart',
            type: 'post',
            data: ({'id': id, 'title': title, 'price': price, 'number': number}),
            success: function(data) {
                Cart.show_cart();
            },
            error: function(data) {
            }
        });
    },
    delete_item: function(id) {
        $.ajax({
            url: '/basket/delete_item',
            type: 'post',
            data: ({'id': id}),
            success: function(data) {
                Cart.show_cart();
                
$("#cart_"+id).remove()
            },
            error: function(data) {
            }
        });
    },
    change_number: function(it, id, num) {
        $(it).hide();
        $(it).after('<input type="text" name="number" size="3" value="' + num + '" \/>');
        $(it).next().blur(function()
        {
            $.ajax({
                url: '/basket/change_number',
                data: {'id': id, 'num': $(this).val()},
                type: 'post',
                success: function(data)
                {   
                    Cart.show_cart();
                }
            });
            $(it).html($(this).val()).show();
            var total = parseFloat($(this).val()) * parseFloat($('tr.item_'+id+' td.item_elem_price').text());
            $('tr.item_'+id+' td.item_total_price').text(total);
            $(this).remove();
        });
    },
        update_number: function(it, id, num, a) {
        if (num<1){
        Cart.delete_item(id);$('.item_'+id).empty();   
        } else {
            $.ajax({
                url: '/basket/change_number',
                data: {'id': id, 'num': num},
                type: 'post',
                success: function(data)
                {
                $('#count_'+id).val(num);
                $('.totalx').html(data);
                }
            });
}
        },
    cancel_order: function(id) {
        $.ajax({
            url: '/basket/cancel_order',
            type: 'post',
            data: ({'id': id}),
            success: function(data) {
            },
            error: function(data) {
            }
        });
    },/*
    add_order: function() {

        $('.load').show();
        $.ajax({
            url: '/basket/add_order',
            type: 'post',
            data: $('#add_order').serialize(),
            success: function(data) {
                $('.load').hide();
                $('.results').html(data);
            },
            error: function(data) {
                $('.load').hide();
            }
        });
    }*/
});