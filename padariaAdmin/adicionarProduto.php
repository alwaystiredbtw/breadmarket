<?php
require_once('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['logout'])){
        $_SESSION['id_usuario'] = '';
        $_SESSION['id_carrinho'] = '';

        header('Location: ../index.php');

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

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/paginaInicial.css">
    <link rel="stylesheet" href="../css/paginaInicialPadariaAdmin.css">
    <link rel="stylesheet" href="../css/adicionarProduto.css">
</head>
<body>

    <header>
        <div class="left">
            <img src="../assets/logo.png" alt="Logo Bread Market" class="logo">
        </div>

        <div class="right">
            <form method="post" id="logOutForm">
                <input type="hidden" name="logout">
                <a onclick="document.getElementById('logOutForm').submit();"><ion-icon name="exit-sharp"></ion-icon></a>
            </form>
        </div>

    </header>

    <form method="post">

        <div class="input-wrapper">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" placeholder="Ex: Cueca Virada">
        </div>

        <div class="input-wrapper">
            <label for="preco">Preço por unidade</label>
            <input type="number" name="preco" id="preco" placeholder="Ex: R$ 3,40">
        </div>

        <div class="input-wrapper">
            <label for="descricao">Descrição do produto</label>
            <textarea name="descricao" id="descricao" placeholder="Ex: Cueca virada extremamente macia, feita por nossos melhores padeiros"></textarea>
        </div>

        <div class="input-wrapper">
            <label for="imagem">Imagem do produto</label>
            <input type="file" name="imagem" id="imagem" />
        </div>

        <button type="submit">Adicionar Produto <ion-icon name="add"></ion-icon></button>


    </form>


    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>