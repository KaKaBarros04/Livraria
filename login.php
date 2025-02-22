<?php 

// Habilitar exibição de erros apenas para desenvolvimento (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar a sessão apenas quando necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("conexão.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Validar se os campos foram preenchidos
    if (empty($_POST['login_email']) || empty($_POST['login_senha'])) {
        echo "Preencha todos os campos!";
        exit();
    }

    // Capturar valores e proteger contra SQL Injection
    $login_email = mysqli_real_escape_string($dbc, trim($_POST['login_email']));
    $login_password = trim($_POST['login_senha']);

    // Criar a consulta segura usando Prepared Statements
    $query = mysqli_prepare($dbc, "SELECT user_id, nome, senha FROM users WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $login_email);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    // Verificar se o e-mail existe
    if ($row = mysqli_fetch_assoc($result)) {
        // Comparar a senha fornecida com o hash no banco
        if (password_verify($login_password, $row['senha'])) {
            // Definir sessão do usuário
            $_SESSION['user_id'] = $row['user_id'];  // Usando 'user_id' que é a chave primária
            $_SESSION['user_name'] = $row['nome'];

            // Redirecionar para a página inicial
            header("Location: Home.php");
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "E-mail não registrado! Por favor, crie uma conta.";
    }

    // Fechar a conexão
    mysqli_stmt_close($query);
    mysqli_close($dbc);
} else {
    echo "Acesso inválido!";
}
?>
