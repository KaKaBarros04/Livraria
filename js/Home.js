    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.querySelector('input[name="q"]').value;
        // Faça algo com a pesquisa, como redirecionar para uma página de resultados
        window.location.href = '/resultados?query=' + encodeURIComponent(query);
    });

    // Adicione o evento de clique para abrir/fechar o menu suspenso
const userIcon = document.querySelector('.user-icon');

userIcon.addEventListener('click', () => {
    const userDropdown = userIcon.querySelector('.user-dropdown');
    userDropdown.classList.toggle('show');
});

