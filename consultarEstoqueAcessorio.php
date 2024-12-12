<?php
session_start();
include_once './config/config.php';
include_once './classes/Estoque_acessorio.php';
include_once './classes/usuario.php';
include_once './classes/Funcionario.php';
$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}
$usuario = new usuario($db);


$estoque_acessorios = new Estoque_acessorio($db);

if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $estoque_acessorios->deletar($id);
    header('Location: consultarEstoqueAcessorio.php');
    exit();
}

$dados = $estoque_acessorios->ler();

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
    <title>Portal</title>
    <link rel="stylesheet" href="css/cssConsultarEstoqueAcesorio.css">
</head>
<body>
<h1>Acessórios</h1>
    <a href="consultarEstoqueAcessorio.php">Consultar Estoque De Acessórios</a>
    <a href="logout.php">Logout</a>
<br>

<table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>quantidade</th>
            <th>preco</th>
            <th>ação</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['quantidade']; ?></td>
                <td><?php echo $row['preco']; ?></td>
                <td>
                    <a href="editarEstoqueAcessorio.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="consultarEstoqueAcessorio.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button class="button print-button" onclick="window.print()">Imprimir Tabela</button>
</body>
</html>
