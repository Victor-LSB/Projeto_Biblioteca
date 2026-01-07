<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
require 'conexao.php';
require 'funcoes.php';

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

    

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $termo = "%" . $_GET['busca'] . "%";
    $sql = "SELECT * FROM livros WHERE (titulo LIKE ? OR autor LIKE ?) AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termo, $termo, $_SESSION['id']]);
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}else {
    $sql = "SELECT * FROM livros WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['id']]);
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (count($livros) == 0 && isset($_GET['busca'])) {
        echo "Nenhum livro encontrado para a busca: " . htmlspecialchars($_GET['busca']);
    } else {
        echo "<div class='livro-lista'>";
    foreach ($livros as $livro){
        if ($livro['lido'] == 1) {
            echo "<span class='tag-lido' style='color: green;'>LIDO</span>";
        }
    $estrelas = gerarEstrelas($livro['nota']);
    echo "<div class='livro-item'>";
    echo "<a href='verLivro.php?id=" . htmlspecialchars($livro['id']) . "'><img src='" . htmlspecialchars($livro['capa']) . "' alt='Capa do Livro'></a><br>";
    echo "<a href='verLivro.php?id=" . htmlspecialchars($livro['id']) . "'>" . htmlspecialchars($livro['titulo']) . "</a><br>";
    echo $livro['autor'] . "<br>";
    echo $livro['genero'] . "<br>";
    echo "Nota: " . $estrelas . " (" . $livro['nota'] . ")<br><br>";
    echo "<a href='excluirLivro.php?id=" . htmlspecialchars($livro['id']) . "'>Excluir Livro</a><br>";
    echo "<a href='editarLivro.php?id=" . htmlspecialchars($livro['id']) . "'> Editar Livro</a><br><br>";
    echo "</div>";
}
    echo "</div>";
    }
?>
    <button onclick="window.location.href='cadastroLivro.php'">Cadastrar Novo Livro</button>
    <button onclick="window.location.href='logout.php'">Sair</button>
</body>
</html>