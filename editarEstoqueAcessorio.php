<?php
session_start();
if (!isset($_SESSION['estoque_acessorios_id'])) {
    header('Location: editarEstoqueAcessorio.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Estoque_acessorio.php';

$estoque_acessorio = new $estoque_acessorio($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estoque_acessorios = new Estoque_acessorio($db);
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $estoque_acessorio->atualizar($id, $nome, $quantidade, $preco);
    header('location:telaLogin.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $cliente->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Estoque e Acessorios</title>
</head>

<body>

    <form method="POST" action="">
        <h1 id="titulo">Editar Estoque e Acessorios</h1>

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Digite o NOME" required>
        <br><br>
        <label for="quantidade">Quantidade:</label><br>
        <input type="number" id="quantidade" name="quantidade" placeholder="Digite a quantidade" required>
        <br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" id="preco" name="preco" placeholder="Digite o preco" required>
        <br><br>
        <input id="botao" type="submit" value="EDITAR">
        <input id="botao" type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>

</html>