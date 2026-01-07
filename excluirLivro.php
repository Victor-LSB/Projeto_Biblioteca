<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

require 'conexao.php';
$id = $_GET['id'];
$sql = "DELETE FROM livros WHERE id = ?";
$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([$id]);
    $_SESSION['feedback'] = [
        'tipo' => 'sucesso',
        'mensagem' => 'Livro excluído com sucesso!'
    ];
    header("Location: livros.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['feedback'] = [
        'tipo' => 'erro',
        'mensagem' => 'Erro ao excluir livro: ' . $e->getMessage()
    ];
}
header("Location: livros.php");
exit;