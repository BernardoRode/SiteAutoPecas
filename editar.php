<?php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $usuario->atualizar($id, $nome, $sexo, $fone, $email);
    header('Location: portal.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f5;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, #0062cc, #00c6ff);
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            border-bottom: 2px solid #0047b3;
            position: relative;
        }

        header h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        header h3 {
            font-size: 1.5rem;
            margin-top: 10px;
            font-weight: 700;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 160px);
            padding: 20px;
        }

        form {
            margin: 30px auto;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .box h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #0062cc;
        }

        .box label {
            font-size: 1rem;
            margin-bottom: 5px;
            display: block;
        }

        .box input[type="text"],
        .box input[type="email"],
        .box input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .box input[type="radio"] {
            margin-right: 10px;
        }

        .box input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #0062cc;
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .box input[type="submit"]:hover {
            background-color: #009ec6;
        }

        .mensagem p {
            color: #f44336;
            text-align: center;
            margin-top: 10px;
            font-size: 1rem;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            margin-top: 50px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Portal de Notícias</h1>
        <h2>Editar Usuário</h2>
    </header>

    <div class="container">
        <div class="box">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>

                <label>Sexo:</label>
                <label for="masculino_editar">
                    <input type="radio" id="masculino_editar" name="sexo" value="M" <?php echo ($row['sexo'] === 'M') ? 'checked' : ''; ?> required> Masculino
                </label>
                <label for="feminino_editar">
                    <input type="radio" id="feminino_editar" name="sexo" value="F" <?php echo ($row['sexo'] === 'F') ? 'checked' : ''; ?> required> Feminino
                </label>

                <label for="fone">Fone:</label>
                <input type="tel" name="fone" value="<?php echo $row['fone']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

                <input type="submit" value="Atualizar">
            </form>
        </div>
    </div>

    <div class="footer">
        <p>2024 Portal de Notícias | Todos os direitos reservados</p>
    </div>
</body>
</html>
