<?php
// restore_book.php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('conexão.php');

// Verifica se o parâmetro 'id' foi enviado
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Atualiza o livro no banco de dados para restaurá-lo (removendo a data de arquivamento)
    $query = "UPDATE books SET archived_at = NULL WHERE book_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    // Redireciona de volta para a página de livros arquivados
    header("Location: livros-arquivados.php");
    exit();
} else {
    // Se não encontrar o ID, redireciona para a página de livros arquivados
    header("Location: livros-arquivados.php");
    exit();
}
?>
