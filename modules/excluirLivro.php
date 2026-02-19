<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

require '../config/conexao.php';
require '../classes/livro.php';

$pdo = (new Conexao())->conectar();
$excluirLivro = new Livro($pdo);

$id = $_GET['id'];
$user_id = $_SESSION['id'];

if ($id) {
    $excluirLivro->excluir($id, $user_id);
}

header("Location: ../modules/livros.php");
exit;