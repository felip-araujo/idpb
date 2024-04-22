-- Inserir dados em Celulas_X
INSERT INTO Celulas_X (Numero_Celula, Descricao) VALUES
(09, 'Celula dos cientistos'),
(10, 'celula dos backendos'),
(35, 'Celula dos frontendos');

-- Inserir dados em Supervisao_X
INSERT INTO Supervisao_X (Numero_Supervisao, Descricao) VALUES
(14, 'supervisao dos lindos');

-- Inserir dados em Coordenacao_X
INSERT INTO Coordenacao_X (Numero_Coordenacao, Descricao) VALUES
(3, 'coordenacao dos adultos');



-- Inserir dados em Usuarios_X
INSERT INTO Usuarios_X (Email, Senha, Nome, Numero_Celula, Numero_Supervisao, Numero_Coordenacao) VALUES
('Chrisdynamus@gmail.com', SHA2('senha123', 256), 'Christopher Filipe Rodrigues dos Santos', 09, 14, 3),
('fakelipe@gmail.com', SHA2('senha1234', 256), 'Felipe da Silva Araujo', 10, 14, 3),
('ediel.purim@gmail.com', SHA2('senha12345', 256), 'Ediel Jonathan Rodrigues dos Santos', 35, 14, 3);



-- Inserir funções se ainda não existirem
INSERT INTO Funcoes_X (Nome_Funcao, Descricao) VALUES
('Líder', 'Lidera uma célula'),
('Coordenador', 'Coordena várias superviões'),
('Supervisor', 'Supervisiona várias células');


-- Obter ID dos usuários (deve ser ajustado conforme o retorno dos IDs após inserção)
-- Supondo que os IDs dos usuários sejam 1 para Christopher, 2 para Felipe, 3 para Ediel

-- Associar funções aos usuários
INSERT INTO Usuario_Funcoes_X (ID_Usuario, ID_Funcao) VALUES
(1, (SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = 'Líder')),  -- Christopher é só líder
(2, (SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = 'Líder')),  -- Felipe é líder
(2, (SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = 'Coordenador')),  -- Felipe também é coordenador
(3, (SELECT ID_Funcao FROM Funcoes_X WHERE Nome_Funcao = 'Supervisor'));  -- Ediel é supervisor
