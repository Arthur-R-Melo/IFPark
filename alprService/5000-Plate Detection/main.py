from typing import Tuple

from flask import Flask, request, jsonify
import subprocess
import os
import uuid
import json
import requests

app = Flask(__name__)

TEMP_FOLDER = './temp_images'
os.makedirs(TEMP_FOLDER, exist_ok=True)


@app.route('/')
def teste():
    return "<h1>Teste</h1>"


@app.route('/plate-service', methods=['POST'])
def index():
    if 'imagem' not in request.files:
        return jsonify({"error": "Nenhum arquivo enviado"}), 400

    file = request.files['imagem']
    if file.filename == '':
        return jsonify({"error": "Nenhum arquivo selecionado"}), 400
    unique_filename = f"{uuid.uuid4()}.jpg"
    filepath = os.path.join(TEMP_FOLDER, unique_filename)

    try:
        file.save(filepath)

        process = subprocess.run(['alpr', '-c', 'br', '-j', filepath], capture_output=True, text=True)

        if process.returncode != 0:
            raise RuntimeError(f"Erro ao processar a imagem: {process.stderr.strip()}")

        response, status = verify_plates(json.loads(process.stdout.strip()), int(request.form.get('id')))

        if status == 200:
            return jsonify({"status": True, "result": response}), 200
        else:
            return jsonify({"status": False}), status

    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        if os.path.exists(filepath):
            os.remove(filepath)


# Inicia o servidor
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)


def verify_plates(resultALPR: dict, id_empresa: int) -> tuple[bool, int]:
    try:
        for result in resultALPR['results']:
            for candidate in result:
                params = {
                    "placa": candidate['plate'],
                    "id": id_empresa
                }
                url = f"https://feiratec.dev.br/ifpark/control/consulta-placa.php"
                response = requests.get(url, params=params)
                if response.status_code == 200:
                    data = response.json()
                    return data['existe'], 200
                else:
                    return False, response.status_code
    except Exception:
        return False, 500
