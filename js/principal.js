document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form');
    const searchInput = document.querySelector('input[name="query"]');

    // Formulário de pesquisa
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const query = searchInput.value.trim(); // Remove espaços extras

            if (query) {
                window.location.href = 'Index.php?query=' + encodeURIComponent(query);
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
    $("#menu-toggle").click(function () {
        $(".navmenu").toggleClass("active"); // Alterna a classe active
        $(this).toggleClass("active"); // Alterna a classe active no botão

        // Verifica se o menu está visível e ajusta a exibição
        if ($(".navmenu").hasClass("active")) {
            $(".navmenu").slideDown(200); // Mostra o menu
        } else {
            $(".navmenu").slideUp(200); // Esconde o menu
        }
    });
});

