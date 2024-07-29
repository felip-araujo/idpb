import mariadb
import pandas as pd
import os

# Conectar ao banco de dados
conexao = mariadb.connect(
    host="54.196.208.38",
    user="root",
    password="qiykGUao3R.D",
    database="IDPB",
    port=3306
)

# Criar um cursor
sql = conexao.cursor()

# Executar a consulta
sql.execute("SELECT * FROM membros")
resultados = sql.fetchall()

# Obter a descrição das colunas
colunas = [desc[0] for desc in sql.description]

# Criar um DataFrame com os resultados
df_membros = pd.DataFrame(resultados, columns=colunas)

# Definir o caminho relativo para salvar os arquivos CSV
csv_path = os.path.join(os.path.dirname(__file__), 'dados_csv')

# Criar o diretório 'dados_csv' se não existir
if not os.path.exists(csv_path):
    os.makedirs(csv_path)

# Salvar o df em CSV
df_membros.to_csv(os.path.join(csv_path, 'dados_membros.csv'), index=False)

# Exibir o DataFrame
#df_membros

# Executar a consulta
sql.execute("SELECT * FROM celulas")
resultados = sql.fetchall()

# Obter a descrição das colunas
colunas = [desc[0] for desc in sql.description]

# Criar um DataFrame com os resultados
df_celulas = pd.DataFrame(resultados, columns=colunas)

# Salvar o df em CSV
df_celulas.to_csv(os.path.join(csv_path, 'dados_celulas.csv'), index=False)

# Exibir o DataFrame
#df_celulas

# Executar a consulta
sql.execute("SELECT * FROM usuarios")
resultados = sql.fetchall()

# Obter a descrição das colunas
colunas = [desc[0] for desc in sql.description]

# Criar um DataFrame com os resultados
df_usuarios = pd.DataFrame(resultados, columns=colunas)

# Salvar o df em CSV
df_usuarios.to_csv(os.path.join(csv_path, 'dados_usuarios.csv'), index=False)

# Exibir o DataFrame
#df_usuarios
