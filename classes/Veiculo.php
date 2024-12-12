<?php
class Veiculo
{
    private $conn;
    private $table_name = "veiculos";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para cadastrar uma notícia no banco
    public function cadastrar($placa, $modelo, $marca, $ano)
    {
        $query = "INSERT INTO " . $this->table_name . " (placa, modelo, marca, ano)
                  VALUES (:placa, :modelo, :marca, :ano)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':ano', $ano);
        return $stmt->execute();
    }
    // FUNÇÃO PARA CRIAR A CAIXA DE SELEÇÃO E OBTER OS VEICULOS CADASTRADOS NO SISTEMA 
    public function obterVeiculos($id = null) {
        // Base da consulta
        $query = "SELECT id, modelo FROM " . $this->table_name;
    
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


    public function atualizar($placa_id, $modelo, $marca, $ano)
    {
        $query = "UPDATE " . $this->table_name . " SET placa_id = ?, modelo = ?, marca = ?, ano = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$placa_id, $modelo, $marca, $ano]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
