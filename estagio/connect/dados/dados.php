<?php
namespace conn;
class Dados {
    private $id,$class,$texto,$data,$descr;
    // pegando os valores
    public function getId() {
        return $this->id;
    }
    public function getClass() {
        return $this->class;
    }
    public function getTexto() {
        return $this->texto;
    }
    public function getData() {
        return $this->data;
    }
    public function getDescr() {
        return $this->descr;
    }

    // setando os valores
    public function setId($i) {
        $this->id = $i;
    }
    public function setClass($c) {
        $this->class = $c;
    }
    public function setTexto($t) {
        $this->texto = $t;
    }
    public function setData($d) {
        $this->data = $d;
    }
    public function setDescr($d) {
        $this->descr = $d;
    }
}
?>