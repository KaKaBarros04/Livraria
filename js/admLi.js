$(document).ready(function () {
    $("#menu-toggle").click(function () {
        $(".navmenu").slideToggle(200, function () {
            // Adiciona/remova a classe 'vertical-menu' para alternar entre os modos horizontal e vertical
            $(".menu").toggleClass("vertical-menu");

            // Se o menu estiver visível na versão vertical, adiciona a classe 'hidden' ao body para ocultar o overflow
            $("body").toggleClass("hidden", $(".navmenu").hasClass("vertical-menu") && $(".navmenu").is(":visible"));
        });
        
        $(this).toggleClass("active");
    });

    $('.menu-item').hover(
        function () {
            $(this).children('.submenu').slideDown(200);
        },
        function () {
            $(this).children('.submenu').slideUp(200);
        }
    );
});