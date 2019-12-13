$(function(){
    const $calculateButton = $('#calculate-button');
    const $buyCoins = $('#buy_coins');
    const $fields = $calculateButton.closest('form').find('input, select');
    const $coins_amount = $('#coins-amount');
    const $coins_message = $('#coins-message');

    $calculateButton.attr('disabled', false);
    $buyCoins.attr('disabled', true);

    $($calculateButton).click(function(e){
        e.preventDefault();

        let $form = $($calculateButton).closest('form');
        $($form).find('.form-error').hide();

        $buyCoins.attr('disabled', true);
        $calculateButton.attr({'disabled' : true});

        $coins_amount.html('<span class="loader"></span>');

        $.ajax({
            type: 'POST',
            url: $calculateButton.attr('data-endpoint'),
            data: $form.serialize(),
            success: function(response){
                $coins_amount.html(response.coins);
                $coins_message.html(Translator.transChoice('coins', response.coins, {}, 'messages'));

                $buyCoins.attr('disabled', false);
            },
            error: function(response)
            {
                let $errors = response.responseJSON.errors;

                for (let $key in $errors) {
                    $($form).find('[id="currency_to_coins_'+$key+'"]').after('' +
                        '<span class="form-error"><ul><li>'+$errors[$key]+'</li></ul></span>' +
                        '');
                }

                $coins_amount.html('- ');
                $coins_message.html(Translator.transChoice('coins', 0, {}, 'messages'));
            },
            complete: function(response)
            {
                $calculateButton.attr({'disabled' : false});
                $fields.css({'opacity' : 1});
                $fields.attr({'disabled' : false});
            }
        });

        $fields.css({'opacity' : 0.5});
        $fields.attr({'disabled' : true});
    });
});
