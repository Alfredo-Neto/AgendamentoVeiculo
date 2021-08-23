<?php

namespace AgVeiculo\Lib;

use Exception;

class Validator
{
    private Object $data;

    public function setData(Object $data) {
        $this->data = $data;
    }

    public function exists ($propertyName, $errorMessage = null){
        if($errorMessage == null) $errorMessage = "Please inform field $propertyName";
        if(!property_exists($this->data, $propertyName)){
            throw new ValidationException($errorMessage);
        }
    }

    public function not ($propertyName, $notValue, $errorMessage = null) {  
        if($errorMessage == null) $errorMessage = "Field $propertyName is $notValue";
        if ($notValue == 'empty') $notValue = '';
        if ($notValue == 'null') $notValue = null;

        if($this->data->$propertyName == $notValue) {
            throw new ValidationException($errorMessage);
        }
    }
}
