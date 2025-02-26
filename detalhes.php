<?php
// Conectar ao banco de dados
include('conexão.php');

// Verificar se um ID foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $book_id = $_GET['id'];
    
    // Consulta segura com prepared statements
    $stmt = $dbc->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "<p>Livro não encontrado.</p>";
        exit();
    }
} else {
    echo "<p>ID inválido.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?></title>
    <link rel="stylesheet" href="./css/detalheslivros.css">
</head>
<body>
    <header>
        <h1>Detalhes do Livro</h1>
    </header>
    <nav>
        <a href="Index.php">Início</a>
</nav>
    <main>
        <div class="livro-detalhes">
            <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($book['description'])) ?></p>
            <p><strong>Preço:</strong> R$ <?= number_format($book['price'], 2, ',', '.') ?></p>
            <a href="index.php">Voltar</a>
        </div>
    </main>
    
    <footer>
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
</body>
</html>

