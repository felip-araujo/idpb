#!/bin/bash

# Define o diretório do script
SCRIPT_DIR="/home/bitnami/htdocs/idpb/analise_dados"

# Ativa o ambiente virtual
source "${SCRIPT_DIR}/venv/bin/activate"

# Muda para o diretório do script
cd "${SCRIPT_DIR}"

# Executa o script Python
python3 analise_dados.py

# Desativa o ambiente virtual
deactivate
