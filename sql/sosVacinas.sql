create database sosVacina;
use sosVacina;

create table usuarios (
	idUsuarios bigint primary key auto_increment,
    nome varchar (200) not null,
	email varchar (255) unique not null,
    estado varchar (20) not null, 
	senha varchar (128) not null,
    idade varchar (3),
    genero varchar (10),
    cpf varchar (11) unique,
    telefone varchar (11),
    cidade varchar (20),
    emailConf boolean
);

create table vacinas (
	idVacina bigint primary key auto_increment,
	nomeVac varchar (100) not null,
    data_vacina varchar (10) not null, 
    tipo varchar (50) not null,
    dose int,
    lote varchar (50),
    obs text
);

create table usuario_vacina (
    idUsuario bigint,
    idVacina bigint,
    data_vacina date,
    primary key (idUsuario, idVacina),
    foreign key (idUsuario) references usuarios(idUsuarios),
    foreign key (idVacina) references vacinas(idVacina)
);



#insert into usuarios (nome, email, senha, estado)
#values 
#('Pedro', 'peu@gmail.com', SHA2('Chicote1@', 256), 'BA');
#select * from usuarios where email = 'peu@gmail.com' and senha = SHA2('Chicote1@', 256);

#select * from usuarios where email = 'viskp2537@gmail.com' and senha = SHA2('Chicote1@', 256);

#SELECT * FROM usuarios WHERE email = 'viskp2537@gmail.com' AND senha = SHA2('Chicote1@', 256);

#SHOW CREATE TABLE usuarios;

#INSERT INTO usuarios (nome, email, estado, senha) VALUES ('Teste', 'teste@exemplo.com', 'SP', 'senha123');


