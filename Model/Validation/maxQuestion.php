<?php
namespace validation;
require_once 'ValidInterface.php';


class maxQuestion implements ValidInterface {

    private $name;
    private $value;

    public function __construct($name , $value) {
         $this->name = $name;
         $this->value = $value;

    }
    public function validate() {
        if (strlen($this->value) > 140) {
            return "Debe tener menos de 140 carácteres.";
        }

        return '';
    }
}