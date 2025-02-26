<?php
// archived_books.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('conexão.php');

// Seleção dos livros arquivados
$books = $dbc->query("SELECT * FROM books WHERE archived_at IS NOT NULL");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros Arquivados</title>
    <link rel="stylesheet" href="./css/styleadm.css">
    <link rel="icon" href="./imagens/book-solid.svg">
</head>
<body>
    <header>
        <h1>Livros Arquivados</h1>        
    </header>

    <nav>
 
    </nav>

    <?php if ($books->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Preço</th>
                    <th>Data de Arquivamento</th>
                    <th>Ações</th> <!-- Nova coluna para as ações -->
                </tr>
            </thead>
            <tbody>
                <?php while ($book = $books->fetch_assoc()) : ?>
                <tr>
                    <td><?= $book['book_id'] ?></td>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td>€ <?= number_format($book['price'], 2, ',', '.') ?></td>
                    <td><?= $book['archived_at'] ?></td>
                    <td>
                        <!-- Adicionar um link para restaurar o livro -->
                        <a href="restaurar-livros.php?id=<?= $book['book_id'] ?>" onclick="return confirm('Tem certeza que deseja restaurar este livro?')">Restaurar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum livro arquivado encontrado.</p>
    <?php endif; ?>
    <footer>
        &copy; 2023 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
