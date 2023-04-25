<?php 
namespace conn;

class UsuarioDao {
    public function create(Usuario $u) {
        $sql = 'INSERT INTO users (nome, senha) VALUES (?, ?)';

        $stmt = Conexão::getConn()->prepare($sql);

        $stmt->bindValue(1, $u->getNome());
        $stmt->bindValue(2, $u->getSenha());

        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

    public function read() {
        $sql = 'SELECT * FROM users';

        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0):
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        else:
            return [];
        endif;
    }

    public function update(Usuario $u) {
        $sql = 'UPDATE users SET nome = ?, senha = ? WHERE id = ?';

        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->bindValue(1, $u->getNome());
        $stmt->bindValue(2, $u->getSenha());
        $stmt->bindValue(3, $u->getId());

        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

    public function delete($id) {
        $sql = 'DELETE FROM users WHERE id = ?';
        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);
        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

}
