import cv2
from flask import jsonify
import requests
import json
import numpy as np

def identifyCar(image_path,id):
    print(image_path)
    # Carregar a rede YOLO
    net = cv2.dnn.readNet("carDetection/yolov3-tiny.weights", "carDetection/yolov3-tiny.cfg")
    layer_names = net.getLayerNames()
    output_layers = [layer_names[i - 1] for i in net.getUnconnectedOutLayers()]
    classes = []
    with open("carDetection/coco.names", "r") as f:
        classes = f.read().strip().split("\n")

    # Carregar a imagem
    image = cv2.imread(image_path)

    if image is None:
        print("Erro ao carregar a imageme")
        exit()

    height, width, channels = image.shape

    # Criar um blob e enviar para o YOLO
    blob = cv2.dnn.blobFromImage(image, 0.00392, (416, 416), (0, 0, 0), True, crop=False)
    net.setInput(blob)
    outs = net.forward(output_layers)

    temCarro = False
    validPlaca = False
    
    # Analisar as detecções
    for out in outs:
        for detection in out:
            scores = detection[5:]
            class_id = np.argmax(scores)
            confidence = scores[class_id]

            # Filtrar apenas carros com confiança > 50%
            if confidence > 0.3 and classes[class_id] == "car":
                temCarro = True
                url = 'http://52.233.90.226:5000/plate-service'

                with open(image_path, 'rb') as file:
                    files = {'imagem': file}
                    data = {'id' : id}
                    response = requests.post(url, files=files, data=data)
                print(response.text)
                if response.status_code == 200:
                    response = response.json()

                    if 'error' in response:
                        print(response['error'])
                        return jsonify({"status": False}) #TODO
                    else:
                        validPlaca = response['result']
                        return {"status": True, "carro": temCarro, "placa": validPlaca};
                
            
    return {"status": True, "carro": temCarro, "placa": validPlaca}
