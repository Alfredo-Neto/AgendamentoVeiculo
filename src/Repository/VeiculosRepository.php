<?php

namespace AgVeiculo\Repository;
use PDO;
use AgVeiculo\Database\DbConnectionFactory;

class VeiculosRepository {
    public function findAll($veiculoId)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Veiculos where veiculo_id = :veiculo_id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":veiculo_id", $veiculoId);
        $statement->execute();
        $veiculos = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $veiculos;
    }

    public function create($veiculo)
    {

        
        $pdo = DbConnectionFactory::get();
        $sql = "INSERT INTO Veiculos(id, name)
        VALUES(:id, :name)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $veiculo->id);
        $statement->bindValue(":name", $veiculo->name);
        $statement->execute();
    }
}