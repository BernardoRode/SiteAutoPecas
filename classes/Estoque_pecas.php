<?php
class Estoque_pecas
{
    private $conn;
    private $table_name = "Estoque_pecas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $quantidade, $preco)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, quantidade, preco)
                  VALUES (:nome, :quantidade, :preco)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco);

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

    public function atualizar($id, $nome, $quantidade, $preco)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, quantidade = ?, preco = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $quantidade, $preco, $id]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function obterPecas($id = null)
    {
        // Base da consulta
        $query = "SELECT id, nome FROM " . $this->table_name;

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
?>