CREATE TABLE categorias (
    idcategoria INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    PRIMARY KEY(idcategoria)
);

CREATE TABLE produtos (
	idproduto INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(250) NOT NULL,
    idcategoria INT NOT NULL,
    quantidade int NOT NULL,
    PRIMARY KEY(idproduto),
    FOREIGN KEY(idcategoria) REFERENCES categorias(idcategoria)
);

CREATE TABLE usuarios (
    idusuario INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    foto VARCHAR(255) DEFAULT 'default.png',
    tipousuario INT DEFAULT 1,
    status BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(idusuario)
);