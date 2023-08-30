<?php

//checar se o utilizador enviou:
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //connect to datebase:
    include('conexão.php');


    //creat an array for errors:
    $erros = array();
    
    //check for email andress:
    if (empty($_POST['email'])) {
        $erros[] = 'you forgot to enter your email!';
    }else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    //check current password:
    if (empty($_POST['pass'])) {
        $erros[] = 'you forgot to enter your current password!';
    }else {
        $p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
    }

    //check a new password and compare it with confirmed password:
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $erros[] = 'Your new password does not match the confirmed password!';
        }else {
            $np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        } 
    }else {
        $erros[] = 'You forgot to enter your new password';
    }

    //if there is no erros:
    if (empty($erros)){
        //check that the user enterd the right email/password combination:
        $q = "SELECT id FROM users WHERE (email='$e' AND senha='$p')";
        $r = mysqli_query($dbc, $q);
        $num = mysqli_num_rows($r);

        //get user id:
        if ($num == 1){
            $row = mysqli_fetch_array($r, MYSQLI_NUM);

            //Make the UPDATE query:
            $q = "UPDATE users SET senha='$np' WHERE id='$row[0]'";
            $r = mysqli_query($dbc, $q);

            //if everything was ok:
            if (mysqli_affected_rows($dbc) == 1 ){
                //Ok message comfirmation:
                echo "Thanks! You have update your password.";
            }else{
                echo "Your password could not br changed due to a system error"; 
            }

            //close connection to db:
            mysqli_close($dbc);
        }else{
            echo "The email and password do not match our records!";
        }
    }else{
        echo "ERROR! The following error(s) occurred: <br />";
        foreach($erros as $msg){
            echo $msg."<br />";
        }
    }
}

?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="author" content="Kauan Benitez" />
        <meta name="keywords" content="livros, literatura, ficção, não-ficção, best-sellers, clássicos, livraria">
        <meta name="description" content="Descubra o mundo dos livros na nossa livraria! Oferecemos uma ampla seleção de títulos em todas as categorias, desde best-sellers até clássicos. Compre online e receba em casa ou visite nossa loja física.">
        <meta charset="UTF-8">
        <meta name="robots" content="index, follow">
        <meta name="og:title" content="Título da página">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nova senha</title>
        <script src="https://kit.fontawesome.com/bfe65bea0c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./css/senha.css">
        <link rel="icon" href="./imagem/book-solid.svg">
    </head>
    <body>
        
        <div class="container">
           <div class="formulario">
           <h1>Trocar senha</h1>
                <form action="trocarsenha.php" class="form" method="post">

                <label class="label-input">
                    <i class="fa-regular fa-envelope icon-modify"></i>
                        <input type="text" class="email" name="email" maxlengt="50" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" placeholder="Email" />
                </label>
                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" class="senhas" name="pass" maxlengt="50" value="<?php if(isset($_POST['pass'])){echo $_POST['pass'];} ?>" placeholder="Senha atual" />
                </label>
                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>
                    <input type="password" class="senhas" name="pass1" maxlengt="50" value="<?php if(isset($_POST['pass1'])){echo $_POST['pass1'];} ?>" placeholder="Nova senha" />
                </label>
                <label class="label-input">
                    <i class="fa-solid fa-lock icon-modify"></i>   
                    <input type="password" class="senhas" name="pass2" maxlengt="50"value="<?php if(isset($_POST['pass2'])){echo $_POST['pass2'];} ?>" placeholder="Confirmar nova senha"  />
                </label>
                    <button type="submit" class="button" name="submit" value="Alterar senha" />Confirmar</button>
            </div>
        </div>


    </form>
    </body>
</html>