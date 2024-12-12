create table Funcionarios(
    id int primary key auto_increment not null,
    nome varchar(300) not null,
    email varchar(300) not null,
    senha varchar(255) not null,
    codigo_verificacao varchar(10) not null
);
create table Veiculos(
    id INT primary key auto_increment,
    placa varchar(7) not null unique,
    modelo varchar(200) not null,
    marca varchar(200) not null,
    ano YEAR(4)
);
create table Clientes(
    id INT primary key auto_increment,
    cpf varchar(11) not null,
    nome VARCHAR(300) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    veiculo_id INT,
    foreign key (veiculo_id) references Veiculos(id)
);
create table Promocao(
    id int primary key auto_increment,
    descricao varchar (300) not null,
    preco decimal(10, 2) not null,
    data_inicio date not null,
    data_final date not null,
    imagem varchar (255) not null
);
create table Estoque_pecas(
    id int primary key auto_increment not null,
    nome varchar(250) not null,
    quantidade int not null,
    preco decimal(10, 2)
);
create table Estoque_acessorios(
    id int primary key auto_increment,
    nome varchar(255) not null,
    quantidade int not null,
    preco decimal(10, 2)
);
create table Servico(
    id int primary key auto_increment,
    tipo_servico varchar(300) not null,
    data_servico varchar(300) not null,
    valor decimal(10, 2) not null,
    cliente_id int,
    foreign key (cliente_id) references Clientes(id),
    veiculo_id int,
    foreign key(veiculo_id) references Veiculos(id)
);
create table Vendas(
    id int primary key auto_increment,
    data_venda date not null,
    valor_total decimal(10, 2),
    servico_id int,
    funcionario_id int,
    pecas_id int,
    acessorio_id int,
    veiculo_id int,
    promocao_id int,
    foreign key (promocao_id) references Promocao(id),
    foreign key (pecas_id) references Estoque_pecas(id),
    foreign key (acessorio_id) references Estoque_acessorios(id),
    foreign key(veiculo_id) references veiculos(id),
    foreign key(servico_id) references servico(id),
    foreign key (funcionario_id) references funcionarios(id)
);