<?php
require_once('../connection.php');
//POST DO UPDATE

//GET

if(!empty($_GET['id_produto'])) {
    $id = $_GET['id_produto'];
    $sqlSelect = "SELECT * FROM produtos WHERE id='$id'";

    try {
        $result = mysqli_query($conn, $sqlSelect);
        mysqli_num_rows($result);
        if ($result->num_rows > 0) {
            while ($produtos = mysqli_fetch_assoc($result)) {
                $titulo = $produtos['titulo'];
                $descricao = $produtos['descricao'];
                $preco = $produtos['preco'];

            }
        }
    } catch (\mysql_xdevapi\Exception $ex) {
//        'query zuada';
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
            <img src="../assets/logo.png" alt="Logo Bread Market" class="logo" onclick="window.location.href='./paginaInicial.php'">
        </div>

        <div class="right">
            <form method="POST" id="logOutForm">
                <input type="hidden" name="logout">
                <a onclick="document.getElementById('logOutForm').submit();"><ion-icon name="exit-sharp"></ion-icon></a>
            </form>
        </div>

    </header>

    <form action="editarProdutoSave.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id_produto" value="<?php echo $id ?>">

        <div class="input-wrapper">
            <label for="titulo">Título do Produto</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo $titulo ?>" required>
        </div>

        <div class="input-wrapper">
            <label for="preco">Preço por unidade</label>
            <input type="number" name="preco" id="preco" value="<?php echo $preco ?>"  required>
        </div>

        <div class="input-wrapper">
            <label for="descricao">Descrição do produto</label>
            <textarea name="descricao" id="descricao" required><?php echo $descricao ?></textarea>
        </div>

        <div class="input-wrapper">
            <label for="imagem">Imagem do produto</label>
            <input type="file" name="imagem" id="imagem" required >
        </div>

        <button name="update" type="submit">Salvar Produto <ion-icon name="pencil" ></ion-icon></button>

    </form>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>