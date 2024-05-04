CREATE VIEW ViewCelulasInfo AS
SELECT DISTINCT
    u.Numero_Coordenacao,
    u.Numero_Supervisao,
    u.Numero_Celula,
    c.Nome_Lider
FROM Usuarios_X u
JOIN Celulas_X c ON u.Numero_Celula = c.Numero_Celula;