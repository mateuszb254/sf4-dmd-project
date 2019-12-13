$(function () {
    $('#promotion_with_coupon_collection_expires_confirmation').on('click', function () {
        $('#expires_wrapper').slideToggle();
    });

    $('#promotion_coupon_generator_newPromotion_expires_confirmation').on('click', function () {
        $('#expires_wrapper').slideToggle();
    });

    let promotionRow = $('#promotion_coupon_generator_promotion').closest('.form-group');
    let newPromotionWrapper = $('#promotion_wrapper');

    $('#promotion_new_button').on('click', function (e) {
        e.preventDefault();
        $(promotionRow).slideUp(400, function () {

            let select = $('#promotion_coupon_generator_promotion');

            $(select).find("option:selected").prop("selected", false);
            $(select).find("option:first").prop("selected", "selected");

            $(newPromotionWrapper).slideDown(400, function () {
                $('#promotion_new_button').hide();
                $('#promotion_existing_button').show();
            });
        });
    });

    $('#promotion_existing_button').on('click', function (e) {
        e.preventDefault();
        $(newPromotionWrapper).slideUp(400, function () {
            $(promotionRow).slideDown(400, function () {
                $('#promotion_existing_button').hide();
                $('#promotion_new_button').show();
            });
        });
    })
});
