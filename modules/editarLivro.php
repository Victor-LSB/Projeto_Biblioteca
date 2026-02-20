<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../auth/login.php");
    exit;
}
require '../config/conexao.php';
require '../classes/livro.php';


$pdo = (new Conexao())->conectar();
$objEditar = new Livro($pdo);
$id = $_GET['id'];
$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $id = $_GET['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $resenha = $_POST['resenha'];
    $capa = $_POST['capa'];
    $nota = $_POST['nota'];
    if($objEditar->editar($id, $titulo, $autor, $genero, $resenha, $capa, $nota, $user_id)){
        header("Location: ../modules/verLivro.php?sucesso=1");
        exit;
    } 

}

$livro = $objEditar->buscarPorId($id, $user_id);
if (!$livro) {
    echo "Livro não encontrado ou você não tem permissão para editá-lo.";
    header("Location: ../modules/livros.php");
    exit;
}
    
if (!isset($livro)) {
    echo "Livro não encontrado ou você não tem permissão para editá-lo.";
    header("Location: ../modules/livros.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="../public/js/javascript.js" defer></script>
</head>
<body>
    <form action="" method="post">
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" autocomplete="off" required><br>
        <div id="sugestoes" style="border: 1px solid #ccc; display: none; position: absolute; background-color: white; z-index: 100;"></div>
        <input name="autor" id="autor" placeholder="Autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required><br>
        <input type="text" id="genero" name="genero" placeholder="Genero" value="<?php echo htmlspecialchars($livro['genero']); ?>" required><br>
        <textarea name="resenha" placeholder="Resenha" required ><?php echo htmlspecialchars($livro['resenha']); ?></textarea><br>
        <input type="hidden" id="capa_url" name="capa" value="<?php echo htmlspecialchars($livro['capa']); ?>" required><br>
        <input type="number" name="nota" step="0.5" min="0" max="5" placeholder="Nota" value="<?php echo $livro['nota']; ?>" required><br>
        <button type="submit">Editar</button>
    </form>
    <button onclick="window.location.href='livros.php'">Voltar</button>
    
</body>
</html>