$(function () {
    $('input[type="checkbox"].iCheck-deletable').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
        const elementsController = $(this).closest('.elements-controller');

        if (!elementsController) return;

        const target = elementsController.attr('data-target');
        const clicks = $(this).data('clicks');

        if (clicks) {
            //Uncheck all checkboxes
            $(target + " input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
            //Check all checkboxes
            $(target + " input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }

        $(this).data("clicks", !clicks);
    });

    $('#delete-button').on('click', function (e) {
        const elementsController = $(this).closest('.elements-controller');

        if (!elementsController) return;

        const target = elementsController.attr('data-target');
        const element = elementsController.attr('data-element');

        const selectedRows = $(target).find('input:checked').closest(element);

        selectedRows.fadeOut(500, function (e) {
            selectedRows.remove();
        });
    });
});
