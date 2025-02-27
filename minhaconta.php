<?php
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para o login
if (!isset($_SESSION['user'])) {
    header("Location: PagLogin.php");
    exit();
}

include("conexão.php");

// Obtém os dados do usuário logado
$user_id = $_SESSION['user']['id'];

$query = $dbc->prepare("SELECT nome, email, profile_image FROM users WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Processa o upload da foto de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $image = $_FILES['profile_image'];

    // Verifica se o arquivo é uma imagem
    if (getimagesize($image['tmp_name']) !== false) {
        $target_dir = "imagens/";
        $target_file = $target_dir . basename($image["name"]);

        // Verifica se o arquivo já existe
        if (file_exists($target_file)) {
            $_SESSION['error_message'] = "O arquivo já existe.";
        } else {
            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Atualiza o caminho da imagem no banco de dados
                $update_query = $dbc->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
                $update_query->bind_param("si", $target_file, $user_id);
                $update_query->execute();

                // Atualiza a imagem na sessão
                $_SESSION['user']['profile_image'] = $target_file;
                $_SESSION['success_message'] = "Imagem de perfil atualizada com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao fazer o upload da imagem.";
            }
        }
    } else {
        $_SESSION['error_message'] = "O arquivo não é uma imagem válida.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Empower Books</title>
    <link rel="stylesheet" href="./css/minhaconta.css">
</head>
<body>

<header>
    <h1>Minha Conta</h1>
</header>

<nav>
    <a href="Index.php">Início</a>
    <a href="historico_compras.php">Histórico de compras</a>
    <a href="logout.php">Sair</a>
</nav>

<main>
    <section class="conta-container">
        <!-- Exibe mensagem de sucesso ou erro -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success"><?= $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="message error"><?= $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Exibe a foto de perfil ou a foto padrão -->
        <img src="<?= isset($user['profile_image']) && !empty($user['profile_image']) ? $user['profile_image'] : 'imagens/user.jpg' ?>" alt="Foto de perfil" class="profile-image">

        <h2>Bem-vindo, <?= htmlspecialchars($user['nome']) ?>!</h2>

        <div class="dados-usuario">
            <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <!-- Formulário de upload de foto -->
        <form action="minhaconta.php" method="POST" enctype="multipart/form-data">
            <label for="profile_image">Alterar Foto de Perfil:</label>
            <input type="file" name="profile_image" id="profile_image" accept="image/*">
            <button type="submit">Alterar Foto</button>
        </form>

        <a href="editarconta.php">Editar Informações</a>
    </section>
</main>

<footer>
    &copy; 2025 Empower Books | Todos os direitos reservados
</footer>

</body>
</html>
