<?php
require_once('./connection.php');

session_start(); // Iniciando a sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nome']) && 
        isset($_POST['login']) && 
        isset($_POST['senha']) && 
        isset($_POST['confirmar-senha'])
    ) {
        $nome = $_POST['nome'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmar-senha'];

        if ($senha === $confirmarSenha) {
            // Inserir o novo usuário na tabela 'usuarios'
            $query = "INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES ('$nome', '$login', '$senha', 0)";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Obtém o ID do usuário recém-criado
                $id_usuario = mysqli_insert_id($conn);

                // Criar um carrinho associado a esse usuário
                $queryCarrinho = "INSERT INTO carrinhos (id_usuario) VALUES ('$id_usuario')";
                $resultCarrinho = mysqli_query($conn, $queryCarrinho);

                if ($resultCarrinho) {
                    // Obtém o ID do carrinho recém-criado
                    $id_carrinho = mysqli_insert_id($conn);

                    // Armazena os IDs na sessão
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['id_carrinho'] = $id_carrinho;

                    // Redireciona para a página inicial
                    header('Location: paginaInicial.php');
                    exit();
                } else {
                    echo "Erro ao criar carrinho: " . mysqli_error($conn);
                }
            } else {
                echo "Erro ao cadastrar usuário: " . mysqli_error($conn);
            }
        } else {
            echo "As senhas não coincidem";
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
        <h1>Cadastro</h1>

        <div class="input-wrapper">
            <label for="nome">Nome</label>
            <input type="name" name="nome" id="nome">
        </div>

        <div class="input-wrapper">
            <label for="login">E-mail</label>
            <input type="email" name="login" id="login">
        </div>

        <div class="input-wrapper">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
        </div>

        <div class="input-wrapper">
            <label for="confirmar-senha">Confirmar Senha</label>
            <input type="password" name="confirmar-senha" id="confirmar-senha">
        </div>

        <button type="submit">Cadastrar</button>

        <a href="./index.php">Já possuí login? Login aqui</a>
    </form>
    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>