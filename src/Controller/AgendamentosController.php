<?php

namespace AgVeiculo\Controller;

use AgVeiculo\Entity\Agendamento;
use AgVeiculo\Lib\JsonResponse;
use AgVeiculo\Repository\AgendamentosRepository;
use AgVeiculo\Lib\BadRequestException;
use Exception;
use PDOException;

class AgendamentosController
{
    private AgendamentosRepository $agendamentosRepository;

    public function __construct()
    {
        $this->agendamentosRepository = new AgendamentosRepository();
    }
    
    public function create($request)
    {
        try {
            $agendamento = new Agendamento();
            $agendamento->dataHora = $request->dataHora;
            $agendamento->veiculoId = $request->veiculoId;
            $agendamento = $this->agendamentosRepository->create($agendamento);
            return new JsonResponse(['mensagem' => 'Agendamento cadastrado com sucesso!'], 201);
        } catch (BadRequestException $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 400);
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }
}
