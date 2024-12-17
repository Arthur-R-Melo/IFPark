from flask import Flask, request, jsonify
import subprocess
import os
import uuid
import json

app = Flask(__name__)

TEMP_FOLFER =  './temp_images'
os.makedirs(TEMP_FOLFER, exist_ok=True)

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
    filepath = os.path.join(TEMP_FOLFER, unique_filename)

    try:
        file.save(filepath)


        process = subprocess.run(['alpr', '-c', 'br', '-j', filepath], capture_output=True, text=True)

        if process.returncode != 0:
            raise RuntimeError(f"Erro ao processar a imagem: {process.stderr.strip()}")

        return jsonify({"result": process.stdout.strip()}), 200

    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        if os.path.exists(filepath):
            os.remove(filepath)


# Inicia o servidor
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)


def verifyPlates(result, id):
    