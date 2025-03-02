<?php
    include('conexão.php');
    session_start();
    ?>

<!-- contato.php -->
<!DOCTYPE html>
    <html lang="pt-br">
    <head>
           <!-- Adicionando o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJfQ2z8MXt6jPqGYO5yf3M1+Tl8Xq0bMjjcFrWEmya1P+vWo6dLrDQw9c0Q5" crossorigin="anonymous">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>contatos - Empower Books</title>
        <link rel="stylesheet" href="./css/contato.css">
        <link rel="icon" href="./imagens/phone-svgrepo-com.svg">
    </head>
    <body>
        <header>
            <h1>Contato</h1>
        </header>

        <nav>
        <a href="Index.php">Início</a>
        <a href="sobrenos.php">Sobre</a>
        <a href="produtos.php">Produtos</a>
        <a href="contatos.php">Contatos</a>

        <div class="user-dropdown">
    <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['name'])): ?>
        <img class="user-img" src="./imagens/user.jpg" alt="Usuário">
        <span>Olá, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</span>
        <div class="dropdown-content">
            <a href="minhaconta.php">Minha conta</a>
            <a href="redefinir.php">Redefinir senha</a>
            <a href="logout.php">Sair</a>
        </div>
    <?php else: ?>
        <a href="PagLogin.php" class="login-btn">Login</a>
    <?php endif; ?>
</div>


    </nav>
    <main>
        <p>
            Contate-nos<br>
        Tem alguma dúvida, sugestão ou deseja falar conosco? Estamos aqui para ajudar! Entre em contato pelos canais abaixo e responderemos o mais rápido possível.<br>

        📧 E-mail<br>
        ✉️ suporte@seudominio.com<br>

        📞 Telefone<br>
        📱 (XX) XXXX-XXXX<br>

        📍 Endereço<br>
        🏢 Rua Exemplo, 123 - Bairro - Cidade, Estado, CEP<br>

        📲 Redes Sociais<br>
        🔹 Facebook | 🔹 Instagram | 🔹 Twitter<br>

        📩 Envie uma Mensagem<br>
        Preencha o formulário abaixo e entraremos em contato o mais breve possível:
        </p>
        </main>
        <main>
            <form class="cont" action="enviar_contato.php" method="POST">
                <label>Nome:</label>
                <input type="text" name="nome" required>
                
                <label>Email:</label>
                <input type="email" name="email" required>
                
                <label>Mensagem:</label>
                <textarea name="mensagem" required></textarea>
                
                <button class="btncont" type="submit">Enviar</button>
            </form>
        </main>
        <footer>
            &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
        </footer>
    </body>
    </html>
