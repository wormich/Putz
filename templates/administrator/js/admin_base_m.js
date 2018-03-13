function change_status(hrefFn) {
    $.post(hrefFn, {}, function(data) {
        $('.notifications').append(data);
    });
}

function export_csv() {
    $('.export').die('click').live('click', function() {

        if ($('input[name=export]:checked').val() == 'csv') {

            $('#exportUsers').submit();

            hideLoading();
            return false;
        }
    });
}

$(document).ajaxComplete(function(event, XHR, ajaxOptions) {
    export_csv();
});


function wordsIndex() {
    showLoading();

    var data = "update";
    $.ajax({
        url: '/shop/search/updateIndexationWords',
        type: "POST",
        data: data,
        success: function(data){

            showMessage(lang('message') , "Обновление прошло успешно");

            hideLoading();
        }
    });
}

$(document).ready(function() {
    export_csv();

    $('#role_id').live('change', function() {
        var $roleId = $(this).find('option:selected').val();

        $.ajax({
            dataType: "html",
            headers: {
                'X-PJAX': 'X-PJAX'
            },
            url: '/admin/components/cp/user_manager/getRolesTable/' + $roleId,
            success: function(msg) {
                $('#privilege').html(msg);
            }
        });
    })


    if ($('select#type_select'))
        $('select#type_select').live('change', function() {
            if ($(this).val() != '2')
                $('#possVal').slideUp(200);
            else
                $('#possVal').slideDown(200);
        })



    $("#clearAllCache").on("click", function() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {param: 'all'},
            url: '/admin/delete_cache',
            success: function(obj) {
                if (obj.result == true)
                    showMessage(obj.message, '', obj.color);
                else
                    showMessage(obj.message, '', obj.color);
                $('.filesCount').text(obj.filesCount);
            }
        });

        $(this).parent().parent().siblings('a').trigger('click');
    });



    $('.saveButton').live('click', function() {
        var idMenu = $(this).attr('idMenu');
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: $('.saveForm').serialize(),
            url: '/admin/components/cp/menu/update_menu/' + idMenu,
            success: function(obj) {
                if (obj.result == true)
                    showMessage(obj.title, obj.message);
                else
                    showMessage(obj.title, obj.message, 'r');

            }
        });

    });


    $('.createMenu').live('click', function() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: $('.createMenuForm').serialize(),
            url: '/admin/components/cp/menu/create_menu/',
            success: function(obj) {

                if (obj.result == true) {

                    var url = '/admin/components/cp/menu/';
                    redirect_url(url);
                    showMessage(obj.title, obj.message);

                } else {

                    showMessage(obj.title, obj.message, 'r');
                }


            }
        });

    });

});


var delete_function = new Object({
    deleteFunction: function() {
        if ($('#banner_del').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_property').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_brand').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_cert').hasClass('disabled')) {
            return false;
        }
        if ($('#module_delete').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_wid').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_pm').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_warehouse').hasClass('disabled')) {
            return false;
        }
        if ($('#del_sel_role').hasClass('disabled')) {
            return false;
        }
        if ($('#user_del').hasClass('disabled')) {
            return false;
        }
        if ($('#del_in_search').hasClass('disabled')) {
            return false;
        }
        $('.modal_del').modal();

    },
    deleteFunctionConfirm: function(href)
    {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post(href, {
            ids: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.pathname,
                container: '#mainContent'
            });
        });
        $('.modal_del').modal('hide');
        return true;
    }

});


function save_positions_variant(url) {
    var arr = new Array();
    $('input[name=idv]').each(function() {
        arr.push($(this).val());
    });
    $.post(
        url,
        {
            positions: arr
        },
        function(data) {
            $('.notifications').append(data);
        });

}

$(".save_positions_variant").live("sortstop", function(event, ui) {
    var url = $(this).attr('data-url');
    save_positions_variant(url);
});


var delete_functionS = new Object({
    deleteFunctionS: function() {
        if ($('#group_del').hasClass('disabled')) {
            return false;
        }
        $('.modal_dels').modal();
    },
    deleteFunctionConfirmS: function(href)
    {
        var ids = new Array();
        $('input[name=ids]:checked').each(function() {
            ids.push($(this).val());
        });
        $.post(href, {
            ids: ids
        }, function(data) {
            $('#mainContent').after(data);
            $.pjax({
                url: window.location.pathname,
                container: '#mainContent'
            });
        });
        $('.modal_dels').modal('hide');
        return true;
    }

});


var delete_currency_function = new Object({

    deleteCurrencyWithPriceType: function (itemId) {

        $('.modal-remove .modal-body').load('/admin/components/run/shop/currencies/ajaxDeleteWindow/' + itemId, function () {
            return true;
        });
        $('.modal-remove:not(.addNotificationMessage)').modal('show');

        id = itemId;

        return id;
    },

    deleteFunctionConfirm: function(href)
    {
        var data = $('#deleteCurrencyWithPriceType').serialize();

        $.ajax({
            type: 'POST',
            url: href,
            data: data,
            dataType: 'json',
            success: function (data) {

                if (data.recount) {
                    $('#recount').modal();
                    return false;
                }
                
                if (data.success) {
                    $('#currency_tr' + id).remove();
                }
            }
        });

        $('#first').modal('hide');
        return true;

    },
    ajaxRecount: function(url) {
        $.ajax({
            type: "post",
            data: "id=" + id,
            url: url,
            success: function(data) {
                $('#mainContent').after(data);
                if (data.success) {
                    $('#currency_tr' + id).remove();
                }
            }
        });
        $('#recount').modal('hide');
        return true;
    },
});
function showOnSite(id, currentEl) {
    var checkedAsMain = $(currentEl).closest('tr').find('.mainCurrency').attr('checked');
    if (checkedAsMain) {
        event.stopPropagation()
        return false;
    }

    var showStatus = $(currentEl).attr('rel');
    if (showStatus == 1) {
        showStatus = 0;
        currentEl.attr('rel', '0');
    } else {
        showStatus = 1;
        currentEl.attr('rel', '1');
    }

    $.ajax({
        type: "post",
        data: {id: id, showOnSite: showStatus},
        url: '/admin/components/run/shop/currencies/showOnSite',
        success: function(data) {
            //alert(data)
        },
        error: function() {

        }
    });

    return true;
}
function getid(id, product_id) {

    $('#variant_id_hidden').val(id);
    $('#product_id_hidden').val(product_id);
    $('.price_variant').val('');
    $.ajax({
        type: 'POST',
        url: '/admin/components/run/shop/variantprice/attribute',
        data: {id: id},
        dataType: 'json',

        success: function (data) {

            for (var value in data) {
                $('[name="prices[' + data[value].type + ']"]').val(data[value].price)
            }
        }
    });

}
function add() {

    var data = $('#variant').serialize();
    $.ajax({
        type: 'POST',
        url: '/admin/components/run/shop/variantprice/saveVariantsPrice',
        data: data,
        dataType: 'json',

        success: function (data) {
            if (data.success) {
                showMessage('', data.success);
            }
        }
    })
}

$('#price_type').on('change', function() {

    $('#currency').toggle();
});
