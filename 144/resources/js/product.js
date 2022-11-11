var ajaxCalls = [];

function comparisonBoxContentInit() {

    var content = $('#compare-box-content, #comparison-page');
    content.find('.close').click(function () {
        var button = $(this);

        $.ajax({
            type: "POST",
            url: button.data('url'),
            success: function (result) {
                if (result.error == false) {
                    $('#compare-box-content').html(result.box_content);
                    comparisonBoxContentInit();

                    $('.compare-button-' + result.Termek_ID).removeClass('text-green-500 border-green-500').addClass('text-riel-light border-sky-500');

                    var compareBox = $('#compare-box');
                    if (result.count > 0) {
                        compareBox.removeClass('hidden');
                    } else {
                        compareBox.addClass('hidden');
                    }

                    $('#compare-count').text(result.count);

                    if ($('#comparison-page').length > 0) {
                        window.location.reload();
                    }
                }
            },
            dataType: 'json'
        });
    });
}

function comparisonBoxInit() {
    comparisonBoxContentInit();
    $('#compare-clear').click(function () {
        var button = $(this);

        $.ajax({
            type: "POST",
            url: button.data('url'),
            success: function (result) {
                if (result.error == false) {
                    $('.compare-button').removeClass('text-green-500 border-green-500').addClass('text-riel-light border-sky-500');
                    $('.compare-all-btn').addClass('hidden');
                    $('#compare-count').text(0);
                    $.modal.close();
                }
            },
            dataType: 'json'
        });
    });
}

function initShippingInfo(deliveryTime) {
    var shippingInfo = deliveryTime.find('.shipping-info');

    shippingInfo.hover(function () {
        if (shippingInfo.hasClass('loaded')) {
            shippingInfo.find('.popup-wrapper').addClass('show');
        } else {
            $.ajax({
                type: "POST",
                url: shippingInfo.data('url'),
                beforeSend: function (result) {
                    shippingInfo.addClass('loaded');
                    shippingInfo.find('.popup-wrapper').addClass('show');
                },
                success: function (result) {
                    shippingInfo.find('.popup').html(result.content);
                    shippingInfo.find('.close').click(function () {
                        shippingInfo.find('.popup-wrapper').removeClass('open');
                        shippingInfo.find('.popup-wrapper').removeClass('show');
                    });
                },
                dataType: 'json'
            });
        }
    }, function () {
        shippingInfo.find('.popup-wrapper').removeClass('show');
    });

    shippingInfo.find('.title').click(function () {
        if (shippingInfo.hasClass('loaded')) {
            shippingInfo.find('.popup-wrapper').toggleClass('open');
        } else {
            $.ajax({
                type: "POST",
                url: shippingInfo.data('url'),
                beforeSend: function (result) {
                    shippingInfo.addClass('loaded');
                    shippingInfo.find('.popup-wrapper').addClass('open');
                },
                success: function (result) {
                    shippingInfo.find('.popup').html(result.content);
                    shippingInfo.find('.close').click(function () {
                        shippingInfo.find('.popup-wrapper').removeClass('open');
                    });
                },
                dataType: 'json'
            });
        }
    });
}


function updateDeliveryTime(deliveryTime, qtyField, mennyiseg) {

    if(qtyField.val() == mennyiseg){
        qtyField.closest('.while-stocks-last').find('.popup-wrapper').addClass('show');
    }

    qtyField.val(mennyiseg);
    UITimeout(function () {
        abortAjaxCalls();
        const microtime = getMicrotime();

        const xhr = $.ajax({
            type: "POST",
            url: deliveryTime.data('url'),
            data: {
                microtime: microtime,
                mennyiseg: mennyiseg
            },
            success: function (result) {
                if (result.microtime == microtime) {
                    deliveryTime.html(result.delivery_time);
                    initShippingInfo(deliveryTime);
                }
            },
            dataType: 'json'
        })

        ajaxCalls.push(xhr);
    });
}

function abortAjaxCalls(){
    ajaxCalls.forEach(ajax => {
        ajax.abort();

        const id = ajaxCalls.indexOf(ajax);
        ajaxCalls.splice(id,  1);
    });
}

function cartQtyToggle(qty){
    if(qty > 0){
        $('#cart-qty').removeClass('hidden').addClass('block');
    }else{
        $('#cart-qty').addClass('hidden').removeClass('block');
    }
}

//======================================================================================================================
// jQuery kiterjesztések
//======================================================================================================================

