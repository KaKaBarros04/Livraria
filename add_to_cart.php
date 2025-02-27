<?php
session_start();

// Verificar se os dados foram enviados corretamente
if (isset($_POST['book_id']) && isset($_POST['quantity'])) {
    $book_id = intval($_POST['book_id']); // Garante que seja um número inteiro
    $quantity = intval($_POST['quantity']); // Garante que seja um número inteiro

    if ($quantity < 1) {
        $quantity = 1; // Evita valores inválidos
    }

    // Criar o carrinho caso não exista
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar se o livro já está no carrinho
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]['quantity'] += $quantity; // Adiciona a quantidade
    } else {
        $_SESSION['cart'][$book_id] = ['quantity' => $quantity]; // Adiciona novo livro
    }

    echo json_encode(["status" => "success", "message" => "Livro adicionado ao carrinho!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao adicionar o livro."]);
}
