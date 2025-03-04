<?php
session_start();

// Verifique se o usuário está logado (opcional, dependendo da necessidade)
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include("conexão.php");

// Verifique a conexão com o banco
if (!$dbc) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta para pegar o histórico de vendas do usuário logado
$user_id = $_SESSION['user']['id'];
$query = "SELECT o.order_id, o.order_date, oi.quantity, oi.price, 
b.title, (oi.quantity * oi.price) AS total_price
FROM orders o
JOIN order_items oi ON o.order_id = oi.order_id
JOIN books b ON oi.book_id = b.book_id
ORDER BY o.order_date DESC";



$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
    <meta name="og:title" content="Historico de compras">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico de Vendas</title>
    <link rel="stylesheet" href="./css/historico_vendas.css">
    <link rel="icon" href="./imagens/list-svgrepo-com.svg">
</head>
<body> 
    <header>
    <h1>Histórico de Vendas</h1>
</header>
    <?php
    // Verifica se há vendas registradas
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='3'>";
        echo "<tr><th>ID da Venda</th><th>Produto</th><th>Data da Venda</th><th>Total</th></tr>";
        
        // Exibe cada venda
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Você não tem vendas registradas.</p>";
    }

    // Fechar a conexão
    mysqli_free_result($result);
    mysqli_close($dbc);
    ?>

    <br><a class="btn_voltar" href="minhaconta_adm.php">Voltar à Página Inicial</a>
</body>
</html>
