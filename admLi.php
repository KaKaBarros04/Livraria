
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redireciona para o login
    exit();
}

// Conectar ao banco de dados
include('conexão.php');

// Adicionar Livro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    
    // Upload da imagem
    $image_path = "";
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "imagens/";
        $image_path = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }
    
    $query = "INSERT INTO books (title, author, description, price, stock, category_id, sub_category_id, image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("sssdiiss", $title, $author, $description, $price, $stock, $category_id, $sub_category_id, $image_path);
    $stmt->execute();
    header("Location: AdmLi.php");
}

// Arquivar Livro
if (isset($_GET['archive'])) {
    $book_id = $_GET['archive'];
    $query = "UPDATE books SET archived_at = NOW() WHERE book_id = ?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    header("Location: AdmLi.php");
}

// Excluir definitivamente livros arquivados há mais de 30 dias
$query = "DELETE FROM books WHERE archived_at IS NOT NULL AND archived_at < NOW() - INTERVAL 30 DAY";
$dbc->query($query);

// Listar Livros
$books = $dbc->query("SELECT * FROM books WHERE archived_at IS NULL");

// Consultar categorias
$categories_query = "SELECT * FROM categorias";
$categories_result = $dbc->query($categories_query);

// Consultar subcategorias (você pode precisar de um filtro para subcategorias relacionadas a uma categoria específica, se houver)
$sub_categories_query = "SELECT * FROM subcategoria";
$sub_categories_result = $dbc->query($sub_categories_query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Kauan Benitez" />
    <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
    <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="og:title" content="Título da página">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empower Books Adm</title>
    <link rel="stylesheet" href="./css/styleadm.css">
    <link rel="icon" href="./imagens/administration-job-with-archive-svgrepo-com.svg">
</head>
<body>
    <header>
        <h1>EMPOWER BOOKS ADMINISTRAÇÃO</h1>        
    </header>

    <nav>
       
        <a href="#">Início</a>
        <a href="#">Sobre</a>
        <a href="#">Produtos</a>
        <a href="#">Contato</a>
        
        <div class="user-dropdown">
            <img class="user-img" src="./imagens/user.jpg" alt="">
            <div class="dropdown-content">
                <a href="minhaconta_adm.php">Ver conta</a>
                <a href="redefinir.php">Redefinir senha</a>
                <a href="logout.php">Sair</a>
            </div>
        </div>
        
       
    </nav>
    
    <main>
        
        <h1 class="AdmText">Gerenciar Livros</h1>
    
        <form method="POST" enctype="multipart/form-data" class="form" id="add-book-form">
    <label class="label-input" for="title">
        <i class="fa-solid fa-book icon-modify"></i>
        <input type="text" name="title" id="title" placeholder="Título" required>
    </label>
    
    <label class="label-input" for="author">
        <i class="fa-solid fa-pen icon-modify"></i>
        <input type="text" name="author" id="author" placeholder="Autor" required>
    </label>
    
    <label class="label-input" for="description">
        <i class="fa-solid fa-align-left icon-modify"></i>
        <textarea name="description" id="description" placeholder="Descrição"></textarea>
    </label>
    
    <label class="label-input" for="price">
        <i class="fa-solid fa-dollar-sign icon-modify"></i>
        <input type="number" name="price" id="price" placeholder="Preço" step="0.01" required>
    </label>
    
    <label class="label-input" for="stock">
        <i class="fa-solid fa-cogs icon-modify"></i>
        <input type="number" name="stock" id="stock" placeholder="Estoque" required>
    </label>
    
     <!-- Campo de Categoria -->
     <label class="label-input" for="category_id">
        <i class="fa-solid fa-list icon-modify"></i>
        <select name="category_id" id="category_id" required>
            <option value="">Selecione uma Categoria</option>
            <?php while ($category = $categories_result->fetch_assoc()) : ?>
                <option value="<?= $category['idcategoria'] ?>"><?= $category['NomeCategoria'] ?></option>
            <?php endwhile; ?>
        </select>
    </label>

    <!-- Campo de Subcategoria -->
    <label class="label-input" for="sub_category_id">
        <i class="fa-solid fa-cogs icon-modify"></i>
        <select name="sub_category_id" id="sub_category_id" required>
            <option value="">Selecione uma Subcategoria</option>
            <?php while ($sub_category = $sub_categories_result->fetch_assoc()) : ?>
                <option value="<?= $sub_category['sub_category_id'] ?>"><?= $sub_category['Nome'] ?></option>
            <?php endwhile; ?>
        </select>
    </label>

    
    <label class="label-input" for="image">
        <i class="fa-solid fa-image icon-modify"></i>
        <input type="file" name="image" id="image">
    </label>

    <button class="btn btn-second" type="submit" name="add_book">Adicionar Livro</button>
</form>

    
    <h2 class="AdmText">Livros Cadastrados</h2>
    <table border="1" class="custom-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        </thead>
        <?php while ($book = $books->fetch_assoc()) : ?>
        <tbody>
            <tr>
                <td><?= $book['book_id'] ?></td>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td>€ <?= number_format($book['price'], 2, ',', '.') ?></td>
                <td><?= $book['stock'] ?></td>
                <td>
                    <a href="editar-livros.php?id=<?= $book['book_id'] ?>" class="btn-edit">✏️</a>
                    <a href="AdmLi.php?archive=<?= $book['book_id'] ?>" onclick="return confirm('Tem certeza que deseja arquivar este livro?')" class="btn-delete">🗑️</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
            <div class="Aqv">
                 <a class="liaqv" href="livros-arquivados.php">Livros Excluindo</a>
            </div>
    </main>

    <footer>
        &copy; 2025 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script src="./js/admLi.js"></script>
</body>

