<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redireciona para o login
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar ao banco de dados
include('conexão.php');

// Definir a variável de pesquisa, se fornecida
$search_query = isset($_GET['query']) ? $_GET['query'] : '';

// Variáveis para armazenar os filtros de categoria e subcategoria
$category_filter = isset($_GET['category']) ? $_GET['category'] : null;
$sub_category_filter = isset($_GET['sub_category']) ? $_GET['sub_category'] : null;

// Inicializar a consulta SQL
$query = "SELECT * FROM books WHERE title LIKE ?";

// Adicionar o filtro de categoria, se presente
if ($category_filter) {
    $query .= " AND category_id = ?";
}

// Adicionar o filtro de subcategoria, se presente
if ($sub_category_filter) {
    $query .= " AND sub_category_id = ?";
}

// Preparar a consulta
$stmt = $dbc->prepare($query);

// Definir os parâmetros da consulta
$params = [];
$params[] = "%$search_query%"; // Filtro de pesquisa no título

if ($category_filter) {
    $params[] = $category_filter; // Filtro de categoria
}

if ($sub_category_filter) {
    $params[] = $sub_category_filter; // Filtro de subcategoria
}

// Determinar o tipo dos parâmetros e vincular
$type_str = str_repeat('i', count($params) - 1) . 's'; // Tipo 's' para string (pesquisa) e 'i' para inteiros (categoria e subcategoria)
$stmt->bind_param($type_str, ...$params);

// Executar a consulta
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empower Books</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" href="./imagens/book-solid.svg">
</head>
<body>
    <header>
        <h1>EMPOWER BOOKS</h1>        
    </header>

    <nav>
        <a href="#"><button id="menu-toggle" class="menu-toggle">&#9776;</button></a>
        <a href="Home.php">Início</a>
        <a href="#">Sobre</a>
        <a href="#">Produtos</a>
        <a href="#">Contato</a>
        
        <div class="user-dropdown">
            <img class="user-img" src="./imagens/user.jpg" alt="">
            <div class="dropdown-content">
                <a href="#">Ver conta</a>
                <a href="redefinir.php">Redefinir senha</a>
                <a href="Index.php">Sair</a>
            </div>
        </div>

        <!-- Formulário de pesquisa -->
        <form action="detalhes.php" method="GET">
            <input type="text" name="query" placeholder="Digite sua pesquisa..."  value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <button type="submit">Pesquisar</button>
        </form>
    </nav>
    
    <main>
        <!-- Exibição dos Resultados da Pesquisa -->
        <?php
        if ($result->num_rows > 0) {
            echo "<div class='livros-container'>";
            while ($book = $result->fetch_assoc()) {
                echo "<div class='livro-card'>
                        <img src='" . htmlspecialchars($book['image']) . "' alt='" . htmlspecialchars($book['title']) . "'>
                        <h2>" . htmlspecialchars($book['title']) . "</h2>
                        <p><strong>Autor:</strong> " . htmlspecialchars($book['author']) . "</p>
                        <p><strong>Preço:</strong> € " . number_format($book['price'], 2, ',', '.') . "</p>
                        <a href='detalhes.php?id=" . $book['book_id'] . "' class='btn-detalhes'>Ver mais</a>
                    </div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nenhum livro encontrado.</p>";
        }
        ?>

        <!-- Filtros de categoria -->
        <div class="navmenu">
            <ul class="menu">
                <?php
                $select_categoria = mysqli_query($dbc, "SELECT * FROM categorias ORDER BY idcategoria DESC");

                if (mysqli_num_rows($select_categoria) >= 1) :
                    while ($res = mysqli_fetch_assoc($select_categoria)) :
                ?>
                    <li class="menu-item">
                        <a href="#" class="category-link" data-category="<?= $res['idcategoria'] ?>">
                            <?= htmlspecialchars($res['NomeCategoria']) ?>
                        </a>

                        <?php
                        $subcat = mysqli_query($dbc, "SELECT * FROM subcategoria WHERE idcategoria = " . $res['idcategoria'] . " ORDER BY Nome DESC");

                        if (mysqli_num_rows($subcat) >= 1) :
                        ?>
                        <ul class="submenu">
                            <?php while ($linha = mysqli_fetch_assoc($subcat)) : ?>
                            <li class="submenu-item">
                                <a href="?category=<?= $res['idcategoria'] ?>&sub_category=<?= $linha['sub_category_id'] ?>" class="subcategory-link" data-subcategory="<?= $linha['sub_category_id'] ?>">
                                    <?= htmlspecialchars($linha['Nome']) ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                <?php endwhile; endif; ?>
            </ul>
        </div>
    </main>

    <footer>
        &copy; 2023 EMPOWER BOOKS | Todos os direitos reservados
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./js/principal.js"></script>
</body>
</html>
