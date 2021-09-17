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
        $sql = "INSERT INTO Veiculos(name, descricao, preco, local)
        VALUES(:name, :descricao, :preco, :local)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":name", $veiculo->name);
        $statement->bindValue(":descricao", $veiculo->descricao);
        $statement->bindValue(":preco", $veiculo->preco);
        $statement->bindValue(":local", $veiculo->local);
        $statement->execute();
    }
}