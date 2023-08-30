<?php

// processar formularios



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$email = $_POST['email'];
$password = $_POST['password'];
	
    if(!empty($nome) && !empty($apelido) && !empty($email) && !empty($password)){

        include('conexão.php');

		mysqli_query($dbc, "INSERT INTO users(nome,apelido,email,senha) VALUES('$nome','$apelido','$email','$password')");

		$registered = mysqli_affected_rows($dbc);

		echo '<script>alert("Seu registo foi feito com sucesso");</script>';

    }else{

        echo '<script>alert("Por favor, não deixe campos em brancos");</script>';

    }

}else{

    echo '<script>alert("Por favor, preencha o formulário");</script>';

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
        <link rel="stylesheet" class="link-midia-social" href="css/login.css">
        <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
        <link rel="icon" href="./imagem/book-solid.svg">   
    </head>
    <body>
        
<div class="container">
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
                <ul class="lista-midia-social">
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
                <a class="password" href="#">Esqueceu a sua senha?</a>
                <button class="btn btn-second">Entrar</button>
            </form>
       </div><!--Segunda coluna-->
    </div><!--Segundo Conteudo-->
</div><!--Container-->
<script src="js/login1.js"></script>
    </body>
</html>