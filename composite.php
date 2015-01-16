<?php

abstract class Unidade{
    abstract function forcaAtaque();
    abstract function addUnidade($unidade);
    abstract function removeUnidade($unidade);
}

class UnidadeComposite extends Unidade{
    private $unidade = array();
    
    function forcaAtaque(){
        $forca = 0;
        foreach ($this->unidade as $vUnidade) {
            $forca += $vUnidade->forcaAtaque();
        }
        return $forca;
    }

    function addUnidade($unidade){
        array_push($this->unidade, $unidade);
    }

    function removeUnidade($unidade){
        foreach ($this->unidade as $k => $vUnidade) {
            if($vUnidade == $unidade){
                unset($this->unidade[$k]);
            }
        }
    }
}

class UnidadeFolha extends UnidadeComposite{
   function addUnidade($unidade){
        throw new Exception("Este elemento não é componível", 1);
    }

    function removeUnidade($unidade){
        throw new Exception("Não há componentes neste elemento", 1);
    }
}

class Guerreiro extends UnidadeFolha{
    function forcaAtaque(){
        return 1;
    }

}

class Canhao extends UnidadeFolha{
    function forcaAtaque(){
        return 4;
    }

}

class Exercito extends UnidadeComposite{}


$e = new Exercito();
$e->addUnidade(new Guerreiro());
$e->addUnidade(new Guerreiro());
$e->addUnidade(new Canhao());
echo 'Forca Exercito 1: ' . $e->forcaAtaque() . "\n";

$e->removeUnidade(new Canhao());
echo 'Forca Exercito 2: ' . $e->forcaAtaque() . "\n";

$be = new Exercito();
$be->addUnidade($e);
$be->addUnidade(new Guerreiro());
$be->addUnidade(new Canhao());
$be->addUnidade(new Canhao());
echo 'Forca Exercito 3: ' . $be->forcaAtaque() . "\n";

$g = new Guerreiro();
$g->addUnidade(new Canhao());