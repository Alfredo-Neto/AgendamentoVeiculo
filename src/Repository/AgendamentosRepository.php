<?php

namespace AgVeiculo\Repository;
use AgVeiculo\Database\DbConnectionFactory;
use PDO;

class AgendamentosRepository
{
    public function create($agendamento)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "INSERT INTO Agendamento(datahora, veiculoId)
        VALUES(:datahora, :veiculoId)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":datahora", $agendamento->dataHora);
        $statement->bindValue(":veiculoId", $agendamento->id);
        $statement->execute();
    }
}
