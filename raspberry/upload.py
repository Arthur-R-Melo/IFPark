import requests

def enviarFoto():
    url = 'https://feiratec.dev.br/ifpark/control/upload.php'
    file_path = 'test/teste.png'

    with open(file_path, 'rb') as file:
        files = {'file': file}
        response = requests.post(url, files=files)

    print(response.text)
