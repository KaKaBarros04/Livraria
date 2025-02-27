<?php

session_start(); // Iniciar a sessão
include('conexão.php');

// Verificar se o formulário foi enviado
if (isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id']; // ID do livro
    $quantity = $_POST['quantity']; // Quantidade

    // Verificar se o carrinho já existe na sessão, se não, inicializá-lo
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar se o livro já está no carrinho
    $found = false;
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['book_id'] == $book_id) {
            // Se o livro já estiver no carrinho, apenas atualiza a quantidade
            $_SESSION['cart'][$index]['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // Se o livro não foi encontrado no carrinho, adicioná-lo
    if (!$found) {
        $_SESSION['cart'][] = [
            'book_id' => $book_id,
            'quantity' => $quantity
        ];
    }

    // Redirecionar para a página do carrinho
    header('Location: cart.php');
    exit();
}

// Agora o restante do código de exibição do carrinho vai aqui...



// Função para adicionar um item ao carrinho
function addToCart($book_id, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Se o livro já está no carrinho, aumente a quantidade
    if (!isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] = ['book_id' => $book_id, 'quantity' => 0];
    }
    $_SESSION['cart'][$book_id]['quantity'] += $quantity;
    
}

// Função para remover um item do carrinho
function removeFromCart($book_id) {
    unset($_SESSION['cart'][$book_id]);
}

// Função para calcular o total do carrinho
function calculateTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $book_id => $item) {
            // Obter o preço do livro a partir do banco de dados
            global $conn; // Conexão com o banco de dados
            $sql = "SELECT price FROM books WHERE book_id = $book_id";
            $result = mysqli_query($conn, $sql);
            $book = mysqli_fetch_assoc($result);
            $total += $book['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Verificar se o usuário quer adicionar ou remover um item
if (isset($_GET['add'])) {
    addToCart($_GET['add'], 1); // Adiciona 1 unidade do livro
}
if (isset($_GET['remove'])) {
    removeFromCart($_GET['remove']);
}

// Exibir o carrinho
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>
    <nav>
    <a href="Index.php">Inicio</a>
    <a href="produtos.php">Produtos</a>
    </nav>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table border="1">
            <tr>
                <th>Livro</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Total</th>
                <th>Ação</th>
            </tr>

            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $book_id => $item):
                // Obter detalhes do livro do banco de dados
                $sql = "SELECT title, price FROM books WHERE book_id = ?";
                $stmt = mysqli_prepare($dbc, $sql);
                mysqli_stmt_bind_param($stmt, "i", $book_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $book = mysqli_fetch_assoc($result);

                // Verificar se o livro foi encontrado no banco de dados
                if (!$book) {
                   
                    continue; // Pula para o próximo item do carrinho
                }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>€ <?php echo number_format($book['price'], 2, ',', '.'); ?></td>
                    <td>€ <?php echo number_format($book['price'] * $item['quantity'], 2, ',', '.'); ?></td>
                    <td><a href="?remove=<?php echo $book_id; ?>">Remover</a></td>
                </tr>
            <?php
                $total += $book['price'] * $item['quantity'];
            endforeach;
            ?>

        </table>

        <h2>Total: €<?php echo number_format($total, 2, ',', '.'); ?></h2>

        <form action="checkout.php" method="POST">
            <input type="submit" value="Finalizar Compra">
        </form>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Continuar comprando</a>
</body>
</html>
