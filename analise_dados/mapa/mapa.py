import sys
import os
import importlib.util
import pandas as pd
import folium
from folium.plugins import HeatMap
from geopy.geocoders import Nominatim
from IPython.display import display
import time
import json

# Função para carregar o cache de coordenadas
def load_cache(cache_file='geocode_cache.json'):
    if os.path.exists(cache_file):
        with open(cache_file, 'r') as f:
            return json.load(f)
    else:
        return {}

# Função para salvar o cache de coordenadas
def save_cache(cache, cache_file='geocode_cache.json'):
    with open(cache_file, 'w') as f:
        json.dump(cache, f)

# Função para obter coordenadas a partir do CEP, com cache
def get_coordinates(cep, geolocator, cache):
    if cep in cache:
        return cache[cep]
    
    try:
        location = geolocator.geocode(f"{cep}, Manaus, Brazil")
        if location:
            coordinates = (location.latitude, location.longitude)
            cache[cep] = coordinates
            return coordinates
        else:
            return None, None
    except Exception as e:
        print(f"Erro ao geocodificar {cep}: {e}")
        return None, None

# Inicializar geolocator e cache
geolocator = Nominatim(user_agent="geoapiExercises")
cache = load_cache()

# Carregar o DataFrame df_membros de conexao.py
analise_dados_dir = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))
sys.path.append(analise_dados_dir)
conexao_path = os.path.join(analise_dados_dir, 'conexao.py')
spec = importlib.util.spec_from_file_location('conexao', conexao_path)
conexao = importlib.util.module_from_spec(spec)
spec.loader.exec_module(conexao)
df_membros = conexao.df_membros

# Aplicar a função aos CEPs do DataFrame
df_membros[['latitude', 'longitude']] = df_membros['cep'].apply(lambda cep: pd.Series(get_coordinates(cep, geolocator, cache)))

# Salvar o cache atualizado
save_cache(cache)

# Filtrar CEPs com coordenadas válidas
valid_coordinates = df_membros.dropna(subset=['latitude', 'longitude'])

# Filtrar coordenadas que estão dentro dos limites de Manaus
def is_within_manaus(lat, lon):
    lat_min, lat_max = -3.2, -2.8
    lon_min, lon_max = -60.1, -59.8
    return lat_min <= lat <= lat_max and lon_min <= lon <= lon_max

valid_coordinates = valid_coordinates[valid_coordinates.apply(lambda row: is_within_manaus(row['latitude'], row['longitude']), axis=1)]

# Criando um mapa base centrado na localização média de Manaus
m = folium.Map(location=[-3.080689, -59.993497], zoom_start=12)

# Adicionando os pontos de calor
heat_data = valid_coordinates[['latitude', 'longitude']].values.tolist()
HeatMap(heat_data).add_to(m)

# Adicionando marcadores com os nomes das pessoas
for index, row in valid_coordinates.iterrows():
    folium.Marker(
        location=[row['latitude'], row['longitude']],
        popup=row['nome_completo']
    ).add_to(m)

# Salvando o mapa em um arquivo HTML
m.save('mapa_local_membros.html')

# Para visualizar o mapa no Jupyter Notebook
# display(m)
