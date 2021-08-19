create database agendamento_veiculo;

CREATE TABLE Veiculos (
    id serial NOT NULL UNIQUE,
    name varchar(255) NOT NULL UNIQUE,
    CONSTRAINT PK_Veiculos PRIMARY KEY (ID)
);

select * from Veiculos;