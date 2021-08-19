<?php

namespace  AgVeiculo\Controller;

use Exception;
use PDOException;
use AgVeiculo\Lib\JsonResponse;
use AgVeiculos\Lib\AuthorizationException;
use AgVeiculo\Repository\VeiculosRepository;

class VeiculosController {
    private VeiculosRepository $veiculosRepository;

    public function __construct()
    {
        $this->veiculosRepository = new VeiculosRepository();
    }

    public function index($request)
    {
        try {

            $veiculosEncontrados = $this->veiculosRepository->findAll($request->veiculoId);

            return new JsonResponse(['movimentos' => $veiculosEncontrados], 200);

        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
            return new JsonResponse(['mensagem' => 'Ocorreu um erro no banco de dados! Favor tente novamente!'], 500);
        } catch (AuthorizationException $e){
            return new JsonResponse(['mensagem' => $e->getMessage()], 401);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }

    public function create($request)
    {
       try {
           if(!property_exists($request, 'name') || $request->name == null
           || $request->name = ''){
               throw new AuthorizationException("Por favor, informe o nome do veículo", 1);
           }

           
           $veiculo = $this->veiculosRepository->create($request);

       } catch (\Throwable $th) {
           //throw $th;
       }
    }
}