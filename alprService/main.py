from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/plate-service')
def index():
    return "<h1>Teste</h1>"

# Inicia o servidor
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
