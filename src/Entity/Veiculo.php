<?php

namespace AgVeiculo\Entity;

use JsonSerializable;

class Veiculo implements JsonSerializable
{
    protected $id;
    protected $name;
    protected $imagePath;
    protected $descricao;
    protected $preco;
    protected $local;


    public function jsonSerialize () {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'imagePath' => $this->imagePath,
            'descricao' => $this->descricao,
            'preco' => $this->preco,
            'local' => $this->local,
        ];
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    public function __get($key)
    {
        return $this->$key;
    }
}
