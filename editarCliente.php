<?php
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';

date_default_timezone_set('America/Sao_Paulo');
if (isset($_SESSION['cliente_id'])) {
    header('location: telaLogin.php');
    exit();
}

$veiculo = new Veiculo($db);
$vei = $veiculo->obterVeiculos();

$clientes = new Cliente($db);

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Busca os dados do cliente
        $cliente = $clientes->buscarCliente($id);
        if (!$cliente) {
            throw new Exception('Cliente não encontrado!');
        }
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao buscar cliente: ' . $e->getMessage() . '</p>';
        exit();
    }
}

// Processa o formulário de atualização
if (isset($_POST['atualizarCliente'])) {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cep = $_POST['cep'];
    $veiculo_id = $_POST['veiculo_id'];

    try {
        // Atualiza os dados do cliente no banco de dados
        $clientes->atualizarCliente($id, $cpf, $nome, $cep, $veiculo_id);
        header("Location: consultarCliente.php"); // Redireciona para a página de gerenciamento
        exit();
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao atualizar cliente: ' . $e->getMessage() . '</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>

<body>
    <h1>Editar Cliente</h1>
    <a href="portal.php">Voltar</a> <br><br>

    <form method="post">
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="<?php echo $cliente['cpf']; ?>" required><br><br>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $cliente['nome']; ?>" required><br><br>

        <label for="cep">CEP:</label>
        <input type="text" name="cep" id="cep" value="<?php echo $cliente['cep']; ?>" required><br><br>

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

        <button type="submit" name="atualizarCliente">Atualizar</button>
    </form>
</body>

</html>