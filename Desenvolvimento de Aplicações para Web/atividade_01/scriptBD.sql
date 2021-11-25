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