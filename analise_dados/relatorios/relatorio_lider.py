import pymysql
import pandas as pd
import json
from datetime import datetime
import os

# Conectar ao banco de dados
conexao = pymysql.connect(
    host="54.196.208.38",
    user="root",
    password="qiykGUao3R.D",
    database="IDPB",
    port=3306
)

# Criar um cursor
sql = conexao.cursor()

# Executar a consulta e criar DataFrame para relatorio_lider
sql.execute("SELECT * FROM relatorio_lider")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_relatorio_lider = pd.DataFrame(resultados, columns=colunas)
df_relatorio_lider.to_csv('dados_csv/dados_relatorio_lider.csv', index=False)

# Executar a consulta e criar DataFrame para presencas
sql.execute("SELECT * FROM presencas")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_presencas = pd.DataFrame(resultados, columns=colunas)
df_presencas.to_csv('dados_csv/dados_presencas.csv', index=False)

# Fechar o cursor e a conexão
sql.close()
conexao.close()