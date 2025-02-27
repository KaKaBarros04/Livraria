   // Captura o clique do botão "Adicionar ao Carrinho"
   document.querySelectorAll('.btn-adicionar').forEach(button => {
    button.addEventListener('click', function() {
        // Coleta os dados do botão
        const book_id = this.getAttribute('data-book-id');
        const quantityInput = this.previousElementSibling; // O input de quantidade deve estar antes do botão
        const quantity = quantityInput ? quantityInput.value : 1;
        
        // Enviar os dados via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Mensagem de sucesso ou atualização do carrinho
                
                // Opcional: Você pode atualizar o ícone do carrinho ou alguma outra parte da página aqui
            }
        };
        // Envia os dados ao servidor
        xhr.send('add_to_cart=true&book_id=' + book_id + '&quantity=' + quantity);
    });
});
