import mariadb
import pandas as pd
import json
from datetime import datetime
import os

# Caminhos dos diretórios
csv_dir = 'analise_dados/dados_csv'
json_dir = 'analise_dados/json'

# Função para criar diretórios
def criar_diretorio(diretorio):
    try:
        os.makedirs(diretorio, exist_ok=True)
        print(f'Diretório criado ou já existe: {diretorio}')
    except Exception as e:
        print(f'Erro ao criar diretório {diretorio}: {e}')

# Criar diretórios se não existirem
criar_diretorio(csv_dir)
criar_diretorio(json_dir)

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

# Executar a consulta e criar DataFrame para membros
sql.execute("SELECT * FROM membros")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_membros = pd.DataFrame(resultados, columns=colunas)
df_membros.to_csv('analise_dados/dados_csv/dados_membros.csv', index=False)

# Executar a consulta e criar DataFrame para celulas
sql.execute("SELECT * FROM celulas")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_celulas = pd.DataFrame(resultados, columns=colunas)
df_celulas.to_csv('analise_dados/dados_csv/dados_celulas.csv', index=False)

# Executar a consulta e criar DataFrame para usuarios
sql.execute("SELECT * FROM usuarios")
resultados = sql.fetchall()
colunas = [desc[0] for desc in sql.description]
df_usuarios = pd.DataFrame(resultados, columns=colunas)
df_usuarios.to_csv('analise_dados/dados_csv/dados_usuarios.csv', index=False)

# Fechar o cursor e a conexão
sql.close()
conexao.close()

# Processamento dos dados
total_membros = df_membros['cpf'].nunique()
todas_profissoes = df_membros['profissao'].tolist()

# Calcular as idades
current_year = datetime.now().year
df_membros['data_nascimento'] = pd.to_datetime(df_membros['data_nascimento'], format='%Y-%m-%d')
df_membros['idade'] = current_year - df_membros['data_nascimento'].dt.year

total_criancas = df_membros[df_membros['idade'] <= 12].shape[0]
total_jovens = df_membros[(df_membros['idade'] >= 13) & (df_membros['idade'] <= 29)].shape[0]
total_idosos = df_membros[df_membros['idade'] >= 60].shape[0]
totais_relacionamentos = df_membros['estado_civil'].value_counts().to_dict()
totais_escolaridade = df_membros['escolaridade'].value_counts().to_dict()
total_homens = df_membros[(df_membros['idade'] > 12) & (df_membros['genero'] == 'Masculino')].shape[0]
total_mulheres = df_membros[(df_membros['idade'] > 12) & (df_membros['genero'] == 'Feminino')].shape[0]
contagem_por_celula = df_membros['numero_celula'].value_counts().to_dict()
total_usuarios = df_usuarios['id_Usuario'].shape[0]

df_membros['numero_celula'] = df_membros['numero_celula'].astype(int)
df_celulas['numero_celula'] = df_celulas['numero_celula'].astype(int)
df_membros_celulas = pd.merge(df_membros, df_celulas, on='numero_celula')

contagem_celulas_supervisao = df_celulas.groupby('numero_supervisao')['numero_celula'].count().reset_index()
contagem_celulas_supervisao.columns = ['numero_supervisao', 'contagem_celulas']
contagem_membros_supervisao = df_membros_celulas.groupby('numero_supervisao')['cpf'].count().reset_index()
contagem_membros_supervisao.columns = ['numero_supervisao', 'contagem_membros']
contagem_supervisao = pd.merge(contagem_celulas_supervisao, contagem_membros_supervisao, on='numero_supervisao')

contagem_celulas_coordenacao = df_celulas.groupby('numero_coordenacao')['numero_celula'].count().reset_index()
contagem_celulas_coordenacao.columns = ['numero_coordenacao', 'contagem_celulas']
contagem_membros_coordenacao = df_membros_celulas.groupby('numero_coordenacao')['cpf'].count().reset_index()
contagem_membros_coordenacao.columns = ['numero_coordenacao', 'contagem_membros']
contagem_coordenacao = pd.merge(contagem_celulas_coordenacao, contagem_membros_coordenacao, on='numero_coordenacao')

