<?php

abstract class Expression{
    private static $keycount = 0;
    private $key;
    abstract function interpret(InterpreterContext $context);

    function getKey(){
        if(!isset($this->key)){
            self::$keycount++;
            $this->key=self::$keycount;
        }
        return $this->key;
    }

}

class LiteralExpression extends Expression{
    private $value;
    
    function __construct($value){
        $this->value = $value;
    }

    function interpret(InterpreterContext $context){
        $context->replace($this, $this->value);
    }

}

class InterpreterContext {
    private $expressionStore = array();

    function replace(Expression $exp, $value){
        $this->expressionStore[$exp->getKey()] = $value;
    }

    function lookup(Expression $exp){
        return $this->expressionStore[$exp->getKey()];
    }
}

class VariableExpression extends Expression{
    private $value;
    private $name;
    function __construct($name, $value = null){
        $this->name = $name;
        $this->value = $value;
    }

    function interpret(InterpreterContext $context){
        if(!is_null($this->value)){
            $context->replace($this, $this->value);
            $this->value = null;
        }
    }

    function setValue($value){
        $this->value = $value;
    }

    function getKey(){
        return $this->name;
    }
}

$context = new InterpreterContext();
$literal = new LiteralExpression('quatro');
$literal->interpret($context);
print $context->lookup($literal);
$var = new VariableExpression('input','cinco');
$var->interpret($context);
echo "\n";
print $context->lookup($var);

$var = new VariableExpression('input');
$var->interpret($context);
echo "\n";
print $context->lookup($var);

$var->setValue('oito');
$var->interpret($context);
echo "\n";
print $context->lookup($var);

