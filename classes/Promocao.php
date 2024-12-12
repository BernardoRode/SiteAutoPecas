<?php
class Promocao
{
    private $conn;
    private $table_name = "promocao";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function cadastrarPromocao($descricao, $preco, $data_inicio, $data_final, $imagem)
    {
        $query = "INSERT INTO " . $this->table_name . " (descricao,preco,data_inicio,data_final,imagem)
                  VALUES (:descricao, :preco, :data_inicio, :data_final, :imagem)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_final', $data_final);
        $stmt->bindParam(':imagem', $imagem);
        return $stmt->execute();
    }
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id, $nome, $sexo, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $id]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obterPromocao($id = null)
    {
        // Base da consulta
        $query = "SELECT id, descricao FROM " . $this->table_name;

        // Adiciona cláusula WHERE se o ID for fornecido
        if ($id !== null) {
            $query .= " WHERE id = ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($id !== null) {
            $stmt->execute([$id]);
        } else {
            $stmt->execute();
        }
        if ($id !== null) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
