<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}
require "../config/conexao.php";
require "../includes/funcoes.php";
require "../classes/livro.php";


$pdo = (new Conexao())->conectar();
$livroObj = new Livro($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <form action="livros.php" method="GET">
        <input type="text" name="busca" placeholder="Buscar livro por título ou autor">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    if (isset($_SESSION['feedback'])) {
        $cor = $_SESSION['feedback']['tipo'] == 'sucesso' ? 'green' : 'red';
        echo "<p style='color: $cor;'>" . htmlspecialchars($_SESSION['feedback']['mensagem']) . "</p>";
        unset($_SESSION['feedback']);
    }
    ?>

    <?php   

$busca = $_GET['busca'] ?? '';
if (!empty($busca)) {
    $livros = $livroObj->buscar($busca, $_SESSION['id']);
} else {
    $livros = $livroObj->listar($_SESSION['id']);
}
    


if (count($livros) == 0 && isset($_GET['busca'])) {
        echo "Nenhum livro encontrado para a busca: " . htmlspecialchars($_GET['busca']);
    } else {
        echo "<div class='livro-lista'>";
        foreach ($livros as $livro){
    
        $estrelas = gerarEstrelas($livro['nota']);
    
        echo "<div class='livro-item'>";
    
        if ($livro['lido'] == 1) {
        echo "<span class='tag-lido'>LIDO</span>";
        }

    echo "<a href='verLivro.php?id=" . htmlspecialchars($livro['id']) . "'><img src='" . htmlspecialchars($livro['capa']) . "' alt='Capa do Livro'></a><br>";
    echo "<a href='verLivro.php?id=" . htmlspecialchars($livro['id']) . "'>" . htmlspecialchars($livro['titulo']) . "</a><br>";
    echo "<span class='meta-info'>" . $livro['autor'] . "</span><br>";
    echo "<span class='meta-info'>" . $livro['genero'] . "</span><br>";
    echo "Nota: " . $estrelas . " (" . $livro['nota'] . ")<br><br>";
    echo "<a href='excluirLivro.php?id=" . htmlspecialchars($livro['id']) . "'>Excluir Livro</a><br>";
    echo "<a href='editarLivro.php?id=" . htmlspecialchars($livro['id']) . "'> Editar Livro</a><br><br>";
    echo "</div>";
}
    echo "</div>";
    }
?>
    <button onclick="window.location.href='cadastroLivro.php'">Cadastrar Novo Livro</button>
    <button onclick="window.location.href='../auth/logout.php'">Sair</button>
</body>
</html>