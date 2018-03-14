/**
 * Created by user848 on 16.01.2018.
 */
$(".news-check input").change(function() {
    if (this.checked) {
        $(this).parents('form').find('.linenews').css('display', 'block');
    } else {
        $(this).parents('form').find('.linenews').css('display', 'none');
    }
});
//Функция достает GET параметр из урла 
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//Функция открывающая документацию и сферу применения
function get_doc() {

    var xxx = getParameterByName('scroll-id');


    if (xxx && xxx > 0) {
        $('.ss' + xxx).parents('.drop-archive').show();
        $('.ss' + xxx).parents('.item-archive').addClass('active');
        $('html, body').animate({
            scrollTop: $('#i' + xxx).offset().top
        }, 500);

    }


}

//Функция открывающая документацию и сферу применения

$('.pag-cat span').click(function() {
    var toLoad = $(this).find('a').attr('href') + ' .out_row>div';
    var toLoadpag = $(this).find('a').attr('href') + ' .but_more>span>a';
    $(this).html('<div id="fountainG"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div>');
    $(this).parents('.catalog-products').find('.out_row').append('<div class="out_row"></div>');
    $('.out_row').last().load(toLoad, '');
    $(this).load(toLoadpag, '');
    return false;
});

function pagAJAX(PA) {
    var toLoad = PA.find('a').attr('href') + ' .out_row>div';
    var toLoadpag = PA.find('a').attr('href') + ' .but_more>span>a';
    PA.html('<div id="fountainG"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div>');
    PA.parents('.catalog-products').find('.out_row').append('<div class="out_row"></div>');
    $('.out_row').last().load(toLoad, '');
    PA.load(toLoadpag, '');
    return false;
};

//Действие в форме при выборе категории
$('select.resscat-s').change(function() {
    var id = $("select.resscat-s option:selected").attr('data-id');
    if ($('select.ressmodel-s option.i' + id).length > 0) {
        $('div.ressmodel-s').removeClass('disabled');
        $('.ressmodel-s ul li').addClass('empty');
        $('.ressmodel-s ul li.i' + id).each(function() {
            $(this).removeClass('empty');
        });
    } else {
        $('div.ressmodel-s').addClass('disabled');
        $('div.ressmodel-s .next_out').trigger('click');
    };
})

$('li.w-order>a').click(function() {
    if ($(this).parents('li').hasClass('active') == false) {
        $(this).parents('li').addClass('active');
        $(this).parents('li').find('.drop-down').css('display', 'block');
    } else {
        $(this).parents('li').removeClass('active');
        $(this).parents('li').find('.drop-down').css('display', 'none');
    };
});
$('.order-b.drop-down>.close').click(function() {
    $('.w-order.active').removeClass('active');
    $('.order-b.drop-down').css('display', 'none');
})
jQuery(function($) {
    $(document).mouseup(function(e) {
        var div = $(".drop-down,.new");
        if (!div.is(e.target) &&
            div.has(e.target).length === 0) {
            $(".drop-down").css('display', 'none');
            $('li.w-order').removeClass('active');
        }
    });
});
$('.feedback').click(function() {
    $('.w-order > a').click();
    $('html,body').animate({
        scrollTop: 0
    }, 600);
    return false;
});
$('.regions-b .link, .product-w').click(function() {
    //$('.regions-b .link, .w-order > a').click(function() {
    var that = $(this).parent();
    if ($(that).hasClass('active')) {
        $(that).find('.drop-down').hide();
        $(that).removeClass('active');
        return false;
    } else {
        $(that).addClass('active');
        $(that).find('.drop-down').fadeIn(200);
        return false;
    }
});
$('.w-order .order-b .close').on("click", function(event) {
    $(this).parent().hide();
    $(this).parents('.w-order').removeClass('active');
    return false;
});

//Стилизация селектов

/*Стрелка на главной странице*/
$('.arrow').click(function() {
    $('.products').toggle('slow');
    $(this).toggleClass("highlight");

});
/*Кнопка наверх*/
$("#back-top").hide();
$(window).scroll(function() {
    if ($(this).scrollTop() > 250) {
        $('#back-top').fadeIn();
    } else {
        $('#back-top').fadeOut();
    }
});
$('#back-top a').click(function() {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
    return false;
});

$('.spare-one a').click(function() {
    $(this).parent().find('.order-b').css('display', 'block');
});


