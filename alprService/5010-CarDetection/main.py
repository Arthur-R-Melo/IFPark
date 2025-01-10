from flask import Flask, request, jsonify
from carDetection.carDetection import identifyCar
import os
import uuid

app = Flask(__name__)

TEMP_FOLFER =  './temp_images'
os.makedirs(TEMP_FOLFER, exist_ok=True)

@app.route('/carDetection', methods=['POST'])
def index():
    if 'imagem' not in request.files:
        return jsonify({"error": "Nenhum arquivo enviado"}), 400

    file = request.files['imagem']
    if file.filename == '':
        return jsonify({"error": "Nenhum arquivo selecionado"}), 400
    unique_filename = "imagem.jpg"
    filepath = os.path.join(TEMP_FOLFER, unique_filename)

    try:
        file.save(filepath)

        response = identifyCar(filepath)

        if 'errror' in response:
            print(response['error'])
            return jsonify({"error": response['error']}) #TODO
        else:
            return response
        

    except Exception as e:
        print(str(e))
        return jsonify({"error": str(e)}), 500
    finally:
        if os.path.exists(filepath):
            os.remove(filepath)


if __name__ == '__main__':
    app.run(port=5010)
