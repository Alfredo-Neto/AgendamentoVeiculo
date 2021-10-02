<?php

namespace AgVeiculo\Repository;
use AgVeiculo\Database\DbConnectionFactory;
use PDO;

class AgendamentosRepository
{

    public function findAll($veiculoId = null)
    {
        $filter = '';
        if($veiculoId != null) {
            $filter = "where id = :veiculoId";
        }

        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Agendamento $filter";
        $statement = $pdo->prepare($sql);

        if ($veiculoId != null) {
            $statement->bindValue(":veiculoId", $veiculoId);
        }
        
        $statement->execute();
        $veiculosAgendados = $statement->fetchAll(PDO::FETCH_OBJ);
        return $veiculosAgendados;
    }

    public function create($agendamento)
    {
        var_dump($agendamento);
        $pdo = DbConnectionFactory::get();
        $sql = "INSERT INTO Agendamento( datahora, veiculoId)
        VALUES(:datahora, :veiculoId)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":datahora", $agendamento->dataHora);
        $statement->bindValue(":veiculoId", $agendamento->veiculoId);
        $statement->execute();
    }
}
