import requests

def enviarFoto():
    url = 'http://localhost:5010/carDetection'
    file_path = 'teste.jpg'

    with open(file_path, 'rb') as file:
        files = {'imagem': file}
        response = requests.post(url, files=files)

    print(response.text)

enviarFoto()