(function ($) {
    //Termék események
    $.fn.product = function () {
        $(this).each(function () {
            $(this).find('.prod-item').each(function () {
                var prodItem = $(this);

                var qtyField = prodItem.find('.qty');
                var button = prodItem.find('.cart-button');
                var deleteButton = prodItem.find('.delete-button');
                var cartDeleteButton = prodItem.find('.cart-delete-button');
                var deliveryTime = prodItem.find('.delivery-time-block');
                var comparisonButton = prodItem.find('.comparison-set');
                var cartItemPrice = prodItem.find('.cart-item-price');

                button.click(function () {
                    button.text(button.data('alt-label'));
                    button.attr('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: button.data('url'),
                        data: {
                            qty: qtyField.val()
                        },
                        success: function (result) {
                            if (result.error == false) {
                                qtyField.addClass('in_cart');
                                qtyField.val(result.qty);
                                deleteButton.removeClass('hidden');

                                cartQtyToggle(result.cart_qty);

                                $('#cart-qty').text(result.cart_qty);
                                $('.sum-price-text').html(result.sum_price_text);
                                $('.shipping-price-text').html(result.shipping_price_text);
                                cartItemPrice.html(result.item_price_text);

                                deliveryTime.html(result.delivery_time);
                                initShippingInfo(deliveryTime);

                                button.text(button.data('alt2-label'));
                                setTimeout(function () {
                                    button.html(button.data('save-label'));
                                }, 1000);
                            }

                            button.removeClass('saving');
                            button.attr('disabled', false);
                        },
                        dataType: 'json'
                    });
                });

                initShippingInfo(deliveryTime);

                prodItem.find('.qty-inc').click(function () {
                    var qty = parseInt(qtyField.val()) + 1;
                    var max = qtyField.data('max');

                    if (isNaN(qty)) {
                        qty = 1;
                    }

                    if (max !== undefined && qty > max) {
                        qty = max;
                    }
                    updateDeliveryTime(deliveryTime, qtyField, qty);
                });

                prodItem.find('.qty-dec').click(function () {
                    var qty = parseInt(qtyField.val()) - 1;
                    if (isNaN(qty)) {
                        qty = 1;
                    }
                    if (qty < 1) {
                        qty = 1;
                    }
                    updateDeliveryTime(deliveryTime, qtyField, qty);
                });

                qtyField.keyup(function () {
                    var qty = parseInt(qtyField.val());
                    var max = qtyField.data('max');

                    if (isNaN(qty)) {
                        qty = 1;
                    }
                    if (qty < 1) {
                        qty = 1;
                    }
                    if (max !== undefined && qty > max) {
                        qty = max;
                    }
                    updateDeliveryTime(deliveryTime, qtyField, qty);
                });


                prodItem.find('.imagestack img').click(function () {
                    prodItem.find('.prod-image .main-image').hide();
                    $('#termek-kep-' + $(this).data('target')).show();
                });

                /**
                 * Termék törlése a kosárból
                 */
                cartDeleteButton.click(function () {
                    cartDeleteButton.attr('disabled', true);
                    cartDeleteButton.addClass('loading');

                    $.ajax({
                        type: "POST",
                        url: cartDeleteButton.data('url'),
                        success: function (result) {
                            if (result.error == false) {
                                cartQtyToggle(result.cart_qty);
                                $('#cart-qty').text(result.cart_qty);
                                $('.sum-price-text').html(result.sum_price_text);
                                prodItem.slideUp();
                                if (!result.count) {
                                    location.reload();
                                }
                            }
                        },
                        dataType: 'json'
                    });
                });

                deleteButton.click(function () {
                    deleteButton.attr('disabled', true);
                    deleteButton.addClass('loading');
                    $.ajax({
                        type: "POST",
                        url: deleteButton.data('url'),
                        success: function (result) {
                            if (result.error == false) {
                                cartQtyToggle(result.cart_qty);
                                $('#cart-qty').text(result.cart_qty);
                                button.html(button.data('label'));
                                deleteButton.attr('disabled', false);
                                deleteButton.removeClass('loading');
                                deleteButton.addClass('hidden');
                                qtyField.removeClass('in_cart');
                                qtyField.val(1);
                                button.removeClass('inverse');
                            }
                        },
                        dataType: 'json'
                    });
                });

                /**
                 * Termék összehasonlítás
                 */
                comparisonButton.click(function () {

                    var button = $(this);
                    button.attr('disabled', true);
                    button.addClass('loading');

                    var microtime = getMicrotime();
                    var value = !button.hasClass('compared');
                    button.data('microtime', microtime);

                    $.ajax({
                        type: "POST",
                        url: $(this).data('url'),
                        data: {
                            microtime: microtime,
                            value: value
                        },
                        success: function (result) {
                            if (result.error == false) {

                                if ($('#comparison-page').length > 0) {
                                    window.location.reload();
                                }

                                if (result.value) {
                                    button.addClass('text-green-500 border-green-500 compared').removeClass('text-riel-light border-sky-500');
                                    $('.compare-all-btn').addClass('open');
                                    setTimeout(function(){  $('.compare-all-btn').removeClass('open'); }, 1500);
                                } else {
                                    button.removeClass('text-green-500 border-green-500 compared').addClass('text-riel-light border-sky-500');
                                }
                                button.removeClass('loading');

                                $('#compare-modal .compare-content').html(result.box_content);
                                $('#compare-count').text(result.count);
                               // $('.sum-price-text').html(result.sum_price_text);
                                comparisonBoxContentInit();

                                var compareBox = $('.compare-all-btn');
                                if (result.count > 0) {
                                    compareBox.removeClass('hidden').addClass('fixed');
                                } else {
                                    compareBox.addClass('hidden');
                                }

                                button.attr('disabled', false);
                            }
                        },
                        dataType: 'json'
                    });

                    return false;
                });
            });
        });
    };
}(jQuery));

$(window).ready(function () {
    comparisonBoxInit();

    $('.filter-toggle').click(function () {
        var id = $(this).data('target');
        $(this).toggleClass('toggled');
        $('#' + id).toggleClass('visible');
    });

    if ($('#cart').length) {
        $('#cart').product();
    }

    if ($('#product').length) {
        $('#product').product();
    }

    $('.prods.small').product();

    $('.compare-all-btn').click(function(){
        $('#compare-modal').modal({
            fadeDuration: 100,
        });
    });

    $(document).on({
        mouseenter: function () {
            $(this).find('.popup-wrapper').addClass('show');
        },
        mouseleave: function () {
            $(this).find('.popup-wrapper').removeClass('show');
        }
    }, '.tag .sale');

    $(document).on({
        mouseleave: function () {
            $(this).find('.popup-wrapper').removeClass('show');
        }
    }, '.while-stocks-last');




});
