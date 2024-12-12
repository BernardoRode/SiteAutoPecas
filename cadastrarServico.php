<?php
include_once './config/config.php';
include_once './classes/Servico.php';
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
session_start();

// CRIA UMA VARIAVEL E CHAMA A FUNÇÃO DE obterVeiculos 
$veiculo = new Veiculo($db);
$vei = $veiculo->obterVeiculos();

$clientes = new Cliente($db);
$cli = $clientes->obterCliente();

$funcionarios = new Funcionario($db);
$func = $funcionarios->obterFuncionario();

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Servicos = new Servicos($db);

    // Coletando os dados do formulário
    $tipo_servico = $_POST['tipo_servico'] ?? null;
    $data_servico = $_POST['data_servico'] ?? null;
    $valor = $_POST['valor'] ?? null;
    $cliente_id = $_POST['cliente_id'] ?? null;
    $veiculo_id = $_POST['veiculo_id'] ?? null;

    // Validando se os dados foram preenchidos corretamente
    if ($tipo_servico && $data_servico && $valor && $cliente_id && $veiculo_id) {
        $Servicos->cadastrarServico($tipo_servico, $data_servico, $valor, $cliente_id, $veiculo_id);
        header('Location: principal.php');
        exit();
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Serviço</title>
</head>

<body>
    <form method="POST" action="cadastrarServico.php">
        <h1>CADASTRO DE SERVIÇO</h1>

        <label for="tipo_servico">TIPO DE SERVIÇO:</label><br>
        <input type="text" id="tipo_servico" name="tipo_servico" placeholder="Digite o tipo de serviço" required>
        <br><br>

        <label for="data_servico">DATA DE SERVIÇO:</label><br>
        <input type="date" id="data_servico" name="data_servico" placeholder="Digite a data do serviço" required>
        <br><br>

        <label for="valor">VALOR:</label><br>
        <input type="number" id="valor" name="valor" placeholder="Digite o valor" required>
        <br><br>

        <label for="cliente">Cliente:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O CLIENTE -->
        <select id="cliente_id" name="cliente_id" required>
            <option value="">-- Selecione o nome do cliente --</option>
            <?php foreach ($cli as $cliente): ?>
                <option value="<?= $cliente['id'] ?>">
                    <?= $cliente['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="funcionario">Funcionario:</label><br>
        <select id="funcionario_id" name="funcionario_id" required>
            <option value="">-- Selecione o nome do funcionario --</option>
            <?php foreach ($func as $f): ?>
                <option value="<?= $f['id'] ?>">
                    <?= $f['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="veiculo">Veículo:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O MODELO DO VEICULO -->
        <select id="veiculo_id" name="veiculo_id" required>
            <option value="">-- Selecione um veículo --</option>
            <?php foreach ($vei as $v): ?>
                <option value="<?= $v['id'] ?>">
                    <?= $v['modelo'] ?> <!-- Exibe o modelo do veículo -->
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" value="ADICIONAR">
        <input type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>

</html>