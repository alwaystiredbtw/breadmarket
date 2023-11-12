<?php
require_once('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['titulo']) && isset($_POST['preco']) && isset($_POST['descricao'])) {
        $titulo = $_POST['titulo'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];

        $imagem_nome = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

            $nome_temporario = $_FILES['imagem']['tmp_name'];
            $nome_original = $_FILES['imagem']['name'];
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $imagem_nome = '../arquivos/' . date('YmdHis') . '_' . uniqid() . '.' . $extensao;

            if (!move_uploaded_file($nome_temporario, $imagem_nome)) {
                echo "Erro ao mover o arquivo para a pasta.";
                exit();
            }
        }

        else{
            echo "nenhum arquivo encontrado";
        }

        $query = "INSERT INTO produtos (titulo, preco, descricao, imagem) VALUES ('$titulo', '$preco', '$descricao', '$imagem_nome')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Produto adicionado com sucesso!";
            // Pode redirecionar para outra página se desejado
            header('Location: ./paginaInicial.php');
        } else {
            echo "Erro ao adicionar o produto: " . mysqli_error($conn);
        }
    } else {
        echo "Preencha todos os campos obrigatórios";
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

    <form method="post" enctype="multipart/form-data">

        <div class="input-wrapper">
            <label for="titulo">Título do Produto</label>
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
            <input type="file" name="imagem" id="imagem">
        </div>

        <button type="submit">Adicionar Produto <ion-icon name="add"></ion-icon></button>


    </form>


    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>