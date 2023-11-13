<?php
require_once('./connection.php');

if(isset($_GET['id_carrinho'])){
    $id = $_GET['id_carrinho'];

    $query = "SELECT * FROM itens_carrinho WHERE id_carrinho = $id";
    $result = mysqli_query($conn, $query);

}

if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['excluir-do-carrinho']){
    $id_produto_excluir = $_POST['excluir-do-carrinho'];

    $query = "DELETE FROM itens_carrinho WHERE id = $id_produto_excluir";
    if($result = mysqli_query($conn, $query)){
        echo "Produto removido com sucesso";
        header("Location: ./carrinho.php?id_carrinho=". $_SESSION['id_carrinho']);
    }
    else{
        echo "Um problema ocorreu ao tentar remover seu item do carrinho" .  mysqli_error($conn);
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
    <link rel="stylesheet" href="./css/paginaInicial.css">
    <link rel="stylesheet" href="./css/visualizarProduto.css">
    <link rel="stylesheet" href="./css/carrinho.css">
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
            <img src="./assets/logo.png" alt="Logo Bread Market" class="logo" onclick="window.location.href='paginaInicial.php'">
        </div>

        <div class="right">
            <a href="./carrinho.php?id_carrinho=<?php echo $_SESSION['id_carrinho'] ?>"><ion-icon name="cart"></ion-icon></a>
            <a onclick="openExitModal()"><ion-icon name="ellipsis-vertical"></ion-icon></a>
        </div>
    </header>

    <main>
        <div class="left">

            <div class="input-wrapper">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" placeholder="Ex: 00000-000">
            </div>
            
            <div class="input-wrapper">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" placeholder="Ex: Curitiba">
            </div>

            <div class="input-wrapper">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" placeholder="Ex: Prado Velho">
            </div>

            <div class="input-wrapper">
                <label for="rua">Rua</label>
                <input type="text" name="rua" id="rua" placeholder="Ex: Rua João das Flores">
            </div>

            <div class="input-wrapper">
                <label for="numero">Número</label>
                <input type="number" name="numero" id="numero" placeholder="Ex: 1234"> 
            </div>
        </div>

        <div class="right">

            <?php
            if($result->num_rows > 0){
                while($rowItemCarrinho = mysqli_fetch_assoc($result)){
                    $quantidade = $rowItemCarrinho['quantidade'];
                    
                    // Utiliza somente na hora de excluir do carrinho:
                    $id_produto_carrinho = $rowItemCarrinho['id'];

                    $id_produto = $rowItemCarrinho['id_produto'];


                    $query = "SELECT * FROM produtos WHERE id = $id_produto";

                    $resultProduto = mysqli_query($conn, $query);

                    while($rowProduto = mysqli_fetch_assoc($resultProduto)){
                        $preco = $rowProduto['preco'];

                        // Calcula o total multiplicando o preço pela quantidade
                        $total = $preco * $quantidade;
                        $total_formatado = number_format($total, 2, ',', '.');

                        echo 
                        '
                        <div class="item-carrinho">

                            <div class="left">
                                <img src="./arquivos/'.$rowProduto['imagem'] .'">
                                <p class="titulo">'.$rowProduto['titulo'] .'</p>
                            </div>

                            <div class="right">
                                <div class="results">
                                    <p class="quantidade">Quantidade:'. $quantidade .'</p>
                                    <p class="total">Total: R$'. $total_formatado .'</p>
                                </div>

                                        
                                <form method="post" id="excluirDoCarrinho">
                                    <input type="hidden" name="excluir-do-carrinho" value="'. $id_produto_carrinho .'">
                                    <a onclick="document.getElementById(`excluirDoCarrinho`).submit();"><ion-icon name="trash"></ion-icon></a>
                                </form>

                            </div>

                        </div>
                        '
                        ;
                    }


                }
            }

            else{
                echo 'Nenhum item no carrinho';
            }
            ?>

            <div class="input-wrapper">
                <label>Total</label>
                <div id="total-carrinho"></div>
            </div>

            <button>Realizar Pagamento <span>$</span></button>
        </div>

    </main>


    
    <script language="Javascript">
        function openExitModal(){
            document.querySelector('.modal-logout').classList.toggle('open');
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Pega todas as classes com o nome "total"
            const totalElements = document.querySelectorAll(".total");

            // Inicializa a variável para armazenar a soma
            let somaTotal = 0;

            // Itera sobre cada elemento com a classe "total"
            totalElements.forEach(function (element) {
                // Obtém o conteúdo do elemento
                const conteudo = element.textContent;

                // Usa uma expressão regular para extrair apenas os valores numéricos
                const valoresNumericos = conteudo.match(/(\d|,|\.)/g);

                // Se houver valores numéricos, converte para número e adiciona à somaTotal
                if (valoresNumericos) {
                    const valorNumerico = parseFloat(valoresNumericos.join("").replace(",", "."));
                    somaTotal += valorNumerico;
                }
            });

            // Formata a somaTotal como R$ e exibe na div com id "total-carrinho"
            const totalCarrinhoElement = document.getElementById("total-carrinho");
            totalCarrinhoElement.textContent = "R$" + somaTotal.toFixed(2).replace(".", ",");

            // Pode ser útil também logar a soma no console para debug
            console.log("Soma Total:", somaTotal);
        });

    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>