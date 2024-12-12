<?php
include_once './config/config.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
session_start();
$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculos = new Veiculo($db);
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];

    if ($veiculos->cadastrar($placa, $modelo, $marca, $ano)) {
        echo "<script>
        alert('Veículo cadastrado com sucesso!'); //cria um alert que aparece na tela;
        history.back(); // Retorna à página anterior     </script>";
        exit();
    } else {
        echo "<script>
        alert('Erro ao cadastrar o veiculo!') //cria um alert que aparece na tela ;
        history.back(); // Retorna à página anterior;
        </script>";
        exit();
    }
    exit();
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de veiculos</title>
</head>

<body>
    <form method="POST">
        <h1 id="titulo">CADASTRO DE VEICULO</h1>

        <label for="placa">Placa:</label><br>
        <input type="placa" id="placa" name="placa" placeholder="Digite a placa" required>
        <br><br>

        <label for="modelo">Modelo:</label><br>
        <input type="modelo" id="modelo" name="modelo" placeholder="Digite o modelo" required oninput="mascaraCPF(this)">
        <br><br>

        <label for="marca">Marca:</label><br>
        <input type="marca" id="marca" name="marca" placeholder="Digite a marca" required>
        <br><br>
        <label for="ano">Ano:</label><br>
        <input type="ano" id="ano" name="ano" placeholder="Digite o ano" required>
        <br><br>
        <input id="botao" type="submit" value="ADICIONAR"><br>
        <button id="botao"><a href="principal.php">VOLTAR</a></button>
    </form>
</body>

</html>