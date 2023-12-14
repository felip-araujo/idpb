from flask import Flask, jsonify
import pandas as pd

app = Flask(__name__)

# Leitura do CSV
df = pd.read_csv('/assets/py/idpb_dados/Celulas.csv')

# Rota para obter todos os registros
@app.route('/api/v1/registros', methods=['GET'])
def get_all_registros():
    return jsonify(df.to_dict(orient='records'))

# Rota para obter um registro específico
@app.route('/api/v1/registros/<int:id>', methods=['GET'])
def get_registro(id):
    registro = df[df['id'] == id].to_dict(orient='records')
    return jsonify(registro)

if __name__ == '__main__':
    app.run(debug=True)
