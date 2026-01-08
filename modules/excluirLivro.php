<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

require '/config/conexao.php';
$id = $_GET['id'];
$user_id = $_SESSION['id'];
$sql = "DELETE FROM livros WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([$id, $user_id]);
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