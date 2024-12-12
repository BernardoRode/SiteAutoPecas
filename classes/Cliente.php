<?php
class Cliente
{
    private $conn;
    private $table_name = "clientes";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    /*FUNÇÃO CERTA QUE 
                     INSERE OS DADOS DE CLIENTES
                         NO BANCO DE DADOS */
    public function cadastrarCliente($cpf, $nome, $cep, $veiculo_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (cpf,nome,cep,veiculo_id)
                  VALUES (:cpf, :nome, :cep, :veiculo_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':veiculo_id', $veiculo_id);

        return $stmt->execute();
    }

    public function buscarCliente($id)
    {
        try {
            // SQL para selecionar os dados do cliente
            $query = "SELECT * FROM clientes WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);

            // Bind do ID à consulta
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Executa a consulta
            $stmt->execute();

            // Verifica se encontrou o cliente
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null; // Cliente não encontrado
            }
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar cliente: ' . $e->getMessage());
        }
    }
    public function atualizarCliente($id, $cpf, $nome, $cep, $veiculo_id)
    {
        try {
            // Verificar se o veiculo_id existe na tabela 'veiculos'
            if ($veiculo_id !== null) {
                $queryVeiculo = "SELECT id FROM veiculos WHERE id = :veiculo_id LIMIT 1";
                $stmtVeiculo = $this->conn->prepare($queryVeiculo);
                $stmtVeiculo->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);
                $stmtVeiculo->execute();

                if ($stmtVeiculo->rowCount() == 0) {
                    throw new Exception("O ID do veículo fornecido não existe.");
                }
            }

            // Atualiza os dados do cliente
            $query = "UPDATE clientes SET cpf = :cpf, nome = :nome, cep = :cep, veiculo_id = :veiculo_id WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            // Bind dos parâmetros
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Executa a consulta
            if ($stmt->execute()) {
                return true; // Retorna verdadeiro se a atualização for bem-sucedida
            } else {
                throw new Exception("Erro ao atualizar os dados do cliente.");
            }
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }
    public function deletarCliente($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function lerPorIdCliente($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterCliente($id = null)
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

    public function obterClientesDetalhados()
    {
        $query = "SELECT 
                    c.id,
                    c.cpf,
                    c.nome,
                    c.cep,
                    v.modelo AS modelo_veiculo
                  FROM " . $this->table_name . " c
                  INNER JOIN veiculos v ON c.veiculo_id = v.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
