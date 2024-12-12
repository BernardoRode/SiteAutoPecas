<?php 
include_once './config/config.php';
include_once './classes/Promocao.php';
include_once './classes/Funcionario.php';
session_start();

$funcionarios = new Funcionario($db);

if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

$promocao = new Promocao($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $data_inicio = $_POST['data_inicio'] ?? '';
    $data_final = $_POST['data_final'] ?? '';
    $imagem = $_POST['imagem'] ?? '';

    if (!empty($_FILES['imagem']['name'])) {
        $target_dir = "./img/";
        $imagem = $target_dir . basename($_FILES["imagem"]["name"]);

        // Verifica se o arquivo foi carregado corretamente
        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            echo "Erro ao fazer upload da imagem.";
            exit();
        }
    }

    // Chama a função para cadastrar a promoção
    if ($promocao->cadastrarPromocao($descricao, $preco, $data_inicio, $data_final, $imagem)) {
        echo "Promoção cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar a promoção.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Promoção</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h1>CADASTRAR PROMOÇÃO</h1>

        <label for="descricao">Descrição do desconto</label><br>
        <input type="text" id="descricao" name="descricao" placeholder="Digite o tipo de serviço" required>
        <br><br>

        <label for="preco">Total de desconto</label><br>
        <input type="number" id="preco" name="preco" placeholder="Total de desconto" required>
        <br><br>

        <label for="data_inicio">Início da promoção</label><br>
        <input type="date" id="data_inicio" name="data_inicio" required>
        <br><br>

        <label for="data_final">Final da promoção</label><br>
        <input type="date" id="data_final" name="data_final" required>
        <br><br>

        <label for="imagem">Imagem</label><br>
        <input type="file" id="imagem" name="imagem" required>
        <br><br>

        <input type="submit" value="ADICIONAR">
        <input type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>
</html>
