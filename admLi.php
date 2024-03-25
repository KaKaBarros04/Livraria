<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empower Books Adm</title>
    <link rel="stylesheet" href="./css/styleadm.css">
    <link rel="icon" href="./imagem/book-solid.svg">
</head>
<body>
    <header>
        <h1>EMPOWER BOOKS ADMINISTRAÇÃO</h1>        
    </header>

    <nav>
        <a href="#">Início</a>
        <a href="#">Sobre</a>
        <a href="#">Produtos</a>
        <a href="#">Contato</a>
        
        <div class="user-dropdown">
            <img class="user-img" src="./imagem/user.jpg" alt="">
            <div class="dropdown-content">
                <a href="#">Ver conta</a>
                <a href="trocarsenha.php">Trocar senha</a>
                <a href="Index.php">Sair</a>
            </div>
        </div>
        
        <!-- Formulário de pesquisa à direita usando flexbox -->
        <form action="/pesquisar" method="GET">
            <input type="text" name="q" placeholder="Digite sua pesquisa...">
            <button type="submit">Pesquisar</button>
        </form>
    </nav>
    
    <main>
        <button id="menu-toggle" class="menu-toggle">&#9776;</button>
        
        <div class="navmenu">
            <?php
            // Conexão com o banco de dados 
            include('conexão.php');

            // Verifique se a conexão falhou
            if (!$dbc) {
                die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
            }

            $select_categoria = mysqli_query($dbc, "SELECT * FROM categorias ORDER BY idcategoria DESC");

            if (mysqli_num_rows($select_categoria) >= 1) :
            ?>
                <ul class="menu">
                    <?php while ($res = mysqli_fetch_assoc($select_categoria)) : ?>
                        <li class="menu-item">
                            <a href="<?= $res['slug'] ?>"><?= $res['NomeCategoria'] ?></a>

                            <?php
                            // Se existirem subcategorias, exiba-as
                            $subcat = mysqli_query($dbc, "SELECT * FROM subcategoria WHERE id_cat = " . $res['idcategoria'] . " ORDER BY Nome DESC");

                            if (mysqli_num_rows($subcat) >= 1) :
                            ?>
                                <ul class="submenu">
                                    <?php while ($linha = mysqli_fetch_assoc($subcat)) : ?>
                                        <li class="submenu-item">
                                            <a href="<?= $linha['slug'] ?>"><?= $linha['Nome'] ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        &copy; 2023 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script>
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

</script>
</body>

