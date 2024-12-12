<?php
include_once './config/config.php';
include_once './classes/Estoque_pecas.php';
include_once './classes/Funcionario.php';
session_start();

$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se a requisição for POST, então atualize a peça
    $Estoque_pecas = new Estoque_pecas($db);
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    
    // Chama o método de atualização da peça
    $Estoque_pecas->atualizar($id, $nome, $quantidade, $preco);
    header('Location: index.php'); // Redireciona para a página inicial após editar
    exit();
}

if (isset($_GET['id'])) {
    // Carrega a peça com base no ID fornecido na URL
    $Estoque_pecas = new Estoque_pecas($db);
    $id = $_GET['id'];
    $peca = $Estoque_pecas->lerPorId($id);
    if (!$peca) {
        // Se não encontrar a peça, redireciona para a página inicial
        header('Location: index.php');
        exit();
    }
} else {
    // Se não encontrar o ID na URL, redireciona para a página inicial
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Peça</title>
</head>
<body>
    <form method="POST" action="">
        <h1 id="titulo">Editar Peça</h1>

        <input type="hidden" name="id" value="<?php echo $peca['id']; ?>">

        <label for="nome">NOME:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($peca['nome']); ?>" required>
        <br><br>

        <label for="quantidade">Quantidade:</label><br>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($peca['quantidade']); ?>" required>
        <br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" id="preco" name="preco" value="<?php echo htmlspecialchars($peca['preco']); ?>" required>
        <br><br>

        <input id="botao" type="submit" value="ATUALIZAR">
        <input id="botao" type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>
</html>
