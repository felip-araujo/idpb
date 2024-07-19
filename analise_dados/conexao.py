import mysql.connector
from mysql.connector import Error

def create_connection():
    try:
        connection = mysql.connector.connect(
            host="35.173.6.89",
            user="3devs",
            password="PHPépraquemPode",
            database="idpb"
        )
        
        if connection.is_connected():
            print("Conexão com o banco de dados estabelecida com sucesso!")
            return connection
    except Error as e:
        print(f"Erro ao conectar ao banco de dados: {e}")
        return None

def close_connection(connection):
    if connection.is_connected():
        connection.close()
        print("Conexão com o banco de dados foi encerrada.")