$(document).ready(function() {


    get_doc()

    var fullH = $('.catalog-realated').height();
    var oneH = $('.catalog-realated .list-item-product').first().height();
    if (fullH / oneH <= 1) {
        $('.realated-ps').css('display', 'none');
    };
    $('.realated-ps').attr('data-num', fullH / oneH);
    $('.realated-ps').attr('this-num', '1');
    $('.catalog-realated').css('height', oneH + 'px');
    $('.realated-ps').click(function() {
        var a = $(this).attr('this-num');
        $(this).attr('this-num', parseFloat(a) + parseFloat(1));
        $('.catalog-realated').css('height', (parseFloat(a) + parseFloat(1)) * oneH + 'px');
        if (parseFloat(a) + parseFloat(1) >= $(this).attr('data-num')) {
            $(this).css('display', 'none');
        };
    });

    $('.eur_price').priceFormat({
        prefix: '',
        clearPrefix: true,
        clearSuffix: true,
        centsSeparator: '.',
        thousandsSeparator: '&nbsp;'
    });
    $('.rur_price').priceFormat({
        prefix: '',
        clearPrefix: true,
        clearSuffix: true,
        centsSeparator: '.',
        thousandsSeparator: '&nbsp;'
    });


    $('.totalx').priceFormat({
        prefix: '',
        clearPrefix: true,
        clearSuffix: true,
        centsSeparator: '.',
        thousandsSeparator: '&nbsp;'
    });




    $('.item-archive>a').click(function() {
        if ($(this).parent().hasClass('active') == false) {
            $(this).parent().addClass('active');
            $(this).parent().find('.drop-archive').first().show('fast');
        } else {
            $(this).parent().removeClass('active');
            $(this).parent().find('.drop-archive').hide('fast');
            $(this).parent().find('.item-archive').removeClass('active');
        }
        return false;
    });
    (function($) {
        $(function() {
            $('.ress,.select-s-map').styler({
                selectSearch: true,
            });
        });
    })(jQuery);

    $('.new-but button').click(function() {
        if ($(this).hasClass('active') == false) {
            $(this).addClass('active');
            $('.menu-fix').addClass('fixed');
        } else {
            $(this).removeClass('active');
            $('.menu-fix').removeClass('fixed');
            $('.bot-menu').removeClass('fixed');
        };
    });
    $('.rowmenufut button').click(function() {
        $('.bot-menu').addClass('fixed');
        $('.new-but button').addClass('active');
    });
    //Действие фильтра документации при выборе категории
    $('select.resscat').change(function() {
        //Сбрасываем выбранное ранее
        $('div.ressmodel').addClass('disabled');
        $('div.ressmodel .next_out').trigger('click');
        $('div.resstype').addClass('disabled');
        $('div.resstype .next_out').trigger('click');
        var id = $("select.resscat option:selected").attr('data-id');
        //Проверяем наличие доккументации - тип
        if ($('select.resstype option.' + id).length > 0) {
            $('div.resstype').removeClass('disabled');
            $('.resstype ul li').addClass('empty');
            $('.resstype ul li.' + id).each(function() {
                $(this).removeClass('empty');
            });
            $('select.resstype option.' + id).each(function() {
                $(this).css('display', '');
            });
        } else {
            //Если документация по типу отсутствует, проверяем наличие по модели
            if ($('select.ressmodel option.' + id).length > 0) {
                $('div.ressmodel').removeClass('disabled');
                $('select.ressmodel option').css('display', 'none');
                $('.ressmodel ul li').addClass('empty');
                $('.ressmodel ul li.' + id).each(function() {
                    $(this).removeClass('empty');
                });
                $('select.ressmodel option.' + id).each(function() {
                    $(this).css('display', '');
                });
                //Если документация по модели отсутствует
            } else {
                $('div.ressmodel').addClass('disabled');
                $('div.ressmodel .next_out').trigger('click');
                $('div.resstype').addClass('disabled');
                $('div.resstype .next_out').trigger('click');
            };
        };
    });
    //Действие фильтра документации при выборе типа
    $('select.resstype').change(function() {
        //Сбрасываем выбранное ранее
        $('div.ressmodel').addClass('disabled');
        $('div.ressmodel .next_out').trigger('click');
        var id = $("select.resstype option:selected").val();
        var id = 'i' + id
        console.log(id);
        //Проверяем наличие по модели
        if ($('select.ressmodel option.' + id).length > 0) {
            $('div.ressmodel').removeClass('disabled');
            $('select.ressmodel option').css('display', 'none');
            $('.ressmodel ul li').addClass('empty');
            $('.ressmodel ul li.' + id).each(function() {
                $(this).removeClass('empty');
            });
            $('select.ressmodel option.' + id).each(function() {
                $(this).css('display', '');
            });
            //Если документация по модели отсутствует
        } else {
            $('div.ressmodel').addClass('disabled');
            $('div.ressmodel .next_out').trigger('click');
        };
    });
    //Отправка данных фильтра документации
    $(".doc").submit(function() {
        var form = $(this);
        var error = false;
        if (!error) {
            var data = form.serialize();
            $.ajax({
                type: 'POST',
                url: '/feedback/idout',
                dataType: 'json',
                data: data,
                beforeSend: function(data) {
                    form.find('button[type="submit"]').attr('disabled', 'disabled');
                },
                success: function(data) {

                },
                error: function(xhr, ajaxOptions, thrownError) {

                },
                complete: function(data) {
                    console.log(data.responseText);
                    $('.ss' + data.responseText).parents('.drop-archive').show();
                    $('.ss' + data.responseText).parents('.item-archive').addClass('active');
                    $('html, body').animate({
                        scrollTop: $('#i' + data.responseText).offset().top
                    }, 500);
                    form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        }
        return false;
    });

    $('body').on('submit', '.filtrs', function() {
        var form = $(this);
        var error = false;
        if (!error) {
            var data = form.serialize();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/filtr',
                data: data,
                beforeSend: function(data) {
                    //form.find('button[type="submit"]').attr('disabled', 'disabled');
                    $('.catalog-products').html('<div class="zgr"><div id="fountainG"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div></div>');
                },
                success: function(data) {

                },
                error: function(xhr, ajaxOptions, thrownError) {

                },
                complete: function(data) {
                    console.log(data.responseText);

                    $('.catalog-products').html(data.responseText);
                }
            });
        }
        return false;
    });

    $('.js-add-webforms-cart').submit(function() {
        form = $(this);
        var error = false;
        $(form.find('.required.form-group input')).each(function(key, value) {
            if ($(this).val() == false) {
                var a = $(this).parents('.w-field').attr('dala-label');
                $(this).parents('.w-field').find('.errorMessage').html('Необходимо заполнить поле «' + a + '».');
            } else {
                $(this).parents('.w-field').addClass('true-val');
                $(this).parents('.w-field').find('.errorMessage').html('');
            };
        });
        if (form.find('.required.form-group').length == form.find('.required.form-group.true-val').length) {
            if (!error) {
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: '/basket/add_order',
                    dataType: 'json',
                    data: data,
                    beforeSend: function(data) {
                        form.find('input[type="submit"]').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        form.find('input[type="submit"]').prop('disabled', true);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {

                    },
                    complete: function(data) {
                        if (data.responseText == 'N') {
                            $('.cap_er').html('неверный код');
                            setTimeout(function() {
                                $('.cap_er').html('')
                            }, 2000);
                        } else {
                            $('.bsc').html(data.responseText);
                            form.find('input[type="text"],input[type="phone"],input[type="email"]').val('');
                        }
                        form.find('input[type="submit"]').prop('disabled', false);
                    }
                });
            }
        };
        return false;
    });




    //Форма и капча   
    $('.js-add-webforms').submit(function() {
        form = $(this);
        var error = false;
        $(form.find('.required.form-group input')).each(function(key, value) {
            if ($(this).val() == false) {
                var a = $(this).parents('.w-field').attr('dala-label');
                $(this).parents('.w-field').find('.errorMessage').html('Необходимо заполнить поле «' + a + '».');
            } else {
                $(this).parents('.w-field').addClass('true-val');
                $(this).parents('.w-field').find('.errorMessage').html('');
            };
        });
        if (form.find('.required.form-group').length == form.find('.required.form-group.true-val').length) {
            if (!error) {
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: '/feedback/sender',
                    dataType: 'json',
                    data: data,
                    beforeSend: function(data) {
                        form.find('input[type="submit"]').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        form.find('input[type="submit"]').prop('disabled', true);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {

                    },
                    complete: function(data) {
                        if (data.responseText == 'N') {
                            $('.cap_er').html('неверный код');
                            setTimeout(function() {
                                $('.cap_er').html('')
                            }, 2000);
                        } else {
                            $('.cap_er').html('');
                            $('.succes').html(data.responseText);
                            form.find('input[type="text"],input[type="phone"],input[type="email"]').val('');
                            setTimeout(function() {
                                $('.succes').html('')
                            }, 2000);
                        }
                        form.find('input[type="submit"]').prop('disabled', false);
                    }
                });
            }
        };
        return false;
    });


    $.ajax({
        url: '/feedback/newnum',
        dataType: 'json',
        complete: function(data) {
            $('.cpic').html(data.responseText);
        },
    })
    $('a.new').click(function() {
        $.ajax({
            url: '/feedback/newnum',
            dataType: 'json',
            complete: function(data) {
                $('.cpic').html(data.responseText);
            },
        })
    });
    //END  
    var limit = 24 * 3600 * 1000;
    console.log(limit);
    console.log(localStorage.getItem('hide'));
    var clear_loc = parseInt(localStorage.getItem('hide')) + parseInt(limit);
    console.log(clear_loc);
    if (+new Date() >= clear_loc) {
        localStorage.removeItem("hide");
    }
    if (localStorage.getItem('hide') == null) {
        $('.modal_back').css('display', 'block');
    }
    $('.q, .modal_back').click(function() {
        localStorage.setItem('hide', +new Date());
        $('.modal_back').css('display', 'none');
    });
    setInterval(function() {
        $('.modal_back').css('display', 'none');
        localStorage.setItem('hide', +new Date())
    }, 15000);

});



