<?php
session_start();
include_once './config/config.php';
include_once './classes/Promocao.php';
include_once './classes/Funcionario.php';

$funcionarios = new Funcionario($db);
if (!isset($_SESSION['funcionario_id'])) {
    header('Location: index.php');
    exit();
}

$promo = new Promocao($db);

// Processar exclusão de notícia
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $promo->deletar($id);
    header('Location: consultarPromocao.php');
    exit();
}

// Obter dados das notícias
$dados = $promo->ler();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="css/cssConsultarNoticia.css">
</head>

<body>
    <h1>Promoções</h1>
    <a href="logout.php">Logout</a>
    <br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descricao</th>
            <th>Total</th>
            <th>Inicio</th>
            <th>Fim</th>
            <th>Imagem</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td><?php echo $row['preco']; ?></td>
                <td><?php echo $row['data_inicio']; ?></td>
                <td><?php echo $row['data_final']; ?></td>
                <td>
                    <!-- Exibir a imagem utilizando a tag <img> -->
                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem da notícia" width="100">
                </td>
                <td>
                    <!-- Links de edição e exclusão -->
                    <a href="editarPromocao.php?id=<?php echo $row['id']; ?>">EDITAR</a>
                    <a href="consultarPromocao.php?deletar=<?php echo $row['id']; ?>">DELETAR</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <button class="button print-button" onclick="window.print()">Imprimir Tabela</button>
</body>

</html>