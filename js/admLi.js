$(document).ready(function () {
    $("#menu-toggle").click(function () {
        var x = document.getElementById("links");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
        $(this).toggleClass("active"); // movido para dentro da função de clique
    });

    // Remova o código duplicado para o evento hover
    $('.menu-item').hover(
        function () {
            $(this).children('.submenu').slideDown(200);
        },
        function () {
            $(this).children('.submenu').slideUp(200);
        }
    );
});