contagem_coordenacao = contagem_coordenacao.set_index('numero_coordenacao').to_dict(orient='index')
contagem_coordenacao = {k: {'contagem_celulas': v['contagem_celulas'], 'contagem_membros': v['contagem_membros']} for k, v in contagem_coordenacao.items()}
contagem_supervisao = contagem_supervisao.set_index('numero_supervisao').to_dict(orient='index')
contagem_supervisao = {k: {'contagem_celulas': v['contagem_celulas'], 'contagem_membros': v['contagem_membros']} for k, v in contagem_supervisao.items()}

df_membros['data_nascimento'] = pd.to_datetime(df_membros['data_nascimento'])
hoje = datetime.now()
mes_atual = hoje.month
df_membros['mes_nascimento'] = df_membros['data_nascimento'].dt.month
aniversariantes_mes_atual = df_membros[df_membros['mes_nascimento'] == mes_atual]

aniversariantes_mes = {}
for index, row in aniversariantes_mes_atual.iterrows():
    data_nascimento = row['data_nascimento'].strftime('%Y-%m-%d')
    aniversariantes_mes[data_nascimento] = {
        'nome_completo': row['nome_completo'],
        'cpf': row['cpf']
    }

df_membros['data_conversao'] = pd.to_datetime(df_membros['data_conversao'], errors='coerce')
total_convertidos = []
for index, row in df_membros.iterrows():
    nome = row['nome_completo']
    data_conversao = row['data_conversao'].strftime('%Y-%m-%d') if pd.notna(row['data_conversao']) else None
    total_convertidos.append({
        'nome_completo': nome,
        'data_conversao': data_conversao
    })

df_membros['data_batismo'] = pd.to_datetime(df_membros['data_batismo'], errors='coerce')
total_batizados = []
for index, row in df_membros.iterrows():
    nome = row['nome_completo']
    data_batismo = row['data_batismo'].strftime('%Y-%m-%d') if pd.notna(row['data_batismo']) else None
    total_batizados.append({
        'nome_completo': nome,
        'data_batismo': data_batismo
    })

print(total_batizados)

total_participantes_ministerio = len(df_membros[df_membros['participacao_ministerio'].notna()])
participantes_ministerio = []
for index, row in df_membros.iterrows():
    participantes_ministerio.append({
        'nome_completo': row['nome_completo'],
        'cpf': row['cpf'],
        'email': row['email'],
        'participacao_ministerio': row['participacao_ministerio']
    })

dados_json = {
    "total_membros": total_membros,
    "total_criancas": total_criancas,
    "total_jovens": total_jovens,
    "total_idosos": total_idosos,
    "totais_relacionamentos": totais_relacionamentos,
    "totais_escolaridade": totais_escolaridade,
    "total_homens": total_homens,
    "total_mulheres": total_mulheres,
    "contagem_por_celula": contagem_por_celula,
    "contagem_supervisao": contagem_supervisao,
    "contagem_coordenacao": contagem_coordenacao,
    "total_usuarios": total_usuarios,
    "aniversariantes_mes": aniversariantes_mes 
}

participa_ministerio = {
    "participantes_ministerio": participantes_ministerio
}

batizados = {
    "total_batizados": total_batizados
}

convertidos = {
    "total_convertidos": total_convertidos
}

profissoes = {
    "profissoes": todas_profissoes
}

# Salvar em arquivos JSON
with open('analise_dados/json/dados_analisados.json', 'w', encoding='utf-8') as f:
    json.dump(dados_json, f, ensure_ascii=False, indent=4)

with open('analise_dados/json/participa_ministerio.json', 'w', encoding='utf-8') as f:
    json.dump(participa_ministerio, f, ensure_ascii=False, indent=4)

with open('analise_dados/json/batizados.json', 'w', encoding='utf-8') as f:
    json.dump(batizados, f, ensure_ascii=False, indent=4)

with open('analise_dados/json/convertidos.json', 'w', encoding='utf-8') as f:
    json.dump(convertidos, f, ensure_ascii=False, indent=4)

with open('analise_dados/json/profissoes.json', 'w', encoding='utf-8') as f:
    json.dump(profissoes, f, ensure_ascii=False, indent=4)
