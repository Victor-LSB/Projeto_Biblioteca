<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

echo "Bem-vindo, " . htmlspecialchars($_SESSION['usuario_nome']) . "!";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php';

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $resenha = $_POST['resenha'];
    $capa = $_POST['capa'];
    $nota = $_POST['nota'];


     $sql = "INSERT INTO livros (titulo, autor, genero, resenha, capa, nota) VALUES (?, ?, ?, ?, ?, ?)";
     $stmt = $pdo->prepare($sql);


     try {
         $stmt->execute([$titulo, $autor, $genero, $resenha, $capa, $nota]);
         echo "Livro cadastrado com sucesso!";
     } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<h3>Erro: Livro já cadastrado.</h3>";
        } else {
            echo "<h3>Erro ao cadastrar o livro: " . $e->getMessage() ."</h3>";
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
    <script src="javascript.js" defer></script>
</head>
<body>
    <form action="" method="post">
        <input type="text" id="titulo" name="titulo" placeholder="Titulo" required><br>
        <div id="sugestoes" style="border: 1px solid #ccc; display: none; position: absolute; background-color: white; z-index: 100;"></div>
        <input type="text" name="autor" id="autor" placeholder="Autor" required><br>
        <input type="text" id="genero" name="genero" placeholder="Genero" required><br>
        <textarea  name="resenha" placeholder="Resenha" required></textarea><br>
        <input type="hidden" id="capa_url" name="capa" required><br>
        <input type="number" name="nota" step="0.5" min="0" max="5" placeholder="Nota" required><br>
        <button type="submit">Cadastrar Livro</button>
    </form>
    <button onclick="window.location.href='livros.php'">Ver Livros</button>
    <button onclick="window.location.href='logout.php'">Sair</button>
</body>
</html>