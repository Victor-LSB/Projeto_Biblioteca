

<?php

class Conexao {
    private $host = "localhost";
    private $db = "ead_projeto";
    private $user = "root";
    private $pass = "";

    public function conectar() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die ("Erro de conexão: ");
        }
    }

}



?>