var count = 0;

function rotate() {
    var elem5 = document.getElementById('div5');
    elem5.style.MozTransform = 'scale(0.5) rotate(' + count + 'deg)';
    elem5.style.WebkitTransform = 'scale(0.5) rotate(' + count + 'deg)';
    if (count == 360) {
        count = 0
    }
    count += 45;
    window.setTimeout(rotate, 100);
}
window.setTimeout(rotate, 100);



//Пересчет цены запчасти при изменении количества 
$(function() {
    var kol = parseInt($('#change_item').val(), 10);
    var price_rub = $('#num').data('rub');
    var price_eur = $('#num').data('eur');

    $('#num').on('keyup change', function() {
        if ($(this).val() <= 0)
            $(this).val(1);
        kol = parseInt($(this).val(), 10);
        $('#change_item').val(kol);
        $('.rur_price').html((price_rub * kol).toFixed(2));
        $('.eur_price').html((price_eur * kol).toFixed(2));
        return false;
    });
    $('.options .input-group a[data-p="pls"]').on('click', function() {
        kol = kol + 1;
        $('#change_item').val(kol);
        $('#num').val(kol);
        $('.rur_price').html((price_rub * kol).toFixed(2));
        $('.eur_price').html((price_eur * kol).toFixed(2));
        return false;
    });
    $('.options .input-group a[data-p="mns"]').on('click', function() {
        kol = kol - 1;
        if (kol <= 0)
            kol = 1;
        $('#change_item').val(kol);
        $('#num').val(kol);
        $('.rur_price').html((price_rub * kol).toFixed(2));
        $('.eur_price').html((price_eur * kol).toFixed(2));
        return false;
    });
});
$('.nav-item .next').on('click',function () {
    if ($(this).hasClass('active')!=false) {
        var a = $('.menu-history li.active a').attr('href');
        if ('#data-' + ((parseFloat($('.menu-history li').length)) - parseFloat(1)) == a) {
            $(this).addClass('disable');
            $(this).removeClass('active');
            $('.menu-history li.active').next('li').addClass('active');
            $('.menu-history li.active').first().removeClass('active');
            $('.add-tabs .tabs.active').next('.tabs').addClass('active');
            $('.add-tabs .tabs.active').first().removeClass('active');
            $('.nav-item .prev').removeClass('disable');
            $('.nav-item .prev').addClass('active');
        } else {
            $('.menu-history li.active').next('li').addClass('active');
            $('.menu-history li.active').first().removeClass('active');
            $('.add-tabs .tabs.active').next('.tabs').addClass('active');
            $('.add-tabs .tabs.active').first().removeClass('active');
            $('.nav-item .prev').removeClass('disable');
            $('.nav-item .prev').addClass('active');
        }
    };
    return false;
});