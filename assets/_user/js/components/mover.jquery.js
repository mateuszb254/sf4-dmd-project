$(function(){
    $('#top-mover').click(function(){
        let body = document.body;
        let html = document.documentElement;

        let height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);

        $('html, body').animate({ scrollTop: 0 }, height * 0.5);
    });
});
