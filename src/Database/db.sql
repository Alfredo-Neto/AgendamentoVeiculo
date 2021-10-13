create database agendamento_veiculo;

CREATE TABLE Veiculos (
    id serial NOT NULL UNIQUE,
    name varchar(255) NOT NULL,
    descricao varchar(255),
    preco numeric(20,2) NOT NULL,
    imagePath varchar(255),
    local varchar(255),
    CONSTRAINT PK_Veiculos PRIMARY KEY (ID)
);

CREATE TABLE Agendamento (
    id serial NOT NULL UNIQUE,
    datahora timestamp,
    nome varchar(255),
    email varchar(255),
    telefone varchar(20),
    veiculoId bigint,
    CONSTRAINT PK_Agendamento PRIMARY KEY (ID),
    CONSTRAINT FK_AgendamentoVeiculo FOREIGN KEY (veiculoId) REFERENCES Veiculos (id)
);

select * from Veiculos;