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
        <title>SubCategorias</title>
        <link rel="stylesheet" href="./css/subcategoria.css">
        <link rel="icon" href="./imagens/book-solid.svg">
    </head>
    <body>
        <header>
            <h1>SubCategorias</h1>        
        </header>

        <nav>
            <a href="admLi.php">Início</a>
            <a href="#">Sobre</a>
            <a href="#">Produtos</a>
            <a href="#">Contato</a>
            
            <div class="user-dropdown">
                <img class="user-img" src="./imagens/user.jpg" alt="">
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
            <div class="navmenu">
                <?php
                // Conexão com o banco de dados 
                include('conexão.php');

                // Verifique se a conexão falhou
                if (!$dbc) {
                    die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
                }

                // Verifique se o parâmetro sub_category_id foi passado na URL
                if (isset($_GET['sub_category_id'])) {
                    // Use a função mysqli_real_escape_string para escapar o valor e evitar ataques de SQL Injection
                    $sub_category_id = mysqli_real_escape_string($dbc, $_GET['sub_category_id']);

                    // Faça a consulta SQL usando o valor escapado
                    $select_categoria = mysqli_query($dbc, "SELECT * FROM subcategoria WHERE idcategoria = '$sub_category_id'");

                    // Verifique se a consulta foi bem-sucedida
                    if ($select_categoria) {
                        // Verifique se há resultados na consulta
                        if (mysqli_num_rows($select_categoria) > 0) {
                            // Loop pelos resultados e exiba-os
                            while ($row = mysqli_fetch_assoc($select_categoria)) {
                                echo "<li>{$row['Nome']}</li>";
                            }
                        } else {
                            echo "Nenhuma subcategoria encontrada para o ID de categoria fornecido.";
                        }
                    } else {
                        echo "Erro ao executar a consulta SQL: " . mysqli_error($dbc);
                    }
                } else {
                    echo "O parâmetro ID da categoria não foi fornecido na URL.";
                }
                ?>
            </div>
        </main>


        <footer>
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </body>
</html>