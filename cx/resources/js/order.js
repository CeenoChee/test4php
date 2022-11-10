function refreshPayment() {
    const payment = $("input[name='payment']:checked").attr('id');
    const simplePayLogo = $('#simplepay-logo');


    if (payment === 'fizetesi_mod_bankkartya') {
        simplePayLogo.show();
    } else {
        simplePayLogo.hide();
    }

    if(payment === 'fizetesi_mod_elorefizetes'){
        $('#prepayment-text').show();
    }else{
        $('#prepayment-text').hide();
    }


}

$(document).ready(function () {
    $('.payment-item input:checked').closest('.payment-item').addClass('active');

    if ($('#payment-page').length > 0) {
        $('.payment-item').click(function () {
            let button = $(this);
            button.closest('#payment-page').find('.payment-item').removeClass('active');
            button.addClass('active');
            button.find('input').prop('checked', true);
            refreshPayment();
        });

        refreshPayment();
    }
});
