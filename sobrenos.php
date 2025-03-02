<?php
    include('conexão.php');
    session_start();
    ?>

 <!-- sobre.php -->
 <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJfQ2z8MXt6jPqGYO5yf3M1+Tl8Xq0bMjjcFrWEmya1P+vWo6dLrDQw9c0Q5" crossorigin="anonymous">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Sobre Nós">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Empower Books</title>
    <link rel="stylesheet" href="./css/sobre.css">
    <link rel="icon" href="./imagens/person-wave-svgrepo-com.svg">
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
