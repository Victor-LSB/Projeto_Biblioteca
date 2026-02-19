<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../config/conexao.php';
    include '../classes/autenticador.php';

    $conexao = new Conexao();
    $pdo = $conexao->conectar();
    $auth = new Autenticador($pdo);

    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    if ($auth->logar($email, $senha_digitada)) {
        header("Location: ../modules/livros.php");
        exit;
    } else {
        echo "<h3>Credenciais inválidas. Tente novamente.</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <button onclick="window.location.href='registro.php'">Registrar-se</button>
</body>
</html>