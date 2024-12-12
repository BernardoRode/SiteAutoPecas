<?php
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Veiculo.php';

session_start();


$clientes = new Cliente($db);

if (isset($_POST['deletarCliente'])) {
    try {
        $id = $_POST['deletarCliente'];
        $clientes->deletarCliente($id);
        header('location:index.php');
        exit();
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao excluir cliente: ' . $e->getMessage() . '</p>';
    }
}

$dados = $clientes->obterClientesDetalhados();

function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Clientes</title>
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
        .print-button {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1><?= saudacao(); ?>, bem-vindo ao Gerenciador de Clientes</h1>
    <a href="cadastrarCliente.php">Adicionar Cliente</a> <br>
    <a href="principal.php">HOME</a>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>Nome</th>
                <th>CEP</th>
                <th>Veículo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['id']) ?></td>
                    <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    <td><?= htmlspecialchars($cliente['cep']) ?></td>
                    <td><?= htmlspecialchars($cliente['modelo_veiculo']) ?></td>
                    <td>
                        <a href="editarCliente.php?id=<?= $cliente['id'] ?>">Editar</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                            <input type="hidden" name="deletarCliente" value="<?= $cliente['id'] ?>">
                            <button type="submit">Deletar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button class="button print-button" onclick="window.print()">Imprimir Tabela</button>
</body>

</html>