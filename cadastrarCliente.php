<?php
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
session_start();
$funcionarios = new Funcionario($db);

// CRIA UMA VARIAVEL E CHAMA A FUNÇÃO DE obterVeiculos 
$veiculo = new Veiculo($db);
$veiculo = $veiculo->obterVeiculos(); 

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientes = new Cliente($db);
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $veiculo_id = $_POST['veiculo_id'];
    $clientes->cadastrarCliente($cpf, $nome, $cep, $veiculo_id);
    header('location:principal.php');
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/cadastrarCliente.css">
    <title>Cadastro de cliente</title>
</head>

<body>
    <form method="POST" action="cadastrarCliente.php">
        <h1 id="titulo">Cadastro do Cliente</h1>

        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF" required oninput="mascaraCPF(this)">
        <br><br>
        <label for="nome">NOME:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Digite o NOME" required>
        <br><br>
        <label for="cep">CEP:</label><br>
        <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required>
        <br><br>                    
        <label for="veiculo">Veículo:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O MODELO DO VEICULO -->
        <select id="veiculo_id" name="veiculo_id" required>
            <option value="">-- Selecione um veículo --</option>
            <?php foreach ($veiculo as $v): ?>
                <option value="<?= $v['id'] ?>">
                    <?= $v['modelo'] ?>  <!-- Exibe o modelo do veículo -->
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input id="botao" type="submit" value="ADICIONAR">
        <input id="botao" type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>

</html>
