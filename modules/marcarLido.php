<?php

session_start();
require '../config/conexao.php';
require '../classes/livro.php';


$pdo = (new Conexao())->conectar();
$objLido = new Livro($pdo);

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $id_livro = $_GET['id'];
    $user_id = $_SESSION['id'];


    $objLido->marcarComoLido($id_livro, $user_id);
    
}

header("Location: ../modules/verLivro.php?id=" . $id_livro);
exit;