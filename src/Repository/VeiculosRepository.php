<?php

namespace AgVeiculo\Repository;
use PDO;
use AgVeiculo\Entity\Veiculo;
use AgVeiculo\Database\DbConnectionFactory;

class VeiculosRepository {

    public function findAll($veiculoId)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Veiculos;";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $veiculos = $statement->fetchAll(PDO::FETCH_OBJ);
        return $veiculos;
    }

    public function create($veiculo)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "INSERT INTO Veiculos(name)
        VALUES(:name)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":name", $veiculo->name);
        $statement->execute();
    }
}