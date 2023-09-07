<?php
// Conexão com o banco de dados (você pode reutilizar seu arquivo de conexão existente)
include('conexão.php');

// Verifique se a chave de validação foi enviada via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chave_validacao'])) {
    $chaveValidacao = $_POST['chave_validacao'];
    
    // Consulte o banco de dados para verificar se a chave de validação existe
    $query = "SELECT * FROM users WHERE chave_validacao = '$chaveValidacao'";
    $result = mysqli_query($dbc, $query);
    
    if (mysqli_num_rows($result) === 1) {
        // A chave de validação é válida, inclua o formulário de redefinição de senha
        header('Location: redefinir.php');
        exit();
        
        
    } else {
        // A chave de validação não é válida, exiba uma mensagem de erro ou redirecione para uma página de erro
        echo '<script>alert("Chave de validação inválida.");</script>';
    }
} else {
    // A chave de validação não foi enviada via POST, exiba o formulário para inserir a chave
}
?>


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
        <title>Esqueceu a senha</title>
        <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/fogot-senha.css">
        <link rel="icon" href="./imagem/book-solid.svg">
</head>
<body>
<div class="container">
        <div class="formulario">
            <h1>Sua chave de validação</h1>
            <form action="redefinir.php" class="form" method="post">
                <label class="label-input">
                    <i class="fa-solid fa-key"></i>
                    <input type="text" class="chave" name="chave_validacao" maxlength="50" placeholder="Chave de Validação" required/>
                </label>
                <button type="submit" class="button" name="submit" value="Verificar Chave">Verificar Chave</button>
            </form>
        </div>
    </div>
</body>
</html>
