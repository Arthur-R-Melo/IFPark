import requests

def enviarFoto():
    #url = 'https://52.233.90.226:5010/carDetection'
    url = 'https://52.233.90.226:5010/carDetection'
    file_path = 'teste.jpg'

    with open(file_path, 'rb') as file:
        files = {'imagem': file}
        response = requests.post(url, files=files)

    print(response.text)
