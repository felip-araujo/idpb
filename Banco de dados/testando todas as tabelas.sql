SELECT
    u.Nome,
    u.Email,
    f.Nome_Funcao,
    c.Numero_Celula,
    s.Numero_Supervisao,
    co.Numero_Coordenacao
FROM Usuarios_X u
LEFT JOIN Usuario_Funcoes_X uf ON u.ID_Usuario = uf.ID_Usuario
LEFT JOIN Funcoes_X f ON uf.ID_Funcao = f.ID_Funcao
LEFT JOIN Celulas_X c ON u.Numero_Celula = c.Numero_Celula 
LEFT JOIN Supervisao_X s ON u.Numero_Supervisao = s.Numero_Supervisao
LEFT JOIN Coordenacao_X co ON u.Numero_Coordenacao = co.Numero_Coordenacao;

SELECT * FROM Funcoes_X fx 
SELECT * FROM Usuario_Funcoes_X ufx
SELECT * FROM Usuarios_X ux 
