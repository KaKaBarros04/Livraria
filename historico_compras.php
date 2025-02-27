<?php
session_start();
include('conexão.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id']; // Obtendo o ID do usuário logado

// Recupera o histórico de compras do usuário logado
$query = $dbc->prepare("
    SELECT o.order_id, o.order_date, o.total_price, oi.book_id, oi.quantity, oi.price, b.title
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN books b ON oi.book_id = b.book_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

// Verifica se a consulta retornou resultados
if (!$result) {
    die('Erro na consulta SQL: ' . mysqli_error($dbc));
}

// Organiza os dados das compras
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Histórico de Compras</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Histórico de Compras</h2>

<?php if (count($orders) > 0): ?>
    <table>
        <tr>
            <th>Data do Pedido</th>
            <th>Livro</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Total</th>
        </tr>
        <?php
        $current_order_id = null;
        $order_total = 0;

        foreach ($orders as $order) {
            if ($order['order_id'] !== $current_order_id) {
                if ($current_order_id !== null) {
                    echo "<tr><td colspan='4' style='text-align:right'><strong>Total:</strong></td><td><strong>R$ " . number_format($order_total, 2, ',', '.') . "</strong></td></tr>";
                }
                $current_order_id = $order['order_id'];
                $order_total = 0;
                echo "<tr><td colspan='5'><strong>Pedido ID: " . $order['order_id'] . " - " . date('d/m/Y H:i', strtotime($order['order_date'])) . "</strong></td></tr>";
            }

            $order_total += $order['price'] * $order['quantity'];
            ?>
            <tr>
                <td></td> <!-- Célula em branco para alinhamento -->
                <td><?= htmlspecialchars($order['title']) ?></td>
                <td><?= $order['quantity'] ?></td>
                <td>R$ <?= number_format($order['price'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($order['price'] * $order['quantity'], 2, ',', '.') ?></td>
            </tr>
        <?php } ?>
        <tr><td colspan="4" style="text-align:right"><strong>Total:</strong></td><td><strong>R$ <?= number_format($order_total, 2, ',', '.') ?></strong></td></tr>
    </table>
<?php else: ?>
    <p>Você ainda não fez nenhuma compra.</p>
<?php endif; ?>

<a href="minhaconta.php">Voltar</a>

</body>
</html>
