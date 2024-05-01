--Criação dos relatórios do supervisor
--Primeira parte referente a visita à Célula
CREATE TABLE Relatorio_Supervisao (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Numero_Celula INT(11),
    Data_Visita DATE,
    Recepcao_Pontualidade ENUM('ruim', 'regular', 'bom', 'otimo'),
    Quebra_Gelo ENUM('ruim', 'regular', 'bom', 'otimo'),
    Louvor ENUM('ruim', 'regular', 'bom', 'otimo'),
    Edificacao ENUM('ruim', 'regular', 'bom', 'otimo'),
    Compartilhando ENUM('ruim', 'regular', 'bom', 'otimo'),
    Cadeira_Bencao ENUM('ruim', 'regular', 'bom', 'otimo'),
    Observacoes VARCHAR(255)
);

--Segunda parte referente a visita ao lider
CREATE TABLE Relatorio_Supervisao_2 (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Numero_Celula INT(11),
    Nome_Lider VARCHAR(255),
    Data_Visita DATE,
    Necessidades_Detectadas TEXT,
    Motivos_Oracao TEXT,
    Outras_Observacoes TEXT
);
