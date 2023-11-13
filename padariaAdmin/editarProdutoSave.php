<?php
require_once('../connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);

    if (isset($_POST['id_produto']) &&
        isset($_POST['titulo'])     &&
        isset($_POST['descricao'])  &&
        isset($_POST['preco']))
    {


        $id = $_POST['id_produto'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        $imagem_nome = '';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

            $nome_temporario = $_FILES['imagem']['tmp_name'];
            $nome_original = $_FILES['imagem']['name'];
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $imagem_nome = date('YmdHis') . '_' . uniqid() . '.' . $extensao;
            $caminho_imagem = '../arquivos/' . $imagem_nome;

            if (!move_uploaded_file($nome_temporario, $caminho_imagem)) {
                echo "Erro ao mover o arquivo para a pasta.";
                exit();
            }
        }

        else{
            echo "nenhum arquivo encontrado";
        }

        $sqlUpdate = "UPDATE produtos SET titulo='$titulo',
        descricao='$descricao',preco='$preco',imagem='$imagem_nome' where id=$id";
        $result = mysqli_query($conn, $sqlUpdate);
        if ($result) {
            header('Location:paginaInicial.php');
        } else {
            echo 'erro update';
        }
    }
}




