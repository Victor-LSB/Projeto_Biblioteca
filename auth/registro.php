<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php';

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    $senha_segura = password_hash($_POST['senha'], PASSWORD_DEFAULT);

     $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
     $stmt = $pdo->prepare($sql);


     try {
         $stmt->execute([$nome, $email, $senha_segura]);
         echo "Usuário cadastrado com sucesso!";
     } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<h3>Erro: Email já cadastrado.</h3>";
        } else {
            echo "<h3>Erro ao cadastrar usuário: " . $e->getMessage() ."</h3>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post">
        <input type="text" name="nome" placeholder="Nome" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <button onclick="window.location.href='login.php'">Voltar ao Login</button>
</body>
</html>