<?php 

session_start();

// Habilitar exibição de erros apenas para desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar a sessão de forma segura
session_set_cookie_params([
    'httponly' => true, 
    'secure' => isset($_SERVER['HTTPS']),
    'samesite' => 'Strict'
]);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("conexão.php");

// Verificar conexão com o banco
if (!$dbc) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Validar se os campos foram preenchidos
    if (empty($_POST['login_email']) || empty($_POST['login_senha'])) {
        $_SESSION['login_error'] = "Preencha todos os campos!";
        header("Location: login.php");
        exit();
    }

    // Capturar valores e proteger contra SQL Injection
    $login_email = mysqli_real_escape_string($dbc, trim($_POST['login_email']));
    $login_password = trim($_POST['login_senha']);

    // Criar a consulta segura usando Prepared Statements
    $query = mysqli_prepare($dbc, "SELECT user_id, nome, senha, tipo_usuario FROM users WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $login_email);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    // Verificar se o e-mail existe e validar senha
    
    // Verificar se o e-mail existe e validar senha
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($login_password, $row['senha'])) {
            $_SESSION['user'] = [
                'id' => $row['user_id'],
                'name' => $row['nome'],
                'tipo_usuario' => $row['tipo_usuario']  // Corrigir o nome da coluna
            ];
            // Redirecionar conforme o tipo de usuário
            if ($row['tipo_usuario'] == 'admin') {
                // Se for admin, redireciona para a página do admin
                header("Location: AdmLi.php");
            } else {
                // Se for cliente, redireciona para a página inicial
                header("Location: Index.php");
            }
            exit();
        } else {
            // Se a senha estiver incorreta
            $_SESSION['login_error'] = "Senha incorreta!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Se o e-mail não for encontrado
        $_SESSION['login_error'] = "E-mail não encontrado!";
        header("Location: login.php");
        exit();
    }

} else {
    http_response_code(403);
    echo "Email ou senha inválidos!";
}



?>