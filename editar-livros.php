<?php
// edit_book.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('conexão.php');

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        
        $query = "UPDATE books SET title=?, author=?, description=?, price=?, stock=? WHERE book_id=?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("sssdii", $title, $author, $description, $price, $stock, $book_id);
        $stmt->execute();
        
        header("Location: AdmLi.php");
        exit(); // Certifique-se de que o script para aqui
    }
} else {
    header("Location: AdmLi.php");
    exit();
}
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
    <title>Editar Livros</title>
    <link rel="stylesheet" href="./css/styleadm.css">
    <link rel="icon" href="./imagens/book-solid.svg">
</head>
<body>
    <header>
        <h1>Editar Livros</h1>        
    </header>

    <nav>
 
    </nav>

    <form method="POST" class="form">
        <label for="title" class="label-input">Título:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

        <label for="author" class="label-input" >Autor:</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

        <label for="description" class="label-input">Descrição:</label>
        <textarea name="description" required><?= htmlspecialchars($book['description']) ?></textarea>

        <label for="price" class="label-input">Preço:</label>
        <input type="number" name="price" value="<?= $book['price'] ?>" required>

        <label for="stock" class="label-input">Estoque:</label>
        <input type="number" name="stock" value="<?= $book['stock'] ?>" required>

        <button class="btn btn-second" type="submit">Salvar</button>
    </form>
    <footer>
        &copy; 2023 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
