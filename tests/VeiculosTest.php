<?php

use AgVeiculo\Entity\Veiculo;
use PHPUnit\Framework\TestCase;
use AgVeiculo\Repository\VeiculosRepository;

class VeiculosTest extends TestCase
{
    public function testListaVeiculo()
    {
        //arrange - monta o cenario
        $veiculosRepository = new VeiculosRepository();

        //act - executa a função
        $carros = $veiculosRepository->findAll();

        //assert - verifica se ocorreu como esperado
        $this->assertGreaterThanOrEqual(1,count($carros));

        foreach ($carros as $key => $carro) {
            $this->assertNotEquals($carro->id,null);
            $this->assertNotEquals($carro->name,null);
            $this->assertNotEquals($carro->preco,null);
        }

    }

    public function testNaoConsegueListarVeiculo()
    {
        //arrange - monta o cenario
        $veiculosRepository = new VeiculosRepository();

        //act - executa a função
        $carros = $veiculosRepository->findAll(999999);

        //assert - verifica se ocorreu como esperado
        $this->assertEquals(0,count($carros));
    }

    public function testConsegueInserirVeiculo()
    {
        //arrange - monta o cenario
        $veiculosRepository = new VeiculosRepository();

        //act - executa a função
        $veiculo = new Veiculo();
        $veiculo->name = 'virtus';
        $veiculo->preco = '300000.00';
        $carroCriado = $veiculosRepository->create($veiculo);

        //assert - verifica se ocorreu como esperado
        $carroListado = $veiculosRepository->findAll($carroCriado->id);
        $this->assertCount(1, $carroListado);
        $carroListado = $carroListado[0];
        $this->assertEquals($carroListado->name, $veiculo->name);
        $this->assertEquals($carroListado->preco, $veiculo->preco);
    }

    public function testNaoConsegueInserirVeiculoSemPreco()
    {
        //arrange - monta o cenario
        $veiculosRepository = new VeiculosRepository();

        //assert - verifica se ocorreu como esperado
        $this->expectException(PDOException::class);

        //act - executa a função
        $veiculo = new Veiculo();
        $veiculo->name = 'virtus';

        $carroCriado = $veiculosRepository->create($veiculo);
    }
}
