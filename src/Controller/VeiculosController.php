<?php

namespace  AgVeiculo\Controller;

use Exception;
use PDOException;
use AgVeiculo\Lib\Validator;
use AgVeiculo\Entity\Veiculo;
use AgVeiculo\Lib\JsonResponse;
use AgVeiculo\Lib\BadRequestException;
use AgVeiculo\Lib\AuthorizationException;
use AgVeiculo\Repository\VeiculosRepository;

class VeiculosController
{
    private VeiculosRepository $veiculosRepository;

    public function __construct()
    {
        $this->veiculosRepository = new VeiculosRepository();
    }

    public function index($request)
    {
        try {

            $veiculosEncontrados = $this->veiculosRepository
                ->findAll(property_exists($request, 'veiculoId') ? $request->veiculoId : null);

            return new JsonResponse(['veiculos' => $veiculosEncontrados], 200);
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
            $veiculo = $this->validaVeiculoCreate($request);
            $this->veiculosRepository->create($veiculo);
            return new JsonResponse(['mensagem' => 'Veiculo inserido no banco com sucesso!'], 201);
        } catch (BadRequestException $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 400);
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
            return new JsonResponse(['mensagem' => 'Ocorreu um erro no banco de dados! Favor tente novamente!'], 500);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }

    public function update($request)
    {
        try {
            $veiculo = $this->validaVeiculoCreate($request);

            $this->veiculosRepository->update($veiculo);
            return new JsonResponse(['mensagem' => 'veiculo atualizado com sucesso!'], 200);
        } catch (BadRequestException $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 400);
        } catch (PDOException $e) {
            file_put_contents('log.txt', $e->getMessage() . '\n', FILE_APPEND);
            return new JsonResponse(['mensagem' => 'Ocorreu um erro no banco de dados! Favor tente novamente!'], 500);
        } catch (Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }

    public function updateImage($request)
    {
        try {

            $veiculo = $this->validaVeiculoId($request);

            $uploaddir = 'uploads/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
            
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                throw new Exception("Possível ataque de upload de arquivo!");
            }
            
            echo 'Aqui está mais informações de debug:';
            print_r($_FILES);

            $veiculo = $this->validaVeiculoId($request);

            $veiculo->imagePath = $uploadfile;

            $this->veiculosRepository->storeImagePath($veiculo);

            return new JsonResponse(['mensagem' => var_export($request, true)], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem' => $e->getMessage()], 500);
        }
    }

    private function validaVeiculoId($request)
    {
        try {
            $validator = new Validator();
            $validator->setData($request);
            $validator->exists('veiculoId');
            $validator->not('veiculoId', 'null');
            $validator->not('veiculoId', 'empty');

            $veiculo = new Veiculo();
            $veiculo->id = $request->veiculoId;
            return $veiculo;
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage(), 1);
        }
    }

    private function validaVeiculoCreate($request)
    {
        try {
            $validator = new Validator();
            $validator->setData($request);
            $validator->exists('veiculoNome');
            $validator->not('veiculoNome', 'null');
            $validator->not('veiculoNome', 'empty');

            $veiculo = new Veiculo();
            $veiculo->id = $request->veiculoId;
            $veiculo->name = $request->veiculoNome;
            $veiculo->descricao = $request->veiculoDescricao;
            $veiculo->preco = $request->veiculoPreco;
            $veiculo->local = $request->veiculoLocal;
            return $veiculo;
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage(), 1);
        }
    }

}
