<?php

namespace AgVeiculo\Entity;

use JsonSerializable;

class Agendamento implements JsonSerializable
{
    protected $id;
    protected $dataHora;
    protected $veiculoId;
    protected $veiculo;

    public function jsonSerialize () {
        return [
            'id' => $this->id,
            'dataHora' => $this->dataHora,
            'veiculoId' => $this->veiculoId,
            'veiculo' => $this->veiculo,
        ];
    }

    public function __set($key, $value)
    {
        if($key == 'veiculoid') {
            $this->veiculoId = $value;
        } elseif($key == 'datahora') {
            $this->dataHora = $value;
        } else {
            $this->$key = $value;
        }
    }

    public function __get($key)
    {
        return $this->$key;
    }
}
