<?php 

error_reporting(0);
ini_set('display_errors', 0);


    include("conexão.php");

    //Agarrar valores do email e senha do formulário de login

    $login_email = mysqli_real_escape_string($dbc, trim($_POST['login_email']));
    $login_password = mysqli_real_escape_string($dbc, $_POST['login_senha']);

    //Criar a consulta e números de linhas retornadas a partir da consulta

    $query = mysqli_query($dbc, "SELECT * FROM users WHERE email='".$login_email."'");
    $numrows = mysqli_num_rows($query);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){


   //criar a condição para verificar se há  linha com aquele email

    if($numrows != 0){

    //agarrar o email e senha dessa linha retornada antes

        while($row = mysqli_fetch_array($query)){

            $dbemail = $row['email'];
            $dbpass = $row['senha'];
            $dbfirstname = $row['nome'];

        }

//criar condição para verificar email e senha são iguais à linha retornada


        if($login_email==$dbemail) { 
            if($login_password==$dbpass) {

                include ("Home.html");

            }else{

                echo "Your password is incorrect!";

            }


        }else{

            echo "Your email is incorrect!";

        }


    }else{

        echo "Are you not registered. Please register bellow";

    }

    }else{

        echo "Please Login...";

    }

?>
