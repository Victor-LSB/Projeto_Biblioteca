<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
require "conexao.php";
require "funcoes.php";

$id = $_GET['id'];
$sql = "SELECT * FROM livros WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id, $_SESSION['id']]);
$livro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$livro) {
    echo "Livro não encontrado ou você não tem permissão para visualizá-lo.";
    header("Location: livros.php");
    exit;
}

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
            <div class="resenha-box">
                <?php echo htmlspecialchars($livro['resenha']); ?>
            </div>
            <div class="botoes-acao">
                <?php
                if ($livro['lido'] == 1) {
                    echo "<a href='marcarLido.php?id=" . $livro['id'] . "' class='btn-desmarcar'>✓ Lido (Desmarcar)</a>";
                } else {
                    echo "<a href='marcarLido.php?id=" . $livro['id'] . "' class='btn-lido'>Marcar como Lido</a>";
                }
                ?>

                <a href="livros.php" class="btn-voltar">← Voltar para a estante</a>
            </div>
        </div>
    </div>

</body>
</html>