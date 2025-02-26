<?php
    include('conexão.php');
    session_start();
    ?>

<!-- contato.php -->
<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>contatos - Empower Books</title>
        <link rel="stylesheet" href="./css/tres.css">
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
