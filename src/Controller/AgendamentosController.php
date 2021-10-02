<?php

namespace AgVeiculo\Controller;

use AgVeiculo\Entity\Agendamento;
use AgVeiculo\Lib\AuthorizationException;
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

    public function index($request)
    {
        try {
            $veiculosAgendados = $this->agendamentosRepository
                ->findAll(property_exists($request, "veiculoId") ? $request->veiculoId : null);
            return new JsonResponse(['veiculos' => $veiculosAgendados], 200);
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
            return new JsonResponse(['mensagem' => 'Ocorreu um erro no banco de dados! Favor tente novamente!'], 500);
        } catch (AuthorizationException $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 401);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
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
