<!-- produtos.php -->
<?php
include('conexão.php');
session_start();

// Definição da query base
$query = "SELECT * FROM books";

// Aplicação de filtros
$orderBy = "";
if (isset($_GET['filtro'])) {
    switch ($_GET['filtro']) {
        case 'preco':
            $orderBy = "ORDER BY price ASC";
            break;
        case 'alfabetico':
            $orderBy = "ORDER BY title ASC";
            break;
        case 'popularidade':
            $orderBy = "ORDER BY views DESC"; // Supondo que haja uma coluna 'views' no banco
            break;
    }
}

// Executa a consulta com filtros
$query .= " $orderBy";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos - Empower Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/tres.css">
</head>
<body>
    <header>
        <h1>Produtos</h1>
    </header>

    <nav>
        <a href="#"><button id="menu-toggle" class="menu-toggle">&#9776;</button></a>
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

      <a href="cart.php">🛒</a>


        <!-- Formulário de pesquisa -->
        <form action="Index.php" method="GET">
            <input type="text" name="query" placeholder="Digite sua pesquisa..."  value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <button type="submit">Pesquisar</button>
        </form>
    </nav>

    <main class="container-lg mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <h2 class="text-warning">Nossos Livros</h2>
            </div>
            <div class="col-md-6 text-end">
                <form method="GET" class="d-inline">
                    <label for="filtro" class="me-2">Ordenar por:</label>
                    <select name="filtro" id="filtro" class="form-select d-inline w-auto" onchange="this.form.submit()">
                        <option value="">Selecione</option>
                        <option value="preco" <?= (isset($_GET['filtro']) && $_GET['filtro'] == 'preco') ? 'selected' : '' ?>>Preço</option>
                        <option value="alfabetico" <?= (isset($_GET['filtro']) && $_GET['filtro'] == 'alfabetico') ? 'selected' : '' ?>>Ordem Alfabética</option>
                        <option value="popularidade" <?= (isset($_GET['filtro']) && $_GET['filtro'] == 'popularidade') ? 'selected' : '' ?>>Mais Popular</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <?php while ($book = mysqli_fetch_assoc($result)) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow">
                        <img src='<?= htmlspecialchars($book['image']) ?>' class="card-img-top" alt='<?= htmlspecialchars($book['title']) ?>'>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text"><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
                            <p class="card-text"><strong>Preço:</strong> € <?= number_format($book['price'], 2, ',', '.') ?></p>
                            <a href='detalhes.php?id=<?= $book['book_id'] ?>' class='btn btn-primary'>Ver mais</a>
                            <?php
                            echo "<br>
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
    "  ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/produtos.js"></script>
</body>
</html>
