<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php';

    $user_id = $_SESSION['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $resenha = $_POST['resenha'];
    $capa = $_POST['capa'];
    $nota = $_POST['nota'];
    $lido = $_POST['lido'];


     $sql = "INSERT INTO livros (user_id, titulo, autor, genero, resenha, capa, nota, lido) VALUES (?,?, ?, ?, ?, ?, ?, ?)";
     $stmt = $pdo->prepare($sql);


     try {
         $stmt->execute([$user_id, $titulo, $autor, $genero, $resenha, $capa, $nota, $lido]);
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
    <link rel="stylesheet" href="style.css">
    <script src="javascript.js" defer></script>
</head>
<body>
    <form action="" method="post">
        <input type="text" id="titulo" name="titulo" placeholder="Titulo" autocomplete="off" required><br>
        <div id="sugestoes" style="border: 1px solid #ccc; display: none; position: absolute; background-color: white; z-index: 100;"></div>
        <input type="text" name="autor" id="autor" placeholder="Autor" required><br>
        <input type="text" id="genero" name="genero" placeholder="Genero" required><br>
        <textarea  name="resenha" placeholder="Resenha" required></textarea><br>
        <input type="hidden" id="capa_url" name="capa" required><br>
        <input type="number" name="nota" step="0.5" min="0" max="5" placeholder="Nota" required><br>
        <p>Já leu este livro?</p>
        <label>
            <input type="radio" name="lido" value="1" > Sim
        </label>
        <label>
            <input type="radio" name="lido" value="0" checked> Ainda não
        </label><br>
        <button type="submit">Cadastrar Livro</button>
    </form>
    <button onclick="window.location.href='livros.php'">Ver Livros</button>
    <button onclick="window.location.href='logout.php'">Sair</button>
</body>
</html>