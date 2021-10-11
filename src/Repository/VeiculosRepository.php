<?php

namespace AgVeiculo\Repository;
use PDO;
use AgVeiculo\Entity\Veiculo;
use AgVeiculo\Database\DbConnectionFactory;

class VeiculosRepository {

    public function find($id)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Veiculos where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $veiculos = $statement->fetch(PDO::FETCH_OBJ);
        return $veiculos;
    }

    public function findAll($veiculoId = null)
    {
        $filter = '';
        if($veiculoId !== null) {
            $filter = "where id = :veiculoId";
        }

        $pdo = DbConnectionFactory::get();
        $sql = "SELECT * FROM Veiculos $filter";
        $statement = $pdo->prepare($sql);

        if($veiculoId !== null) {
            $statement->bindValue(":veiculoId", $veiculoId);
        }

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

    public function update($veiculo)
    {
        $pdo = DbConnectionFactory::get();
        $sql = "update Veiculos set name = :name, descricao = :descricao
        , preco = :preco, local = :local where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $veiculo->id);
        $statement->bindValue(":name", $veiculo->name);
        $statement->bindValue(":descricao", $veiculo->descricao);
        $statement->bindValue(":preco", $veiculo->preco);
        $statement->bindValue(":local", $veiculo->local);
        $statement->execute();
    }

    public function storeImagePath($veiculo) {
        $pdo = DbConnectionFactory::get();
        $sql = "update Veiculos set imagePath = :imagePath where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $veiculo->id);
        $statement->bindValue(":imagePath", $veiculo->imagePath);
        $statement->execute();
    }
}