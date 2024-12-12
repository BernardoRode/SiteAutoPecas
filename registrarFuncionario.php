<?php
include_once("./config/config.php");
include_once("./classes/Funcionario.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $funcionario = new Funcionario($db);
    $nome = $_POST['nome'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $funcionario->cadastrar($nome, $email, $senha);
    header('location: telaLogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./registrarUsuario.css">
    <title>Cadastro Funcionario</title>
</head>

<body>
    <form method="POST" action="">
        <h1>CADASTRAR FUNCIONÁRIO</h1>

        <label for="nome">NOME:</label><br>
        <input type="text" id="nome" name="nome" required>
        <br><br>
        <label for="email">EMAIL:</label><br>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="senha">SENHA:</label>
        <input type="password" id="senha" name="senha" required> 
        <br><br>
        <input type="submit" value="ADICIONAR">
        <input type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>

</html>