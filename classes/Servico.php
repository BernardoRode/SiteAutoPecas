<?php
class Servicos
{
    private $conn;
    private $table_name = "servico";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // FUNÇÃO QUE ENVIA OS DADOS PRO BANCO DE DADOS 
    public function cadastrarServico($tipo_servico, $data_servico, $valor, $cliente_id, $veiculo_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (tipo_servico, data_servico, valor, cliente_id, veiculo_id)
                  VALUES (:tipo_servico, :data_servico, :valor, :cliente_id, :veiculo_id)";
        $stmt = $this->conn->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':tipo_servico', $tipo_servico);
        $stmt->bindParam(':data_servico', $data_servico);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':veiculo_id', $veiculo_id);

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

    public function atualizar($id, $tipo_servico, $data_servico, $valor, $cliente_id, $veiculo_id)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET tipo_servico = ?, data_servico = ?, valor = ?, cliente_id = ?, veiculo_id = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tipo_servico, $data_servico, $valor, $cliente_id, $veiculo_id, $id]);
        return $stmt;
    }

    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function lerServicos()
    {


        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obterServico($id = null)
    {
        // Base da consulta
        $query = "SELECT id, tipo_servico FROM " . $this->table_name;

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