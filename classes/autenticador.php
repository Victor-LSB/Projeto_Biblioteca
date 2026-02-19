<?php


class Autenticador {
    private $pdo;

    public function __construct($conexaoPdo) {
        $this->pdo = $conexaoPdo;
    }

    public function logar($email, $senha){
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($senha, $usuario["senha"])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            return true;
        } else {
            return false;
    }
    }
}

?>