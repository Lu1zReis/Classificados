<?php 

namespace conn;

class DadosDao {
    public function create(Dados $d) {
        $sql = 'INSERT INTO dados (class, texto, data, descricao) VALUES (?, ?, ?, ?)';

        $stmt = Conexão::getConn()->prepare($sql);

        $stmt->bindValue(1, $d->getClass());
        $stmt->bindValue(2, $d->getTexto());
        $stmt->bindValue(3, $d->getData());
        $stmt->bindValue(4, $d->getDescr());

        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

    public function read() {
        $sql = 'SELECT * FROM dados';

        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0):
            $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // enviando o array de forma invertida para mostrar o último cadastrado em primeiro
            return array_reverse($resultado);
        else:
            return [];
        endif;
    }

    public function update(Dados $d) {
        $sql = 'UPDATE dados SET texto = ?, data = ?, descricao = ?, class = ? WHERE id = ?';

        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->bindValue(1, $d->getTexto());
        $stmt->bindValue(2, $d->getData());
        $stmt->bindValue(3, $d->getDescr());
        $stmt->bindValue(4, $d->getClass());
        $stmt->bindValue(5, $d->getId());

        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

    public function delete($id) {
        $sql = 'DELETE FROM dados WHERE id = ?';
        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);
        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;
    }

    public function len () {
        $QUERY = "SELECT * FROM dados";
        $stmt = Conexão::getConn()->prepare($sql);
        $stmt->execute();

        return mysqli_num_rows($stmt);
    }

}
