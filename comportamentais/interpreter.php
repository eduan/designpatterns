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

abstract class OperatorExpression extends Expression{
    protected $lOp;
    protected $rOp;
     
    function __construt(Expression $lOp, Expression $rOp){
        $this->lOp = $lOp;
        $this->rOp = $rOp;
    }
    
    function interpret(InterpreterContext $context){
        $this->lOp->interpret($context);
        $this->rOp->interpret($context);
        $resultL = $context->lookup($this->lOp);
        $resultR = $context->lookup($this->rOp);
        $this->doInterpret($context, $resultL, $resultR);
    }
    
     protected abstract function doInterpret(InterpreterContext $context, $resultL, $resultR);
     
}

class EqualsExpression extends OperatorExpression{
     protected function doInterpret(InterpreterContext $context, $resultL, $resultR){
         $context->replace($this, $resultL == $resultR);
     }
}

class OrExpression extends OperatorExpression{
     protected function doInterpret(InterpreterContext $context, $resultL, $resultR){
         $context->replace($this, $resultL || $resultR);
     }
}

class AndExpression extends OperatorExpression{
     protected function doInterpret(InterpreterContext $context, $resultL, $resultR){
         $context->replace($this, $resultL && $resultR);
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

