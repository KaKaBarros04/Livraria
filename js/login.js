    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.querySelector('input[name="q"]').value;
        // Faça algo com a pesquisa, como redirecionar para uma página de resultados
        window.location.href = '/resultados?query=' + encodeURIComponent(query);
    });

  
