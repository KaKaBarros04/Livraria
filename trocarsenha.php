<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('conexão.php');

    $erros = array();

    // Verifica se o email foi preenchido
    if (empty($_POST['email'])) {
        $erros[] = 'Você esqueceu de inserir seu e-mail!';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
    }

    // Verifica se a senha atual foi preenchida
    if (empty($_POST['pass'])) {
        $erros[] = 'Você esqueceu de inserir sua senha atual!';
    } else {
        $p = trim($_POST['pass']);
    }

    // Verifica se a nova senha foi preenchida e se coincide com a confirmação
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $erros[] = 'A nova senha e a confirmação não coincidem!';
        } else {
            $np = password_hash(trim($_POST['pass1']), PASSWORD_DEFAULT); // Hash seguro
        }
    } else {
        $erros[] = 'Você esqueceu de inserir a nova senha!';
    }

    // Se não houver erros
    if (empty($erros)) {
        // Verifica se o e-mail existe e obtém a senha atual
        $q = "SELECT id, senha FROM users WHERE email = ?";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, "s", $e);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $user_id, $hashed_password);
            mysqli_stmt_fetch($stmt);

            // Verifica se a senha atual está correta
            if (password_verify($p, $hashed_password)) {
                // Atualiza a senha no banco de dados
                $update_q = "UPDATE users SET senha = ? WHERE id = ?";
                $update_stmt = mysqli_prepare($dbc, $update_q);
                mysqli_stmt_bind_param($update_stmt, "si", $np, $user_id);
                mysqli_stmt_execute($update_stmt);

                if (mysqli_stmt_affected_rows($update_stmt) == 1) {
                    echo "Senha alterada com sucesso!";
                } else {
                    echo "Erro ao atualizar a senha. Tente novamente.";
                }
            } else {
                echo "Senha atual incorreta!";
            }
        } else {
            echo "E-mail não encontrado!";
        }

        // Fecha conexões
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
    } else {
        // Exibe os erros
        echo "Erro(s) encontrado(s): <br>";
        foreach ($erros as $msg) {
            echo "- $msg <br>";
        }
    }
}
?>
