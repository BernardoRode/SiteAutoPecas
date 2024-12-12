<?php
include_once './config/config.php';
include_once './classes/Servico.php';
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
include_once './classes/Venda.php';
include_once './classes/Estoque_pecas.php';
include_once './classes/Estoque_acessorio.php';
include_once './classes/Promocao.php';
session_start();

// CRIA UMA VARIAVEL E CHAMA A FUNÇÃO DE obterVeiculos 
$veiculo = new Veiculo($db);
$vei = $veiculo->obterVeiculos();

$clientes = new Cliente($db);
$cli = $clientes->obterCliente();

$funcionarios = new Funcionario($db);
$func = $funcionarios->obterFuncionario();

$servico = new Servicos($db);
$serv = $servico->obterServico();

$Estoque_pecas = new Estoque_pecas($db);
$pec = $Estoque_pecas->obterPecas();

$acessorios = new estoque_acessorio($db);
$ace = $acessorios->obterAcessorio();

$promocao = new Promocao($db);
$promo = $promocao->obterPromocao();

$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Vendas = new Venda($db);

    $data_venda = $_POST['data_venda'] ?? null;
    $valor_total = $_POST['valor_total'] ?? null;
    $servico_id = $_POST['servico_id'] ?? null;
    $funcionario_id = $_SESSION['funcionario_id'] ?? null; // Obtido da sessão
    $pecas_id = $_POST['pecas_id'] ?? null;
    $acessorio_id = $_POST['acessorio_id'] ?? null;
    $veiculo_id = $_POST['veiculo_id'] ?? null;
    $promocao_id = $_POST['promocao_id'] ?? null;

    if ($data_venda && $valor_total && $servico_id && $funcionario_id && $pecas_id && $acessorio_id && $veiculo_id && $promocao_id) {
        $Vendas->cadastrarVendas($data_venda, $valor_total, $servico_id, $funcionario_id, $pecas_id, $acessorio_id, $veiculo_id, $promocao_id);
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
    <form method="POST">
        <h1>CADASTRO DE SERVIÇO</h1>

        <label for="data_venda">DATA DA VENDA</label><br>
        <input type="date" id="data_venda" name="data_venda" placeholder="Digite a data da venda" required>
        <br><br>

        <label for="valor_total">Valor total</label><br>
        <input type="number" id="valor_total" name="valor_total" placeholder="Digite o valor total da venda" required>
        <br><br>

        <label for="servico">Serviço:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O CLIENTE -->
        <select id="servico_id" name="servico_id" required>
            <option value="">-- Selecione o tipo de servico --</option>
            <?php foreach ($serv as $servico): ?>
                <option value="<?= $servico['id'] ?>">
                    <?= $servico['tipo_servico'] ?>
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

        <label for="pecas_id">Pecas:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O MODELO DO VEICULO -->
        <select id="pecas_id" name="pecas_id" required>
            <option value="">-- Selecione as peças --</option>
            <?php foreach ($pec as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['nome'] ?> <!-- Exibe o modelo do veículo -->
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>


        <label for="acessorio_id">Acessorios:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O MODELO DO VEICULO -->
        <select id="acessorio_id" name="acessorio_id" required>
            <option value="">-- Selecione os acessorios --</option>
            <?php foreach ($ace as $a): ?>
                <option value="<?= $a['id'] ?>">
                    <?= $a['nome'] ?> <!-- Exibe o modelo do veículo -->
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>


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

        <label for="promocao_id">Promoção:</label><br>
        <!-- CAIXA DE SELEÇÃO SELECT PARA SELECIONAR O MODELO DO VEICULO -->
        <select id="promocao_id" name="promocao_id" required>
            <option value="">-- Selecione a promocao --</option>
            <?php foreach ($promo as $pr): ?>
                <option value="<?= $pr['id'] ?>">
                    <?= $pr['descricao'] ?> <!-- Exibe o modelo do veículo -->
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" value="ADICIONAR">
        <input type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>

</html>