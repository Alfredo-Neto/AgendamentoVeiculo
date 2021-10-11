<?php

namespace AgVeiculo\Repository;
use AgVeiculo\Database\DbConnectionFactory;
use AgVeiculo\Entity\Agendamento;
use PDO;

class AgendamentosRepository
{

    public function find($id)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Agendamento where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $agendamento = $statement->fetch(PDO::FETCH_ASSOC);
        $agendamento = $this->mapObject($agendamento);
        return $agendamento;
    }

    public function findAll($veiculoId = null)
    {
        $filter = '';
        if($veiculoId != null) {
            $filter = "where veiculoId = :veiculoId";
        }

        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Agendamento $filter";
        $statement = $pdo->prepare($sql);

        if ($veiculoId != null) {
            $statement->bindValue(":veiculoId", $veiculoId);
        }

        $statement->execute();
        $agendamentos = $statement->fetchAll(PDO::FETCH_ASSOC);
        $agendamentos = $this->mapObjectCollection($agendamentos);
        return $agendamentos;
    }
    
    public function create($agendamento)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "INSERT INTO Agendamento( datahora, veiculoId)
        VALUES(:datahora, :veiculoId)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":datahora", $agendamento->dataHora);
        $statement->bindValue(":veiculoId", $agendamento->veiculoId);
        $statement->execute();
    }

    private function mapObjectCollection($collection){
        $objectCollection = [];
        foreach ($collection as $key => $item) {
            $objectCollection[] = $this->mapObject($item);
        }
        return $objectCollection;
    }

    private function mapObject($array){
        $agendamento = new Agendamento();
        foreach ($array as $key => $value) {
            $agendamento->$key = $value;
        }
        return $agendamento;
    }
}
