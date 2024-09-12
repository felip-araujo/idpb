import pandas as pd
from datetime import datetime
import json
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
df_relatorio_lider.to_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_relatorio_lider.csv', index=False)

# Executar a consulta e criar DataFrame para presencas
sql.execute("SELECT * FROM presencas")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_presencas = pd.DataFrame(resultados, columns=colunas)
df_presencas.to_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_presencas.csv', index=False)

# Fechar o cursor e a conexão
sql.close()
conexao.close()


# Carregar os arquivos CSV
df_celulas = pd.read_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_celulas.csv')
df_relatorio_lider = pd.read_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_relatorio_lider.csv')
df_membros = pd.read_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_membros.csv')
df_presencas = pd.read_csv('/home/bitnami/htdocs/idpb/analise_dados/dados_csv/dados_presencas.csv')

# Garantir que as colunas estão no tipo correto
df_celulas['numero_celula'] = df_celulas['numero_celula'].astype(int)
df_relatorio_lider['celula'] = df_relatorio_lider['celula'].astype(int)
df_membros['numero_celula'] = df_membros['numero_celula'].astype(int)

# Converter a coluna 'data_nascimento' e 'data' para datetime
df_membros['data_nascimento'] = pd.to_datetime(df_membros['data_nascimento'], format='%Y-%m-%d')
df_presencas['data'] = pd.to_datetime(df_presencas['data'], format='%Y-%m-%d')
df_relatorio_lider['data'] = pd.to_datetime(df_relatorio_lider['data'], format='%Y-%m-%d')

# Função para calcular a idade
def calcular_idade(data_nascimento):
    hoje = datetime.now()
    return hoje.year - data_nascimento.year - ((hoje.month, hoje.day) < (data_nascimento.month, data_nascimento.day))

# Calcular a idade de cada membro
df_membros['idade'] = df_membros['data_nascimento'].apply(calcular_idade)

# Categorizar os membros em faixas etárias
def categorizar_faixa_etaria(idade):
    if idade < 18:
        return '0-17'
    elif 18 <= idade < 30:
        return '18-29'
    elif 30 <= idade < 40:
        return '30-39'
    elif 40 <= idade < 50:
        return '40-49'
    elif 50 <= idade < 60:
        return '50-59'
    else:
        return '60+'

df_membros['faixa_etaria'] = df_membros['idade'].apply(categorizar_faixa_etaria)

# Lista para armazenar os resultados
resultados = []

# Iterar sobre cada célula na coluna 'celula' do DataFrame df_relatorio_lider
for _, row in df_relatorio_lider.iterrows():
    numero_celula = row['celula']
    data_relatorio = row['data']
    
    # Filtrar o DataFrame para encontrar a linha com o número da célula desejado
    linha_celula = df_celulas[df_celulas['numero_celula'] == numero_celula]
    linha_membros = df_membros[df_membros['numero_celula'] == numero_celula]
    
    # Se a célula existir em df_celulas
    if not linha_celula.empty:
        # Obter os valores necessários
        numero_coordenacao = int(linha_celula['numero_coordenacao'].values[0])
        nome_lider = linha_celula['nome_lider'].values[0]
        total_membros = linha_membros['cpf'].nunique()

        # Calcular a soma por faixa etária
        faixa_etaria_contagem = linha_membros['faixa_etaria'].value_counts().to_dict()

        # Filtrar o DataFrame de presenças para a mesma data e número da célula
        presencas_filtradas = df_presencas[(df_presencas['data'] == data_relatorio) &
                                           (df_presencas['numero_celula'] == numero_celula)]
        # Contar o número de CPFs únicos presentes
        total_presentes = presencas_filtradas['cpf'].nunique()

        # Obter nomes dos presentes
        presentes_cpfs = presencas_filtradas[presencas_filtradas['presente'] == 1]['cpf']
        nomes_presentes = df_membros[df_membros['cpf'].isin(presentes_cpfs)]['nome_completo'].tolist()

        # Contar o gênero dos presentes
        generos_presentes = df_membros[df_membros['cpf'].isin(presentes_cpfs)]['genero'].value_counts().to_dict()

        # Verificar se houve visitantes e obter o total de visitantes
        houve_visitantes = row['visitantes'] if pd.notna(row['visitantes']) else 0
        total_visitantes = row['numero_visitantes'] if pd.notna(row['numero_visitantes']) else 0

        # Verificar a quantidade de crianças presentes
        total_criancas = row['criancas'] if pd.notna(row['criancas']) else 0

        # Verificar se houve convertidos e o total de convertidos
        houve_convertidos = row['convertidos'] if pd.notna(row['convertidos']) else 0
        total_convertidos = row['numero_convertidos'] if pd.notna(row['numero_convertidos']) else 0

        # Verificar se foi um evento e o nome do evento
        foi_evento = row['evento'] if pd.notna(row['evento']) else 0
        nome_evento = row['nome_evento'] if pd.notna(row['nome_evento']) else ''

        # Verificar se o coordenador estava presente
        coordenador_presente = row['coordenador_presente'] if pd.notna(row['coordenador_presente']) else 0

        # Verificar se o supervisor estava presente
        supervisor_presente = row['supervisor_presente'] if pd.notna(row['supervisor_presente']) else 0

        # Obter as observações
        observacoes = row['observacoes'] if pd.notna(row['observacoes']) else ''

        # Formatar a data no formato DD/MM/YYYY
        data_formatada = data_relatorio.strftime('%d/%m/%Y')

        # Armazenar o resultado em um dicionário
        resultado = {
            'numero_celula': numero_celula,
            'numero_coordenacao': numero_coordenacao,
            'nome_lider': nome_lider,
            'total_membros': total_membros,
            'data': data_formatada,
            'faixa_etaria': faixa_etaria_contagem,
            'total_presentes': total_presentes,
            'nomes_presentes': nomes_presentes,
            'generos_presentes': generos_presentes,
            'houve_visitantes': houve_visitantes,
            'total_visitantes': total_visitantes,
            'total_criancas': total_criancas,
            'houve_convertidos': houve_convertidos,
            'total_convertidos': total_convertidos,
            'foi_evento': foi_evento,
            'nome_evento': nome_evento,
            'coordenador_presente': coordenador_presente,
            'supervisor_presente': supervisor_presente,
            'observacoes': observacoes
        }
        resultados.append(resultado)

# Converter a lista de resultados em um DataFrame
df_resultados = pd.DataFrame(resultados)

# Substituir NaN por 0 em todo o DataFrame
df_resultados.fillna(0, inplace=True)

# Exibir os resultados
#print(df_resultados)

# Salva o json do relatorio
with open('../json/relatorio_lider.json', 'w', encoding='utf-8') as f:
    json.dump(resultados, f, ensure_ascii=False, indent=4)