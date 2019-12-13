$(function () {
    const COOKIE_NAME = 'demo-closed';

    const container = $('#demo');
    const closeButton = $('#demo-close-button');

    if (document.cookie.search(COOKIE_NAME) === -1) {
        showContainer(container);
    } else {
        showDemoMinimized();
    }

    $(closeButton).on('click', function (e) {
        closeContainer(container);
        document.cookie = COOKIE_NAME + '=true;' + 60 * 60 * 24 + ';path=/';
    });

    $(document).keyup(function (e) {
        if (e.keyCode === 27) $(closeButton).click();
    });

    $('#demo-minimized').on('click', function () {
        showContainer(container);
    });

    $(window).on('scroll', function () {
        setMinimizedPosition()
    });

    function showContainer(container) {
        $(container).css('display', 'flex');
        $(container).animate({'opacity': 1}, 1000);
    }

    function closeContainer(container) {
        $(container).animate({'opacity': 0}, 1000, function () {
            $(this).hide();
            showDemoMinimized();
        });
    }

    function showDemoMinimized() {
        $('#demo-minimized').fadeIn(500);
        setMinimizedPosition();
    }

    function setMinimizedPosition() {
        let minimized = $('#demo-minimized');
        let authors = $('#authors');

        let authorsOffset = authors.offset().top;
        let minimizedBottomOffset = minimized.offset().top + minimized.height() + parseInt(minimized.css('bottom'));

        if (authorsOffset <= minimizedBottomOffset) {
            minimized.css('bottom', minimizedBottomOffset - authorsOffset);

        } else {
            minimized.css('bottom', 0);
        }
    }
});
