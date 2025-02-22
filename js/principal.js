document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form');
    const searchInput = document.querySelector('input[name="query"]');

    // Formulário de pesquisa
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const query = searchInput.value.trim(); // Remove espaços extras

            if (query) {
                window.location.href = 'Home.php?query=' + encodeURIComponent(query);
            }
        });
    }

    // Evento para abrir/fechar o menu suspenso
    const userIcon = document.querySelector('.user-dropdown');
    if (userIcon) {
        const userDropdown = userIcon.querySelector('.dropdown-content');
        userIcon.addEventListener('click', () => {
            userDropdown.classList.toggle('show');
        });
    }
});

// Código jQuery para o menu hambúrguer
$(document).ready(function () {
    // Inicialmente, esconder o menu de navegação
    $(".navmenu").hide();

    // Alternar visibilidade do menu ao clicar no botão de menu (hambúrguer)
    $("#menu-toggle").click(function () {
        $(".navmenu").slideToggle(200); // Anima o menu
        $(this).toggleClass("active");  // Alterna a classe ativa (para possíveis efeitos)
    });

    // Corrigir hover para o submenu
    $('.menu-item').hover(
        function () {
            $(this).children('.submenu').stop(true, true).slideDown(200); // Mostra o submenu
        },
        function () {
            $(this).children('.submenu').stop(true, true).slideUp(200); // Oculta o submenu
        }
    );

    // Evento de clique para categorias
    $(".category-link").click(function (e) {
        e.preventDefault(); // Impede o recarregamento da página
        let categoryId = $(this).data("category");
        window.location.href = "Home.php?category=" + categoryId; // Filtra pela categoria
    });

    // Evento de clique para subcategorias
    $(".subcategory-link").click(function (e) {
        e.preventDefault(); // Impede o recarregamento da página
        let subcategoryId = $(this).data("subcategory");
        window.location.href = "Home.php?sub_category=" + subcategoryId; // Filtra pela subcategoria
    });
});
