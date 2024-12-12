<?php
session_start();
include_once './config/config.php';
include_once './classes/Veiculo.php';
include_once './classes/Funcionario.php';
$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}
date_default_timezone_Set('America/Sao_Paulo');
if (isset($_SESSION['cliente_id'])) {
    header('location: telaLogin.php');
    exit();
}

if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $funcionarios->deletar($id);
    header('Location: consultarVeiculo.php');
    exit();
}

$clientes = new Veiculo($db);

if (isset($_POST['deletarVeiculo'])) {
    try {
        $id = $_GET['deletarVeiculo'];
        $clientes->deletar($id);
        header('location:index.php');
        exit();
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao excluir cliente: ' . $e->getMessage() . '</p>';
    }
}
$dados = $clientes->ler();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
</head>
<body>
<H1>Olá <?php echo $_SESSION['funcionario_nome']?></H1>
<h1>Veiculos</h1>
    <a href="cadastrarVeiculo.php">Cadastrar veiculo</a>
    <a href="logout.php">Logout</a>
<br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Ano</th>
            <th>ação</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['placa']; ?></td>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['marca']; ?></td>
                <td><?php echo $row['ano']; ?></td>
                <td>
                    <a href="editarCliente.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="consultarVeiculo.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button class="button print-button" onclick="window.print()">Imprimir Tabela</button>
</body>
</html>
