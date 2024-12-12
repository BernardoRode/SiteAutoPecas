<?php
include_once './config/config.php';
include_once './classes/Funcionario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $funcionario = new Funcionario($db);


    if ($funcionario->redefinirSenha($codigo, $nova_senha)) {
        $mensagem = 'Senha redefinida com sucesso. Você pode <a href="index.php">entrar</a> agora.';
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
</head>

<body>
    <form method="POST">
        <h1>Redefinir Senha</h1>

        <label for="codigo">Código de Verificação:</label>
        <input type="text" name="codigo" required placeholder="insira seu codigo de verificação"><br><br>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" required><br><br>
        <input type="submit" value="Redefinir Senha">
    </form>
    <p><?php echo $mensagem; ?></p>
</body>

</html>