<?php
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['logout'])){
        $_SESSION['id_usuario'] = '';
        $_SESSION['id_carrinho'] = '';

        header('Location: ./index.php');

    }
}
?>