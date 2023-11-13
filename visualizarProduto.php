<?php
require_once('./connection.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT * FROM produtos WHERE id = $id";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);
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
    <link rel="stylesheet" href="./css/paginaInicial.css">
    <link rel="stylesheet" href="./css/visualizarProduto.css">
</head>
<body>

    <div class="modal-logout">
        <div class="card">
            <form action="./logout.php" method="post" id="logOutForm">
                <input type="hidden" name="logout">
                <a onclick="document.getElementById('logOutForm').submit();">Log Out<ion-icon name="exit-sharp"></ion-icon></a>
            </form>
        </div>
        <div class="bg-transparent" onclick="openExitModal()"></div>
    </div>

    <header>
        <div class="left">
            <img src="./assets/logo.png" alt="Logo Bread Market" class="logo">
        </div>

        <div class="right">
            <a href="./carrinho.php?<?$_SESSION['id_carrinho'] ?>"><ion-icon name="cart"></ion-icon></a>
            <a onclick="openExitModal()"><ion-icon name="ellipsis-vertical"></ion-icon></a>

        </div>
    </header>

    <main>
        <div class="left">
            <img src="./arquivos/<?php echo $row['imagem']; ?>">
            <p class="titulo"><?php echo $row['titulo']; ?></p>
            <p class="preco">R$ <?php echo $row['preco'] ?> /Unidade</p>
            <p class="descricao"><?php echo $row['descricao'] ?></p>
        </div>

        <form method="post" class="right">
            <div class="input-wrapper">
                <label for="quantidade">Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" placeholder="Ex: 10">
            </div>

            <div class="input-wrapper">
                <label>Total</label>
                <p class="result"></p>
            </div>

            <button type="submit">Adicionar ao Carrinho <ion-icon name="cart"></ion-icon></button>
        </form>
    </main>


    
    <script language="Javascript">
        function openExitModal(){
            document.querySelector('.modal-logout').classList.toggle('open');
        }

        const precoProduto = document.querySelector('.preco');
        const campoQuantidade = document.getElementById('quantidade');
        const campoTotal = document.querySelector('.result');

        // Remove o "R$ " e pega apenas o valor numérico do preço
        const precoNumerico = parseFloat(precoProduto.textContent.replace('R$ ', '').split(' /')[0]);

        // Adiciona um evento de escuta para detectar mudanças no campo de quantidade
        campoQuantidade.addEventListener('input', () => {
            // Calcula o total multiplicando o preço pelo valor da quantidade
            const total = precoNumerico * parseInt(campoQuantidade.value || 0);

            // Atualiza o elemento p.result com o valor total calculado
            campoTotal.textContent = `R$ ${total.toFixed(2)}`;
        });

    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>