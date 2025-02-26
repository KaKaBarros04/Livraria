<?php
    include('conexão.php');
    session_start();
    ?>

 <!-- sobre.php -->
 <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Sobre Nós - Empower Books</title>
        <link rel="stylesheet" href="./css/tres.css">
    </head>
    <body>
        <header>
            <h1>Sobre Nós</h1>
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
            <section>
                <h2>Nossa História</h2>
                <p>

                Bem-vindo à Empower Books! Somos apaixonados por conectar pessoas ao conhecimento e tornar a leitura acessível a todos. Nossa missão é oferecer um espaço onde leitores de todas as idades possam descobrir, explorar e compartilhar o amor pelos livros.

                Nossa História
                Fundado em 2025, a Empower books nasceu da vontade de criar um ambiente onde os amantes da leitura pudessem encontrar recomendações, avaliações e novidades do mundo literário. Desde então, crescemos e nos tornamos um dos principais pontos de encontro para quem busca inspiração e novas histórias para ler.
                </p>
                <p>
                O Que Oferecemos<br>
                📚 Recomendações de livros de diversos gêneros<br>
                📝 Resenhas e avaliações para ajudar na sua escolha<br>
                📖 Artigos e novidades do universo literário<br>
                🤝 Uma comunidade de leitores apaixonados<br>

                Nosso objetivo é proporcionar uma experiência única para cada visitante, tornando mais fácil a busca pelo próximo livro favorito.<br>

                Junte-se a Nós!<br>
                Queremos construir uma comunidade forte e engajada! Siga-nos nas redes sociais e participe das nossas discussões sobre literatura.<br>

                📩 Tem alguma dúvida ou sugestão? Entre em contato conosco pelo nosso formulário!

            </p>
            </section>
        </main>
        <footer>
            &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
        </footer>
    </body>
    </html>
