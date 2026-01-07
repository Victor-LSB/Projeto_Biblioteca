<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'conexao.php';

    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($senha_digitada, $usuario["senha"])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: cadastroLivro.php");
        echo "Login bem-sucedido! Bem-Vindo, " . htmlspecialchars($usuario['nome']) . "!";
        exit;
    } else {
        echo "Email ou senha incorretos.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
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