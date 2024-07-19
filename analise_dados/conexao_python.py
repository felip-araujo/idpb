import mariadb

def create_connection():
    try:
        conexao = mariadb.connect(
            host="54.196.208.38",
            user="root",
            password="qiykGUao3R.D",
            database="IDPB",
            port=3306
        )
        return conexao
    except mariadb.Error as e:
        print(f"Erro ao conectar ao banco de dados: {e}")
        return None

def close_connection(conexao):
    if conexao:
        conexao.close()
        print("Conexão com o banco de dados foi encerrada.")
