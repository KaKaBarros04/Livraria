$(document).ready(function () {
    // Oculta o menu ao carregar a página
    $(".navmenu").hide();

    $("#menu-toggle").click(function () {
        $(".navmenu").slideToggle(200); // Seleciona a classe .navmenu para alternar a visibilidade
        $(this).toggleClass("active"); // Adiciona a classe 'active' ao botão de alternância de menu
    });

    // Remova o código duplicado para o evento hover, se necessário
    $('.menu-item').hover(
        function () {
            $(this).children('.submenu').slideDown(200);
        },
        function () {
            $(this).children('.submenu').slideUp(200);
        }
    );
});