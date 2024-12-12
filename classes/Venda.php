<?php
class Venda
{
    private $conn;
    private $table_name = "Vendas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrarVendas($data_venda, $valor_total, $servico_id, $funcionario_id, $pecas_id, $acessorio_id, $veiculo_id, $promocao_id)
    {
        $query = "INSERT INTO " . $this->table_name . " 
              (data_venda, valor_total, servico_id, funcionario_id, pecas_id, acessorio_id, veiculo_id, promocao_id)
              VALUES 
              (:data_venda, :valor_total, :servico_id, :funcionario_id, :pecas_id, :acessorio_id, :veiculo_id, :promocao_id)";
        $stmt = $this->conn->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':data_venda', $data_venda);
        $stmt->bindParam(':valor_total', $valor_total);
        $stmt->bindParam(':servico_id', $servico_id);
        $stmt->bindParam(':funcionario_id', $funcionario_id);
        $stmt->bindParam(':pecas_id', $pecas_id);
        $stmt->bindParam(':acessorio_id', $acessorio_id);
        $stmt->bindParam(':veiculo_id', $veiculo_id);
        $stmt->bindParam(':promocao_id', $promocao_id);

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

    public function atualizar($data_venda, $valor_total, $servico_id, $pecas_id, $acessorio_id, $veiculo_id, $promocao_id)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET data_venda = ?, valor_total = ?, servico_id = ?, pecas_id = ?, acessorios_id = ?, veiculos_id = ?, promocao_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data_venda, $valor_total, $servico_id, $pecas_id, $acessorio_id, $veiculo_id, $promocao_id]);
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
    public function obterTodasVendas()
    {
        $query = "SELECT 
                    v.data_venda,
                    v.valor_total,
                    s.tipo_servico,
                    f.nome AS nome_funcionario,
                    p.nome AS nome_pecas,
                    a.nome AS nome_acessorios,
                    ve.modelo AS modelo_veiculo,
                    pr.descricao AS descricao_promocao
                  FROM " . $this->table_name . " v
                  INNER JOIN servico s ON v.servico_id = s.id
                  INNER JOIN funcionarios f ON v.funcionario_id = f.id
                  INNER JOIN estoque_pecas p ON v.pecas_id = p.id
                  INNER JOIN estoque_acessorios a ON v.acessorio_id = a.id
                  INNER JOIN veiculos ve ON v.veiculo_id = ve.id
                  INNER JOIN promocao pr ON v.promocao_id = pr.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>