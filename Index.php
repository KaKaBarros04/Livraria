<?php
session_start();

// Função para gerar uma chave segura
function gerarChaveAleatoria($tamanho = 7) {
    return substr(bin2hex(random_bytes($tamanho)), 0, $tamanho);
}

$mostrarDiv = false;

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $apelido = trim($_POST['apelido']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($nome) || empty($apelido) || empty($email) || empty($password)) {
        $_SESSION['registro_erro'] = "Preencha todos os campos!";
        header("Location: Index.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registro_erro'] = "E-mail inválido!";
        header("Location: Index.php");
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['registro_erro'] = "A senha deve ter pelo menos 8 caracteres!";
        header("Location: Index.php");
        exit();
    }

    include('conexão.php');
    if (!$dbc) {
        die("Erro na conexão: " . mysqli_connect_error());
    }

    // Verificar se o e-mail já existe
    $queryCheckEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($dbc, $queryCheckEmail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['registro_erro'] = "Este e-mail já está registrado.";
        header("Location: Index.php");
        exit();
    }

    // Criar chave de validação e hash de senha
    $chaveValidacao = gerarChaveAleatoria();
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Inserir no banco
    $query = "INSERT INTO users (nome, apelido, email, senha, chave_validacao) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $apelido, $email, $passwordHash, $chaveValidacao);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($dbc) > 0) {
        $_SESSION['registro_sucesso'] = "registro realizado com sucesso!";
        $_SESSION['chave_validacao'] = $chaveValidacao;
        header("Location: Index.php");
        exit();
    } else {
        $_SESSION['registro_erro'] = "Erro ao cadastrar usuário.";
        header("Location: Index.php");
        exit();
    }
    
}
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
        <title>Login</title>
        <link rel="stylesheet" href="css/login.css">
        <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
        <link rel="icon" href="./imagens/book-solid.svg">   
    </head>
    <body>
        
<div class="container">
     <!-- Se $mostrarDiv for verdadeiro (registro bem-sucedido), exiba a div -->
     <?php if ($mostrarDiv) : ?>
    <div id="chave_validacao_div" style="display: flex; justify-content: center; align-items: center; z-index: 15; background-color: black; height: 250px; width: 250px; position: relative; top: 0; left: 500px; right: 0; bottom: 0; ">
        <div style="text-align: center;">
            <h4 style="color: white;">Guarde sua chave pois é necessario caso esqueça sua senha</h4>
            <h5 style="color: white;">Sua chave de validação:</h5>
            <p style="color: red;"><?php echo $chaveValidacao; ?></p>
            <span id="contador_regressivo" style="color: yellow;"></span>
        </div>
    </div>

    
    <script>
    // Função para ocultar a div após um intervalo de tempo (por exemplo, 5 segundos)
    function ocultarChaveValidacao() {
        var chaveDiv = document.getElementById("chave_validacao_div");
        var contadorRegressivo = document.getElementById("contador_regressivo");
        if (chaveDiv) {
            var segundosRestantes = 10; // Tempo em segundos
            var timer = setInterval(function() {
                contadorRegressivo.textContent = "Esta mensagem desaparecerá em " + segundosRestantes + " segundos";
                segundosRestantes--;
                if (segundosRestantes < 0) {
                    clearInterval(timer);
                    chaveDiv.style.display = "none";
                }
            }, 1000); // Atualiza a cada segundo
        }
    }

    // Chame a função para ocultar a div
    ocultarChaveValidacao();
    </script>
<?php endif; ?>
    <div class="conteudos primeiro-conteudo">
       <div class="primeira-coluna">
            <h2 class="title title-primary">Bem vindo</h2>
            <p class="description description-primary">Se já tiver uma conta</p>
            <p class="description description-primary">faça login com suas informações pessoais.</p>
            <button id="entrar" class="btn btn-primary">Entrar</button>
       </div>
       <div class="segunda-coluna">
            <h2 class="title title-second">Crie a sua conta</h2>
            <div class="redes-social">
                <ul class="lista-midia-social">x
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-facebook-f"></i></li></a>
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-google-plus-g"></i></li></a>
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-linkedin-in"></i></li></a>
                </ul>
            </div><!--Redes sociais-->

            <p class="description description-second">Ou utilize o seu e-mail para se registar</p>
            <form action="Index.php" class="form" id="signup-form" method="post">
                <label class="label-input" for="">
                    <i class="fa-regular fa-user icon-modify"></i>
                    <input type="text" name="nome" id="username" placeholder="Nome" maxlength="50">
                </label>
                <label class="label-input" for="">
                    <i class="fa-regular fa-user icon-modify"></i>
                    <input type="text" name="apelido" id="username" placeholder="Apelido" maxlength="50">
                </label>
                <label class="label-input" for="">
                    <i class="fa-regular fa-envelope icon-modify"></i>
                    <input type="email" name="email" id="email" placeholder="Email">
                </label>
                <label class="label-input" for="">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" name="password" placeholder="Senha" required>
                </label>
                <button class="btn btn-second">Increva-se</button>
            </form>
       </div><!--Segunda coluna-->
    </div><!--primeiro conteudo-->
    <div class="conteudos segundo-conteudo">
        <div class="primeira-coluna">
            <h2 class="title title-primary">Olá, Amigos</h2>
            <p class="description description-primary">Insira as suas informações pessoais</p>
            <p class="description description-primary">e comece a jornada conosco.</p>
            <button id="inscreva" class="btn btn-primary">Inscreva-se</button>
       </div>
       <div class="segunda-coluna">
            <h2 class="title title-second">Realize o login</h2>
            <div class="redes-social">
                <ul class="lista-midia-social">
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-facebook-f"></i></li></a>
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-google-plus-g"></i></li></a>
                    <a class="link-midia-social" href="#"><li class="item-midia"><i class="fa-brands fa-linkedin-in"></i></li></a>
                </ul>
            </div><!--Redes sociais-->
            <p class="description description-second">ou utilize a sua conta de email</p>
            <form action="login.php" class="form" id="login-form" method="post">
                <label class="label-input" for="">
                    <i class="fa-regular fa-envelope icon-modify"></i>
                    <input type="email" name="login_email" id="email1" placeholder="Email" maxlength="50">
                </label>
                <label class="label-input" for="">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" name="login_senha" id="password1" placeholder="password" maxlength="50">
                </label>
                <a class="password" href="Esqueceu-a-senha.php">Esqueceu a sua senha?</a>
                <button class="btn btn-second">Entrar</button>
            </form>
       </div><!--Segunda coluna-->
    </div><!--Segundo Conteudo-->
</div><!--Container-->
<script src="js/login1.js"></script>
    </body>
</html>