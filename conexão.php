<?php 
 
 $hostname = "localhost";
 $username = "root";
 $password1 = "";
 $dbname = "dados_livraria";

//a conexão com o mysqli

$dbc = mysqli_connect($hostname, $username, $password1, $dbname) OR die("Não pode conectar a base de dados".mysqli_connect_error());
 
//definir codificação

mysqli_set_charset($dbc, "utf8");



 ?>