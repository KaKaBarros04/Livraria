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

$query = $dbc->prepare("SELECT nome, email, profile_image, phone_number FROM users WHERE user_id = ?");
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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone_number'])) {
    $phone = trim($_POST['phone_number']);  // Obtém o número de telefone enviado pelo formulário

    // Validação do número de telefone
    if (empty($phone)) {
        $_SESSION['error_message'] = "Por favor, insira um número de telefone.";
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        // Validando o formato do número de telefone (aceita números com 10 a 15 dígitos e opcionalmente o '+')
        $_SESSION['error_message'] = "Adicione um numero de telefone. Por favor, use um formato válido.";
    } else {
        // Atualiza o número de telefone no banco de dados
        $user_id = $_SESSION['user']['id'];  // Pega o ID do usuário logado na sessão
        $update_query = $dbc->prepare("UPDATE users SET phone_number = ? WHERE user_id = ?");
        $update_query->bind_param("si", $phone, $user_id);  // 's' para string e 'i' para inteiro

        if ($update_query->execute()) {
            // Atualiza o número de telefone na variável de sessão
            $_SESSION['user']['phone_number'] = $phone;
            $_SESSION['success_message'] = "Número de telefone atualizado com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao atualizar o número de telefone.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Adicionando o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJfQ2z8MXt6jPqGYO5yf3M1+Tl8Xq0bMjjcFrWEmya1P+vWo6dLrDQw9c0Q5" crossorigin="anonymous">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Minha conta">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Empower Books</title>
    <link rel="stylesheet" href="./css/minhaconta.css">
    <link rel="icon" href="./imagens/circle-user-svgrepo-com.svg">
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
            <p><strong>Nº de telefone:</strong> <?= htmlspecialchars($user['phone_number'])?></p>
        </div>
         <!-- Formulário para atualizar o número de telefone -->
    <form action="minhaconta.php" method="POST">
        <label for="phone_number">Número de Telefone:</label><br>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo isset($_SESSION['user']['phone_number']) ? htmlspecialchars($_SESSION['user']['phone_number']) : ''; ?>" required><br><br>
        <input type="submit" value="Atualizar Número">
    </form>
        <!-- Formulário de upload de foto -->
        <form action="minhaconta.php" method="POST" enctype="multipart/form-data">
            <label for="profile_image">Alterar Foto de Perfil:</label>
            <input type="file" name="profile_image" id="profile_image" accept="image/*">
            <button type="submit">Alterar Foto</button>
        </form>

        <a class="editar" href="editarconta.php">Editar Informações</a>
    </section>
</main>

<footer>
    &copy; 2025 Empower Books | Todos os direitos reservados
</footer>

</body>
</html>
