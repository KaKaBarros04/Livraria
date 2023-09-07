<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão com o banco de dados (você pode reutilizar seu arquivo de conexão existente)
include('conexão.php');
$chaveValidacao = $_POST['chave_validacao'] ?? '';

// Verifique se a chave de validação foi enviada via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chave_validacao'])) {
    $chaveValidacao = $_POST['chave_validacao'];
    
    // Consulte o banco de dados para verificar se a chave de validação existe
    $query = "SELECT * FROM users WHERE chave_validacao = '$chaveValidacao'";
    $result = mysqli_query($dbc, $query);
    
    if (mysqli_num_rows($result) === 1) {
        // A chave de validação é válida, inclua o formulário de redefinição de senha
        header('Location: redefinir.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_senha'])) {
            // Obtenha a nova senha do formulário
            $novaSenha = $_POST['nova_senha'];
            $confirmarSenha = $_POST['confirmar_senha'];
            
            // Verifique se a nova senha é igual à senha confirmada
            if ($novaSenha === $confirmarSenha) {
                // Consulte o banco de dados para verificar se a chave de validação existe
                $query = "SELECT * FROM users WHERE chave_validacao = '$chaveValidacao'";
                $result = mysqli_query($dbc, $query);
                
                if (mysqli_num_rows($result) === 1) {
                    // A chave de validação é válida, continue com a redefinição da senha
                    // Obtenha o ID do usuário
                    $row = mysqli_fetch_assoc($result);
                    $userId = $row['id']; // Substitua 'id' pelo nome da coluna que armazena o ID do usuário
                    
                    // Atualize a senha no banco de dados
                    $updateQuery = "UPDATE users SET senha = '$novaSenha' WHERE id = $userId";
                    if (mysqli_query($dbc, $updateQuery)) {
                        // Redirecione o usuário para a página de login ou exiba uma mensagem de sucesso
                        echo '<script>alert("Senha redefinida com sucesso. Você pode fazer login com a nova senha.");</script>';
                        // Redirecione para a página de login ou qualquer outra página apropriada
                        header('Location: Index.php');
                        exit();
                    } else {
                        echo '<script>alert("Erro ao atualizar a senha. Tente novamente mais tarde.");</script>';
                    }
                } else {
                    echo "Valor de chaveValidacao: " . $chaveValidacao;
        
                    // A chave de validação não é válida, exiba uma mensagem de erro ou redirecione para uma página de erro
                    
                }
            } else {
                echo '<script>alert("As senhas não coincidem. Por favor, verifique e tente novamente.");</script>';
            }
        }
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
    <title>redefinir senha</title>
    <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/redefinir-senha.css">
    <link rel="icon" href="./imagem/book-solid.svg">
</head>
<body>

    <div class="container">
        <div class="form1">
            <h3>Coloque sua nova senha</h3>
            <form action="redefinir.php" class="form" method="post">
                <label class="label-input">
                    <i class="fa-solid fa-key"></i>
                    <input type="text"  name="chave_validacao" maxlength="50" placeholder="Confirma sua chave" required/>
                </label>
                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                <input type="password" name="nova_senha" id="nova_senha" maxlength="50" placeholder="Nova senha" required>
                </label>
                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                <input type="password" name="confirmar_senha" id="confirmar_senha" maxlength="50" placeholder="Confirme a senha" required>
                </label>
                <button type="submit" class="button">Redefinir Senha</button>
            </form>
        </div>
    </div>
</body>
</html>
