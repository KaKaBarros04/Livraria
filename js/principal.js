    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.querySelector('input[name="q"]').value;
        // Faça algo com a pesquisa, como redirecionar para uma página de resultados
        window.location.href = '/resultados?query=' + encodeURIComponent(query);
    });

    // Adicione o evento de clique para abrir/fechar o menu suspenso
    document.addEventListener("DOMContentLoaded", function() {
        const userIcon = document.querySelector('.user-dropdown');
        const userDropdown = userIcon.querySelector('.dropdown-content');
    
        userIcon.addEventListener('click', () => {
            userDropdown.classList.toggle('show');
        });
    });
    
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