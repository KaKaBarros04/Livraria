<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('conexão.php');

// Função para validar entrada de dados
function limparEntrada($dbc, $input) {
    return mysqli_real_escape_string($dbc, trim($input));
}

// Verificar se a chave de validação e a senha foram enviadas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chave_validacao'], $_POST['nova_senha'], $_POST['confirmar_senha'])) {
    $chaveValidacao = limparEntrada($dbc, $_POST['chave_validacao']);
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];

    // Verificar se as senhas coincidem
    if ($novaSenha !== $confirmarSenha) {
        echo '<script>alert("As senhas não coincidem. Tente novamente.");</script>';
        exit();
    }

    // Consultar o banco para validar a chave
    $query = "SELECT id FROM users WHERE chave_validacao = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "s", $chaveValidacao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        // Chave válida, atualiza a senha
        mysqli_stmt_bind_result($stmt, $userId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Hash seguro da nova senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        // Atualizar a senha e invalidar a chave de validação
        $updateQuery = "UPDATE users SET senha = ?, chave_validacao = NULL WHERE id = ?";
        $updateStmt = mysqli_prepare($dbc, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "si", $senhaHash, $userId);
        mysqli_stmt_execute($updateStmt);

        if (mysqli_stmt_affected_rows($updateStmt) === 1) {
            echo '<script>alert("Senha redefinida com sucesso! Faça login com sua nova senha.");</script>';
            header('Location: Index.php');
            exit();
        } else {
            echo '<script>alert("Erro ao atualizar a senha. Tente novamente mais tarde.");</script>';
        }
        mysqli_stmt_close($updateStmt);
    } else {
        echo '<script>alert("Chave de validação inválida.");</script>';
    }
    mysqli_close($dbc);
}
?>


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="./css/redefinir-senha.css">
    <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="form1">
            <h3>Redefinir sua senha</h3>
            <form action="redefinir.php" method="POST">
                <label class="label-input">
                    <i class="fa-solid fa-key"></i>
                    <input type="text" name="chave_validacao" maxlength="50" placeholder="Chave de validação" required />
                </label>

                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" name="nova_senha" maxlength="50" placeholder="Nova senha" required />
                </label>

                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" name="confirmar_senha" maxlength="50" placeholder="Confirmar senha" required />
                </label>

                <button type="submit" class="button">Redefinir Senha</button>
            </form>
        </div>
    </div>
</body>

</html>

