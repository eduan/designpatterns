<?php

class ProductFacade{

    private $products = array();

    function __construct($file){
        $this->file = $file;
    }

    private function compile(){
        $file = file_get_contents($this->file);
        /** 
        *  do estrutural stuffs
        *  ex: read a file from csv
        */
    }

    function getProducts(){
        return $this->products;
    }

    function getProduct($id){
        return $this->products[$id];
    }
}
