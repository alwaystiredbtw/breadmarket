<?php
require_once('./connection.php');

?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bread Market</title>

    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/paginaInicial.css">
</head>
<body>

    <header>
        <div class="left">
            <img src="./assets/logo.png" alt="Logo Bread Market" class="logo">
        </div>

        <div class="right">
            <a href="./carrinho.php?<?$_SESSION['id_carrinho'] ?>"><ion-icon name="cart"></ion-icon></a>
            <a onclick="openExitModal()"><ion-icon name="ellipsis-vertical"></ion-icon></a>

        </div>
    </header>

    <div class="filters">
        <?php 
        $query = "SELECT * FROM produtos";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo'<a href="./paginaInicial.php?'.$row['id'].'" class="filter">'. $row['titulo'] .'</a>';
        }
        ?>

    </div>

    <div class="produtos">
    <?php 
        $query = "SELECT * FROM produtos";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo'
            <div class="produto">
                <img src="./arquivos/'. $row['imagem'] .'">
                <p class="titulo">'. $row['titulo'] .'</p>
                <p class="preco">R$ '. $row['preco'] .' /unidade</p>
            </div>
            ';
        }
        ?>


    </div>


    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>