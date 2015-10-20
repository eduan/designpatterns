<?php

class Config{
	const TYPEA = "TypeA";
	const TYPEB = "TypeB";
	public static $currentConfig = "TypeA";
}

abstract class AbstractFactory{

	/**
	* @return AbstractFactory 
	*/
	public static function obtainFactory(){
		if(Config::$currentConfig == Config::TYPEA)
			return new FactoryTypeA();
		else
			return new FactoryTypeB();
	}
	
	/**
	* @return Foo 
	*/
	public abstract function createFoo(); 
}

class FactoryTypeA extends AbstractFactory{
	public function createFoo(){
		return new FooTypeA();
	}
}
class FactoryTypeB extends AbstractFactory{
	public function createFoo(){
		return new FooTypeB();
	}
}

abstract class Foo{
	public abstract function doStuff();
}

class FooTypeA extends Foo{
	public function doStuff(){
		return "FooTypeA";
	}
}
class FooTypeB extends Foo{
	public function doStuff(){
		return "FooTypeB";
	}
}

echo AbstractFactory::obtainFactory()->createFoo()->doStuff();
