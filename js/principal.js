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
    
//Banner 

    let fotos = ["ilove.jpg", "saldo.jpg", "lv.jpg", "book.jpg", "sugestao.jpg", "mindset.png"];
    
    
    
    function TrocarFoto(foto){
        document.querySelector(".banner").src = "imagem/" + fotos[foto];
        
    }
    
    let fotoAtual = 0;
    TrocarFoto(fotoAtual);
    
    
    var timer = setInterval(function(){
        fotoAtual++;
        if(fotoAtual > 5){
            fotoAtual = 0;
        }
        
        TrocarFoto(fotoAtual);
    } , 4000);
    
    function Parar() {
        clearInterval(timer);
      }