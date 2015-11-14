<?php
/**
 * Created by PhpStorm.
 * User: eduan
 * Date: 13/11/15
 * Time: 21:44
 */

interface IParseStrategy{
    public function parse($object);
}

class ParseToXml implements IParseStrategy{
    public function parse($object){
        return "<object>
                    <a>{$object->a}</a>
                    <b>{$object->b}</b>
                    <c>{$object->c}</c>
                </object>";
    }
}

class ParseToJson implements IParseStrategy{
    public function parse($object){
        return json_encode($object);
    }
}

class ParseToArray implements IParseStrategy{
    public function parse($object){
        return (array) $object;
    }
}

class ObjectToParse{

    public $a = 'data-a';
    public $b = 'data-b';
    public $c = 'data-c';

    private $_parser;
    
    public function __construct(IParseStrategy $parser){
        $this->setParser($parser);
    }

    public function parse(){
        return $this->_parser->parse($this);
    }

    public function setParser(IParseStrategy $parser) {
        $this->_parser = $parser;
    }

}

$o = new ObjectToParse(new ParseToArray());

var_dump($o->parse());

$o->setParser(new ParseToJson());
var_dump($o->parse());

$o->setParser(new ParseToXml());
var_dump($o->parse());