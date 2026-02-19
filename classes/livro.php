<?php
class Livro {
    private $pdo;

    public function __construct($conexaoPdo){
        $this->pdo = $conexaoPdo;
    }

    public function cadastrar($titulo, $autor, $ano, $user_id) {
        $sql = "INSERT INTO livros (titulo, autor, ano, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$titulo, $autor, $ano, $user_id]);
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "<h3>Erro: Livro já cadastrado.</h3>";
            } else {
                echo "<h3>Erro ao cadastrar o livro: " . $e->getMessage() ."</h3>";
            }
            return false;
        }
    }

    public function listar($user_id) {
        $sql = "SELECT * FROM livros WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function excluir($id, $user_id) {
        $sql = "DELETE FROM livros WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute([$id, $user_id]);
            return true;
        } catch (PDOException $e) {
            echo "<h3>Erro ao excluir livro: " . $e->getMessage() . "</h3>";
            return false;
        }
    }

        public function marcarLido($id, $user_id) {
            $sql_check = "SELECT lido FROM livros WHERE id = ? AND user_id = ?";
            $stmt_check = $this->pdo->prepare($sql_check);
            $stmt_check->execute([$id, $user_id]);
            $livro = $stmt_check->fetch();
    
            if ($livro) {
                $novo_status = ($livro['lido'] == 1) ? 0 : 1;
                $sql_update = "UPDATE livros SET lido = ? WHERE id = ? AND user_id = ?";
                $stmt_update = $this->pdo->prepare($sql_update);
                try {
                    $stmt_update->execute([$novo_status, $id, $user_id]);
                    return true;
                } catch (PDOException $e) {
                    echo "<h3>Erro ao atualizar status: " . $e->getMessage() . "</h3>";
                    return false;
                }
            } else {
                echo "<h3>Livro não encontrado.</h3>";
                return false;
            }
        }

        public function buscar($termo, $user_id) {
            $sql = "SELECT * FROM livros WHERE (titulo LIKE ? OR autor LIKE ?) AND user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $termo = "%" . $termo . "%";
            $stmt->execute([$termo, $termo, $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function editar($id, $titulo, $autor, $genero, $resenha, $capa, $nota, $user_id) {
            $sql = "UPDATE livros SET titulo = ?, autor = ?, genero = ?, resenha = ?, capa = ?, nota = ? WHERE id = ? AND user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            try {
                $stmt->execute([$titulo, $autor, $genero, $resenha, $capa, $nota, $id, $user_id]);
                return true;
            } catch (PDOException $e) {
                echo "<h3>Erro ao atualizar livro: " . $e->getMessage() . "</h3>";
                return false;
            }
        }

        public function buscarPorId($id, $user_id) {
            $sql = "SELECT * FROM livros WHERE id = ? AND user_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id, $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}

?>