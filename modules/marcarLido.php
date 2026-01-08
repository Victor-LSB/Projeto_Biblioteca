<?php

session_start();
require '/config/conexao.php';

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $id_livro = $_GET['id'];
    $user_id = $_SESSION['id'];


    $sql_check = "SELECT lido FROM livros WHERE id = ? AND user_id = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$id_livro, $user_id]);
    $livro = $stmt_check->fetch();

    if ($livro) {
        $novo_status = ($livro['lido'] == 1) ? 0 : 1;
        $sql_update = "UPDATE livros SET lido = ? WHERE id = ? AND user_id = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$novo_status, $id_livro, $user_id]);
    }
    
}

header("Location: verLivro.php?id=" . $id_livro);
exit;