
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
        $target_dir = "uploads/";
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
    <link rel="icon" href="./imagens/book-solid.svg">
</head>
<body>
    <header>
        <h1>EMPOWER BOOKS ADMINISTRAÇÃO</h1>        
    </header>

    <nav>
        <a href="#"><button id="menu-toggle" class="menu-toggle">&#9776;</button></a>
        <a href="#">Início</a>
        <a href="#">Sobre</a>
        <a href="#">Produtos</a>
        <a href="#">Contato</a>
        
        <div class="user-dropdown">
            <img class="user-img" src="./imagens/user.jpg" alt="">
            <div class="dropdown-content">
                <a href="#">Ver conta</a>
                <a href="redefinir.php">Redefinir senha</a>
                <a href="Index.php">Sair</a>
            </div>
        </div>
        
        <!-- Formulário de pesquisa à direita usando flexbox -->
        <form action="/pesquisar" method="GET">
            <input type="text" name="q" placeholder="Digite sua pesquisa...">
            <button type="submit">Pesquisar</button>
        </form>
    </nav>
    
    <main>
       
        
        
        <div class="navmenu">
            <?php
            // Conexão com o banco de dados 
            include('conexão.php');

            // Verifique se a conexão falhou
            if (!$dbc) {
                die("Não foi possível conectar ao banco de dados: " . mysqli_connect_error());
            }

            $select_categoria = mysqli_query($dbc, "SELECT * FROM categorias ORDER BY idcategoria DESC");

            if (mysqli_num_rows($select_categoria) >= 1) :
            ?>
                <ul class="menu">
                    <?php while ($res = mysqli_fetch_assoc($select_categoria)) : ?>
                        <li class="menu-item">
                            <!-- Adicione o parâmetro sub_category_id ao href -->
                            <a href="subcategorias.php?sub_category_id=<?= $res['idcategoria'] ?>"><?= $res['NomeCategoria'] ?></a>

                            <?php
                            // Se existirem subcategorias, exiba-as
                            $subcat = mysqli_query($dbc, "SELECT * FROM subcategoria WHERE idcategoria = " . $res['idcategoria'] . " ORDER BY Nome DESC");

                            if (mysqli_num_rows($subcat) >= 1) :
                            ?>
                                <ul class="submenu">
                                    <?php while ($linha = mysqli_fetch_assoc($subcat)) : ?>
                                        <li class="submenu-item">
                                            <a href="<?= $linha['slug'] ?>"><?= $linha['Nome'] ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <h2>Bem vindo Administrador</h2>
        <h1>Gerenciar Livros</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="author" placeholder="Autor" required>
        <textarea name="description" placeholder="Descrição"></textarea>
        <input type="number" name="price" placeholder="Preço" step="0.01" required>
        <input type="number" name="stock" placeholder="Estoque" required>
        <input type="number" name="category_id" placeholder="Categoria ID" required>
        <input type="number" name="sub_category_id" placeholder="Subcategoria ID" required>
        <input type="file" name="image">
        <button type="submit" name="add_book">Adicionar Livro</button>
    </form>
    
    <h2>Livros Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        <?php while ($book = $books->fetch_assoc()) : ?>
            <tr>
                <td><?= $book['book_id'] ?></td>
                <td><?= $book['title'] ?></td>
                <td><?= $book['author'] ?></td>
                <td>€ <?= number_format($book['price'], 2, ',', '.') ?></td>
                <td><?= $book['stock'] ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $book['book_id'] ?>">Editar</a>
                    <a href="AdmLi.php?archive=<?= $book['book_id'] ?>" onclick="return confirm('Tem certeza que deseja arquivar este livro?')">Arquivar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </main>

    <footer>
        &copy; 2023 EMPOWER BOOKS | Todos os direitos reservados
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script src="./js/admLi.js"></script>
</body>

