<?php
// Configurações de banco de dados
$hostname = "localhost";
$username = "root";
$password1 = "";
$dbname = "dados_livraria";

// Conexão com o banco de dados utilizando mysqli
$dbc = mysqli_connect($hostname, $username, $password1, $dbname);

// Verificar se a conexão foi bem-sucedida
if (!$dbc) {
    // Caso haja falha na conexão, exibe um erro e termina a execução
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Definir a codificação para UTF-8 para garantir que caracteres especiais sejam tratados corretamente
mysqli_set_charset($dbc, "utf8");

echo "";
?>
