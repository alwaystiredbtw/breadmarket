<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login']) && isset($_POST['senha'])) {
        $login = $_POST['login'];
        $senha = $_POST['senha'];


        $query = "SELECT * FROM usuarios WHERE email = '$login' AND senha = '$senha'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $usuario = mysqli_fetch_assoc($result);

            if ($usuario) {
                // Usuário encontrado no banco de dados, redirecione para a página inicial
                header('Location: paginaInicial.php');
                exit();
            } else {
                echo "Usuário ou senha incorretos";
            }
        } else {
            echo "Erro na consulta ao banco de dados: " . mysqli_error($conexao);
        }
    } else {
        echo "Preencha todos os campos";
    }
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bread Market</title>

    <link rel="stylesheet" href="./css/index.css">
</head>
<body>

    <header>
        <img src="./assets/logo-index.png" alt="Logo Bread Market" class="logo">
    </header>

    <form method="post">
        <h1>Login</h1>

        <div class="input-wrapper">
            <label for="login">E-mail</label>
            <input type="email" name="login" id="login">
        </div>

        <div class="input-wrapper">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
        </div>

        <button type="submit">Entrar</button>

        <a href="./cadastrar.php">Cadastrar-se</a>
    </form>
    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>