create database agendamento_veiculo;

CREATE TABLE Veiculos (
    id serial NOT NULL UNIQUE,
    name varchar(255) NOT NULL,
    descricao varchar(255),
    preco numeric(20,2) NOT NULL,
    local varchar(255),
    CONSTRAINT PK_Veiculos PRIMARY KEY (ID)
);

select * from Veiculos;