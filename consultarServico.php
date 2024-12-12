<?php
session_start();
include_once './config/config.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
include_once './classes/Servico.php';
include_once './classes/Cliente.php';

$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

$servico = new Servicos($db);
$dados = $servico->ler();
$veiculo = new Veiculo($db);
$cliente = new Cliente($db);

$veiculos = $veiculo->obterVeiculos();
$clientes = $cliente->obterCliente();

$veiculoMap = [];
foreach ($veiculos as $v) {
    $veiculoMap[$v['id']] = $v['modelo'];
}

$clienteMap = [];
foreach ($clientes as $c) {
    $clienteMap[$c['id']] = $c['nome'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal</title>
</head>

<body>
    <h1>Gerenciar Usuários</h1>
    <a href="cadastrarServico.php">Cadastrar serviço</a>
    <a href="logout.php">Logout</a>
    <br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tipo de serviço:</th>
            <th>Data:</th>
            <th>Valor:</th>
            <th>Cliente:</th>
            <th>Veiculo:</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tipo_servico']; ?></td>
                <td><?php echo $row['data_servico']; ?></td>
                <td><?php echo $row['valor']; ?></td>
                <td><?php echo isset($clienteMap[$row['cliente_id']]) ? $clienteMap[$row['cliente_id']] : 'N/A'; ?></td>
                <td><?php echo isset($veiculoMap[$row['veiculo_id']]) ? $veiculoMap[$row['veiculo_id']] : 'N/A'; ?></td>
                <td>
                    <a href="editarCliente.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="portal.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
