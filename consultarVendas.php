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

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

$vendas = new Venda($db);
$resultados = $vendas->obterTodasVendas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Vendas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Consulta de Vendas</h1>
    <table>
        <thead>
            <tr>
                <th>Data da Venda</th>
                <th>Valor Total</th>
                <th>Serviço</th>
                <th>Funcionário</th>
                <th>Peças</th>
                <th>Acessórios</th>
                <th>Veículo</th>
                <th>Promoção</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $venda): ?>
                <tr>
                    <td><?= htmlspecialchars($venda['data_venda']) ?></td>
                    <td><?= htmlspecialchars($venda['valor_total']) ?></td>
                    <td><?= htmlspecialchars($venda['tipo_servico']) ?></td>
                    <td><?= htmlspecialchars($venda['nome_funcionario']) ?></td>
                    <td><?= htmlspecialchars($venda['nome_pecas']) ?></td>
                    <td><?= htmlspecialchars($venda['nome_acessorios']) ?></td>
                    <td><?= htmlspecialchars($venda['modelo_veiculo']) ?></td>
                    <td><?= htmlspecialchars($venda['descricao_promocao']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <input type="button" value="VOLTAR" onclick="history.back()">
</body>
</html>