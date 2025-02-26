<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (isset($_SESSION['user'])) {
    // Destroi a sessão para fazer logout
    session_unset();   // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão

    // Redireciona para a página de login ou a página inicial
    header("Location: PagLogin.php"); // Redireciona para a página de login
    exit();
} else {
    // Se não estiver logado, redireciona diretamente para o login
    header("Location: Index.php");
    exit();
}
?>
