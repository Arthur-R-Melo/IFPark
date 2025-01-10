import requests

def enviarFoto():
    #url = 'https://52.233.90.226:5010/carDetection'
    url = 'http://localhost:5010/carDetection'
    file_path = 'frame.jpg'

    with open(file_path, 'rb') as file:
        data = {'id' : "1"}
        files = {'imagem': file}
        response = requests.post(url, files=files, data=data)

    print(response.text)
    return response
