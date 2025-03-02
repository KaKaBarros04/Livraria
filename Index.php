<?php
session_start(); // Garante que a sessão seja iniciada



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
// Construção da query
$query = "SELECT * FROM books WHERE 1=1";
$params = [];
$param_types = "";

// Adicionar o filtro de pesquisa no título, se fornecido
if (!empty($search_query)) {
    $query .= " AND title LIKE ?";
    $params[] = "%$search_query%";
    $param_types .= "s"; // String
}

// Adicionar o filtro de categoria, se presente
if (!empty($category_filter)) {
    $query .= " AND category_id = ?";
    $params[] = (int)$category_filter;
    $param_types .= "i"; // Inteiro
}

// Adicionar o filtro de subcategoria, se presente
if (!empty($sub_category_filter)) {
    $query .= " AND sub_category_id = ?";
    $params[] = (int)$sub_category_filter;
    $param_types .= "i"; // Inteiro
}

// Preparar a consulta
$stmt = $dbc->prepare($query);

// Verificar se há parâmetros antes de chamar bind_param
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

// Executar a consulta
$stmt->execute();
$result = $stmt->get_result();



?>

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
        <a href="Index.php">Início</a>
        <a href="sobrenos.php">Sobre</a>
        <a href="produtos.php">Produtos</a>
        <a href="contatos.php">Contatos</a>

        <div class="user-dropdown">
    <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['name'])): ?>
        <img class="user-img" src="<?= isset($_SESSION['user']['profile_image']) ? $_SESSION['user']['profile_image'] : './imagens/user.jpg' ?>" alt="Usuário">

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

      <a href="cart.php">🛒</a>

<!-- Formulário de Pesquisa -->
<div class="container my-4">
        <form action="Index.php" method="GET" class="row">
            <div class="col-md-8">
                <input type="text" name="query" class="form-control" placeholder="Digite sua pesquisa..." value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
            </div>
        </form>
    </div>
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
                    <form action='cart.php' method='POST'>
                        <input type='hidden' name='book_id' value='" . $book['book_id'] . "'>
                        <input type='number' name='quantity' value='1' min='1' class='quantity' required>
                        <button class='btn-adicionar' 
                            data-book-id='" . $book['book_id'] . "' 
                            data-book-title='" . htmlspecialchars($book['title']) . "' 
                            data-book-price='" . number_format($book['price'], 2, ',', '.') . "'>
                            Adicionar ao 🛒
                        </button>
                    </form>
                    <a href='checkout.php?book_id=" . $book['book_id'] . "&quantity=1' class='btn-comprar'>
        Compra rapida
    </a>
                </div>";
        }
        echo "</div>";
    } // Fechamento do if
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
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="./js/principal.js"></script>
</body>
</html>
