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

    <div class="produtos">
        <? 
        $query = "SELECT * FROM produtos";

        $resultProdutos = mysqli_query($conn, $query);

        while($produtos = mysqli_fetch_assoc($resultProdutos)){
            echo '
            
        <div class="produto">
            <div class="left">
                <div class="top">
                    <img src="../arquivos/'. $produtos['imagem'] .'" alt="">
                    <h3>'. $produtos['titulo'] .'</h3>
                </div>
                <p class="preco">R$ '. $produtos['preco'] .' / Unidade</p>
            </div>
            <div class="right">
                <a href="./editarProduto.php?'. $produtos['id'] .'"><ion-icon name="pencil"></ion-icon></a>
                <a href="./excluirProduto.php?'. $produtos['id'] .'"><ion-icon name="trash"></ion-icon></a>
            </div>
        </div>
            ';
        }

        ?>


        <button onclick="window.location.href='./adicionarProduto.php'">Adicionar Produto <ion-icon name="add"></ion-icon></button>
    </div>


    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>