<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
require "conexao.php";
require "funcoes.php";

$id = $_GET['id'];
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$livro = $stmt->fetch(PDO::FETCH_ASSOC);

$urlCapaOriginal = $livro['capa'];
$urlCapaQualidade = str_replace('zoom=1', 'zoom=3', $urlCapaOriginal);
$urlCapaQualidade = str_replace('http://', 'https://', $urlCapaQualidade);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Detalhes do Livro</h1>

    <div class="container">
        <div class="capa-livro">
            <img src="<?php echo htmlspecialchars($urlCapaQualidade); ?>" alt="Capa do Livro">
        </div>

        <div class="info-livro">
            <h2><?php echo htmlspecialchars($livro['titulo']); ?></h2>
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($livro['autor']); ?></p>
            <p><strong>Gênero:</strong> <?php echo htmlspecialchars($livro['genero']); ?></p>
            <p><strong>Nota:</strong>
                <?php 
                    $estrelas = gerarEstrelas($livro['nota']);
                    echo $estrelas . " (" . $livro['nota'] . ")"; 
                ?>
            </p>
            <h3>Resenha:</h3>
            <p><?php echo htmlspecialchars($livro['resenha']); ?></p>

            <a href="livros.php">Voltar para a estante</a>
        </div>
    </div>

</body>
</html>