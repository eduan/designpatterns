<?php


interface Celular{
    function getPreco();
    function acoplarPeca();
}

class CelularSimples implements Celular{

    public function getPreco(){
        return 100;
    }
    public function acoplarPeca(){
        return "Celular simples";
    }    
}

abstract class CelularDecorator implements Celular{

    protected $celular;

    public function __construct(Celular $celular){
        $this->celular = $celular;
    }

    public function getPreco(){
        return $this->celular->getPreco();
    }

    public function acoplarPeca(){
        return $this->celular->acoplarPeca();
    }

} 


class CelularCameraDecorator extends CelularDecorator{

    public function __construct(Celular $celular){
        parent::__construct($celular);
    }

    public function getPreco(){
        return parent::getPreco() + 50;
    }

    public function acoplarPeca(){
        return parent::acoplarPeca() . " + Camera adicionada";
    }

}



class CelularTelaDecorator extends CelularDecorator{

    public function __construct(Celular $celular){
        parent::__construct($celular);
    }

    public function getPreco(){
       return parent::getPreco() + 54.5;
    }

    public function acoplarPeca(){
        return parent::acoplarPeca() . " + Camera Tela 4\" adicionada";
    }

}


class CelularBateriaDecorator extends CelularDecorator{

    public function __construct(Celular $celular){
        parent::__construct($celular);
    }

    public function getPreco(){
        return parent::getPreco() + 30.5;
    }

    public function acoplarPeca(){
        return parent::acoplarPeca() . " + Bateria adicionada";
    }

}


$celular = new CelularTelaDecorator(new CelularCameraDecorator(new CelularBateriaDecorator(new CelularSimples())));
echo $celular->acoplarPeca();
echo $celular->getPreco();