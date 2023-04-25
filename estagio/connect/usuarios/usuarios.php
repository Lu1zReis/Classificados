<?php
namespace conn;
class Usuario {
    private $id,$nome,$senha;
    // pegando os valores
    public function getId() {
        return $this->id;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getSenha() {
        return $this->senha;
    }

    // setando os valores
    public function setId($i) {
        $this->id = $i;
    }
    public function setNome($n) {
        $this->nome = $n;
    }
    public function setSenha($s) {
        $this->senha = $s;
    }
}
?>