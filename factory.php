<?php

interface Tipo{
    function getTipo();
}

class TipoA implements Tipo{
    function getTipo(){
        return 'Tipo A';
    }
}

class TipoB implements Tipo{
    function getTipo(){
        return 'Tipo B';
    }
}

class TipoFactory{
    const TIPOA = "A";
    const TIPOB = "B";

    function makeTipo($tipo){
        switch ($tipo) {
            case self::TIPOA:
                return new TipoA();
            case self::TIPOB:
                return new TipoB();
            default:
                return null;
        }
    }
}

$tf = new TipoFactory();
echo $tf->makeTipo(TipoFactory::TIPOA)->getTipo();
echo $tf->makeTipo(TipoFactory::TIPOB)->getTipo();