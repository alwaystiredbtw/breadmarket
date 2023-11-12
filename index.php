<?php
require_once('./connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login']) && isset($_POST['senha'])) {
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $query = "SELECT * FROM usuarios WHERE email = '$login' AND senha = '$senha'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $usuario = mysqli_fetch_assoc($result);

            if ($usuario) {
                // Usuário encontrado no banco de dados, armazenar na sessão
                $_SESSION['id_usuario'] = $usuario['id']; // Armazena o ID do usuário na sessão

                // Buscar o id_carrinho associado a esse usuário
                $id_usuario = $usuario['id'];
                $queryCarrinho = "SELECT id FROM carrinhos WHERE id_usuario = $id_usuario";
                $resultCarrinho = mysqli_query($conn, $queryCarrinho);

                if ($resultCarrinho) {
                    $carrinho = mysqli_fetch_assoc($resultCarrinho);

                    if ($carrinho) {
                        $_SESSION['id_carrinho'] = $carrinho['id']; // Armazena o ID do carrinho na sessão

                        if($usuario['tipo_usuario'] == 0){
                            // Redireciona para a página inicial
                            header('Location: paginaInicial.php');
                            exit();

                        }
                        else if($usuario['tipo_usuario'] == 1){
                            // Redireciona para a página inicial do Admin
                            header('Location: ./padariaAdmin/paginaInicial.php');
                            exit();
                        }

                    } 
                    else {
                        echo "Erro: Carrinho não encontrado para este usuário";
                    }
                } 
                else {
                    echo "Erro na consulta do carrinho: " . mysqli_error($conn);
                }
            } 
            else {
                echo "Usuário ou senha incorretos";
            }
        } 
        else {
            echo "Erro na consulta ao banco de dados: " . mysqli_error($conn);
        }
    } 
    else {
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