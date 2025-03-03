<?php
include('conexão.php');
session_start();

// Função para calcular o total do carrinho
function calculateTotal() {
    $total = 0;
    global $dbc;

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $book_id => $item) {
            // Obter o preço do livro a partir do banco de dados
            $sql = "SELECT price FROM books WHERE book_id = ?";
            $stmt = $dbc->prepare($sql);
            $stmt->bind_param("i", $book_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $book = $result->fetch_assoc();
                $total += $book['price'] * $item['quantity'];
            } else {
                echo "<p>Erro: Livro com ID $book_id não encontrado.</p>";
            }
        }
    }
    return $total;
} 


// Verificar se o pedido foi confirmado
if (isset($_POST['confirm_order'])) {
    if (empty($_POST['address']) || empty($_POST['payment_method'])) {
        echo "<p>Erro: Todos os campos são obrigatórios!</p>";
        exit;
    }

    // Obter dados do pedido
    $user_id = $_SESSION['user']['id']; 
    $total_price = calculateTotal();
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Inserir pedido na tabela orders
    $sql = "INSERT INTO orders (user_id, total_price, delivery_address, payment_method, order_date, status)
            VALUES (?, ?, ?, ?, NOW(), 'pending')";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("idss", $user_id, $total_price, $address, $payment_method);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Inserir os itens do pedido na tabela order_items
        foreach ($_SESSION['cart'] as $book_id => $item) {
            $sql_item = "SELECT price FROM books WHERE book_id = ?";
            $stmt_item = $dbc->prepare($sql_item);
            $stmt_item->bind_param("i", $book_id);
            $stmt_item->execute();
            $result_item = $stmt_item->get_result();

            if ($result_item && $result_item->num_rows > 0) {
                $book_price = $result_item->fetch_assoc()['price'];
                $quantity = $item['quantity'];

                $sql_order_item = "INSERT INTO order_items (order_id, book_id, quantity, price)
                                   VALUES (?, ?, ?, ?)";
                $stmt_order_item = $dbc->prepare($sql_order_item);
                $stmt_order_item->bind_param("iiid", $order_id, $book_id, $quantity, $book_price);
                $stmt_order_item->execute();
            } else {
                echo "<p>Erro: Livro com ID $book_id não encontrado.</p>";
            }
        }

        unset($_SESSION['cart']);
        header("Location: order_confirmation.php");
        exit;
    } else {
        echo "Erro ao processar o pedido.";
    }
}



// Verificar se o livro foi adicionado via GET
if (isset($_GET['book_id'])) {
    $book_id = (int)$_GET['book_id']; 
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    // Buscar o livro no banco de dados
    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Adicionar o livro ao carrinho
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$book_id])) {
            // Atualizar a quantidade se o livro já estiver no carrinho
            $_SESSION['cart'][$book_id]['quantity'] += $quantity;
        } else {
            // Adicionar o livro ao carrinho
            $_SESSION['cart'][$book_id] = ['quantity' => $quantity];
        }

    } else {
        echo "Livro não encontrado.";
        exit;
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
    <meta name="og:title" content="checkout">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Finalizar Compra</title>
    <link rel="stylesheet" href="./css/checkout.css">
    <link rel="icon" href="./imagens/shopping-bag-svgrepo-com.svg">
    <script>
        // Função para mostrar/ocultar os campos baseados no método de pagamento
        function togglePaymentFields() {
            var paymentMethod = document.getElementById("payment_method").value;

            // Ocultar ambos os campos
            document.getElementById("credit_card_fields").style.display = "none";
            document.getElementById("mbway_fields").style.display = "none";

            // Mostrar os campos de cartão de crédito ou MBWay dependendo da escolha
            if (paymentMethod == "credit_card") {
                document.getElementById("credit_card_fields").style.display = "block";
            } else if (paymentMethod == "mbway") {
                document.getElementById("mbway_fields").style.display = "block";
            }
        }

        // Inicializar os campos no carregamento
        window.onload = function() {
            togglePaymentFields();  // Verificar o método de pagamento já selecionado na primeira vez
        };
    </script>
</head>
<body>
    <header>
    <h1>Finalizar Compra</h1>
    </header>
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <nav>
        <h2 class="r">Resumo do Carrinho</h2>
        </nav>
        <div class="table">
        <table border="1">
            <tr>
                <th>Livro</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Total</th>
            </tr>

            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $book_id => $item):
                $sql = "SELECT title, price FROM books WHERE book_id = ?";
                $stmt = $dbc->prepare($sql);
                $stmt->bind_param("i", $book_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $book = $result->fetch_assoc(); 
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>€ <?php echo number_format($book['price'], 2, ',', '.'); ?></td>
                    <td>€ <?php echo number_format($book['price'] * $item['quantity'], 2, ',', '.'); ?></td>
                </tr>
            <?php
                    $total += $book['price'] * $item['quantity'];
                } else {
                    echo "<p>Erro: Livro com ID $book_id não encontrado.</p>";
                }
            endforeach;
            ?>

        </table>
        </div>
        <h3>Total: € <?php echo number_format($total, 2, ',', '.'); ?></h3>

        <h2>Informações de Pagamento</h2>
        <form action="checkout.php" method="POST">
            <label for="name">Nome completo:</label><br>
            <input type="text" id="Nome" name="name" required><br>

            <label for="address">Endereço de Entrega:</label><br>
            <input type="text" id="address" name="address" required><br><br>

            <label for="payment_method">Método de Pagamento:</label><br>
            <select id="payment_method" name="payment_method" required onchange="togglePaymentFields()">
                <option value="credit_card">Cartão de Crédito</option>
                <option value="mbway">MBway</option>
            </select><br><br>
 <!-- Campos de Cartão de Crédito -->
 <div id="credit_card_fields" style="display:none;">
                <label for="card_number">Número do Cartão:</label><br>
                <input type="text" id="card_number" name="card_number" placeholder="xxxx xxxx xxxx xxxx" required><br>

                <label for="expiry_date">Data de Expiração:</label><br>
                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/AA" required><br>

                <label for="cvv">CVV:</label><br>
                <input type="text" id="cvv" name="cvv" placeholder="xxx" required><br><br>
            </div>

            <!-- Campos de MBWay -->
            <div id="mbway_fields" style="display:none;">
                <label for="phone_number">Número de Telefone:</label><br>
                <input type="text" id="phone_number" name="phone_number" placeholder="Número MBWay" required><br><br>
            </div>
            <input type="submit" name="confirm_order" value="Confirmar Compra">
        </form>

    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <br>
    <div class="div-vlt">
    <a href="cart.php" class="Voltar">Voltar ao Carrinho</a>
    </div>
    <footer>
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
    </footer>

</body>
</html>
