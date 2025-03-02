<?php
session_start();
include("conexão.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: PagLogin.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Obtém os dados atuais do usuário
$query = $dbc->prepare("SELECT nome, email, senha FROM users WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Atualizar os dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = trim($_POST['nome']);
    $novo_email = trim($_POST['email']);

    // Verificar se o novo e-mail já existe no banco
    $email_check_query = $dbc->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    $email_check_query->bind_param("si", $novo_email, $user_id);
    $email_check_query->execute();
    $email_check_result = $email_check_query->get_result();

    if ($email_check_result->num_rows > 0) {
        $erro = "Este e-mail já está em uso por outro usuário.";
    } else {
        // Atualiza o nome e o e-mail
        $update_query = $dbc->prepare("UPDATE users SET nome = ?, email = ? WHERE user_id = ?");
        $update_query->bind_param("ssi", $novo_nome, $novo_email, $user_id);

        if ($update_query->execute()) {
            $_SESSION['user']['nome'] = $novo_nome; // Atualiza a sessão
            $_SESSION['user']['email'] = $novo_email; // Atualiza o e-mail na sessão
            header("Location: minhaconta.php");
            exit();
        } else {
            $erro = "Erro ao atualizar os dados.";
        }
    }
}

// Alteração de senha
if (isset($_POST['senha_atual']) && isset($_POST['nova_senha']) && !empty($_POST['nova_senha'])) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    // Verificar se a senha atual está correta
    $query_senha = $dbc->prepare("SELECT senha FROM users WHERE user_id = ?");
    $query_senha->bind_param("i", $user_id);
    $query_senha->execute();
    $result_senha = $query_senha->get_result();
    $user_senha = $result_senha->fetch_assoc();

    if (password_verify($senha_atual, $user_senha['senha'])) {
        // Senha correta, atualiza com a nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $update_senha_query = $dbc->prepare("UPDATE users SET senha = ? WHERE user_id = ?");
        $update_senha_query->bind_param("si", $nova_senha_hash, $user_id);

        if ($update_senha_query->execute()) {
            $sucesso = "Senha alterada com sucesso!";
        } else {
            $erro = "Erro ao alterar a senha.";
        }
    } else {
        $erro = "Senha atual incorreta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJfQ2z8MXt6jPqGYO5yf3M1+Tl8Xq0bMjjcFrWEmya1P+vWo6dLrDQw9c0Q5" crossorigin="anonymous">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta</title>
    <link rel="stylesheet" href="./css/editar_acc.css">
    <link rel="icon" href="./imagens/pencil-svgrepo-com.svg">
</head>
<body>

<header>
    <h1>Editar Conta</h1>
</header>

<nav>
    <a href="minhaconta.php">Voltar</a>
</nav>

<main>
    <section class="conta-container">
        <h2>Editar Informações</h2>

        <?php if (isset($erro)) : ?>
            <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <?php if (isset($sucesso)) : ?>
            <p style="color: green;"><?= htmlspecialchars($sucesso) ?></p>
        <?php endif; ?>

        <!-- Formulário de Alteração de Dados -->
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($user['nome']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <button type="submit">Salvar Alterações</button>
        </form>

        <hr>

        <!-- Formulário de Alteração de Senha -->
        <h3>Alterar Senha</h3>
        <form method="POST">
            <label for="senha_atual">Senha Atual:</label>
            <input type="password" name="senha_atual" id="senha_atual" required>

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" required>

            <button type="submit">Alterar Senha</button>
        </form>
    </section>
</main>

<footer>
    &copy; 2025 Empower Books | Todos os direitos reservados
</footer>

</body>
</html>
