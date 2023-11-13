<?php
require_once('./connection.php');

if(isset($_GET['id_carrinho'])){
    $id = $_GET['id_carrinho'];

    $query = "SELECT * FROM itens_carrinho WHERE id_carrinho = $id";
    $result = mysqli_query($conn, $query);

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
                                <img src="./arquivos/'. $rowProduto['imagem'] .'" alt="">
                                <p class="titulo">'. $rowProduto['titulo'] .'</p>
                            </div>

                            <div class="right">
                                <div class="results">
                                    <p class="quantidade">Quantidade: '. $quantidade .'</p>
                                    <p class="total">Total: R$ '. $total_formatado .'</p>
                                </div>

                                        
                                <form method="post" id="excluirDoCarrinho">
                                    <input type="hidden" name="excluir-do-carrinho" value="'. $id_produto .'">
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

            <!-- <div class="item-carrinho">

                <div class="left">
                    <img src="./assets/cueca-virada.png" alt="">
                    <p class="titulo">Cueca Virada</p>
                </div>

                <div class="right">
                    <div class="results">
                        <p class="quantidade">Quantidade: </p>
                        <p class="total">Total: </p>
                    </div>

                               
                    <form method="post" id="excluirDoCarrinho">
                        <input type="hidden" name="excluir-do-carrinho">
                        <a onclick="document.getElementById('excluirDoCarrinho').submit();"><ion-icon name="trash"></ion-icon></a>
                    </form>

                </div>

            </div> -->

            <button>Realizar Pagamento <span>$</span></button>
        </div>

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