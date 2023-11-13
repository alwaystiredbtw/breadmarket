<?php
require_once('../connection.php');
if(!empty($_GET['id_produto'])) {
    $id = $_GET['id_produto'];

    $queryDelete = "DELETE FROM produtos WHERE id = ?";

    $stmt = mysqli_prepare($conn, $queryDelete);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        header('Location: paginaInicial.php');
        echo "Produto excluído";
    } else {
        echo "Erro ao excluir produto";
    }

    // Fechar o statement
    mysqli_stmt_close($stmt);

}