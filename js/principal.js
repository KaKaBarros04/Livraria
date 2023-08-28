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
    
