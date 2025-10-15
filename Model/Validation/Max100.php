<?php
namespace validation;
require_once 'ValidInterface.php';


class Max100 implements ValidInterface {

    private $name;
    private $value;

    public function __construct($name , $value) {
         $this->name = $name;
         $this->value = $value;

    }
    public function validate() {
        if (strlen($this->value) > 100) {
            return "$this->name debe tener menos de 100 caracteres.";
        }

        return '';
    }
}