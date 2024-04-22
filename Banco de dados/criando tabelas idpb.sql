CREATE TABLE Celulas_X (
    Numero_Celula INT PRIMARY KEY,
    Descricao TEXT,
    Nome_Lider VARCHAR(255)
);

CREATE TABLE Supervisao_X (
    Numero_Supervisao INT PRIMARY KEY,
    Descricao TEXT,
    Nome_Supervisor VARCHAR(255)
);

CREATE TABLE Coordenacao_X (
    Numero_Coordenacao INT PRIMARY KEY,
    Descricao TEXT,
    Nome_Coordenador VARCHAR(255)
);

CREATE TABLE Funcoes_X (
    ID_Funcao INT AUTO_INCREMENT PRIMARY KEY,
    Nome_Funcao VARCHAR(100) NOT NULL,
    Descricao TEXT
);

CREATE TABLE Usuarios_X (
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    Nome VARCHAR(255) NOT NULL,
    Numero_Celula INT,
    Numero_Supervisao INT,
    Numero_Coordenacao INT,
    FOREIGN KEY (Numero_Celula) REFERENCES Celulas_X(Numero_Celula),
    FOREIGN KEY (Numero_Supervisao) REFERENCES Supervisao_X(Numero_Supervisao),
    FOREIGN KEY (Numero_Coordenacao) REFERENCES Coordenacao_X(Numero_Coordenacao)
);

CREATE TABLE Usuario_Funcoes_X (
    ID_Usuario INT,
    ID_Funcao INT,
    PRIMARY KEY (ID_Usuario, ID_Funcao),
    FOREIGN KEY (ID_Usuario) REFERENCES Usuarios_X(ID_Usuario),
    FOREIGN KEY (ID_Funcao) REFERENCES Funcoes_X(ID_Funcao)
);
