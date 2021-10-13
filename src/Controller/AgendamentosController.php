<?php

namespace AgVeiculo\Controller;

use AgVeiculo\Entity\Agendamento;
use AgVeiculo\Lib\AuthorizationException;
use AgVeiculo\Lib\JsonResponse;
use AgVeiculo\Repository\AgendamentosRepository;
use AgVeiculo\Lib\BadRequestException;
use AgVeiculo\Repository\VeiculosRepository;
use AgVeiculo\Lib\Validator;
use Exception;
use PDOException;


class AgendamentosController
{
    private AgendamentosRepository $agendamentosRepository;
    private VeiculosRepository $veiculosRepository;

    public function __construct()
    {
        $this->agendamentosRepository = new AgendamentosRepository();
        $this->veiculosRepository = new VeiculosRepository();
    }

    public function index($request)
    {
        try {
            $agendamentos = $this->agendamentosRepository
                ->findAll(property_exists($request, "veiculoId") ? $request->veiculoId : null);

            $arrayVeiculosBuscados = [];
            if(property_exists($request,'getFull') && $request->getFull == true){
                foreach ($agendamentos as $key => $agendamento) {
                    if(isset($arrayVeiculosBuscados[$agendamento->veiculoId])) {
                        $agendamentos[$key]->veiculo = $arrayVeiculosBuscados[$agendamento->veiculoId];
                    } else {
                        $agendamentos[$key]->veiculo = $this->veiculosRepository->find($agendamento->veiculoId);
                        $arrayVeiculosBuscados[$agendamento->veiculoId] = $agendamentos[$key]->veiculo;
                    }
                }
            }

            return new JsonResponse(['agendamentos' => $agendamentos], 200);
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

            $agendamento = $this->validaAgendamentoCreate($request);

            $agendamentosExistentes = $this->agendamentosRepository->findAll($agendamento->veiculoId);

            foreach ($agendamentosExistentes as $key => $AgExistente) {
                if($AgExistente->dataHora == $agendamento->dataHora) {
                    throw new \Exception("Não é possível agendar neste horário, ja esta ocupado.", 1);
                }
            }

            $agendamento = $this->agendamentosRepository->create($agendamento);
            
            return new JsonResponse(['mensagem' => 'Agendamento cadastrado com sucesso!'], 201);
        } catch (BadRequestException $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 400);
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }

    private function validaAgendamentoCreate($request)
    {
        try {
            $validator = new Validator();
            $validator->setData($request);
            $validator->exists('nome');
            $validator->not('nome', 'null');
            $validator->not('nome', 'empty');
            $validator->exists('email');
            $validator->not('email', 'null');
            $validator->not('email', 'empty');
            $validator->exists('telefone');
            $validator->not('telefone', 'null');
            $validator->not('telefone', 'empty');

            $agendamento = new Agendamento();
            $agendamento->veiculoId = $request->veiculoId;
            $agendamento->name = $request->nome;
            $agendamento->email = $request->email;
            $data = new \Datetime($request->dataHora);
            $agendamento->dataHora = $data->format('Y-m-d H:i:s');
            $agendamento->telefone = $request->telefone;
            return $agendamento;
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage(), 1);
        }
    }
}
