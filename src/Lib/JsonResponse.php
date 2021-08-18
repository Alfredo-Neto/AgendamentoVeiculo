<?php

namespace AgVeiculo\Lib;

class JsonResponse
{
    public function __construct($data, $code)
    {   
        $this->data = $data;
        $this->code = $code;
    }

    public function process()
    {
        http_response_code($this->code);
        return json_encode([
            "mensagem" => $this->data
        ]);
    }
}