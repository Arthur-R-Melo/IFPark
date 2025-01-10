import cv2
from flask import jsonify
import requests
import json
import numpy as np

def identifyCar(image_path):
    print(image_path)
    # Carregar a rede YOLO
    net = cv2.dnn.readNet("yolov3-tiny.weights", "yolov3-tiny.cfg")
    layer_names = net.getLayerNames()
    output_layers = [layer_names[i - 1] for i in net.getUnconnectedOutLayers()]
    classes = []
    with open("coco.names", "r") as f:
        classes = f.read().strip().split("\n")

    # Carregar a imagem
    image = cv2.imread(image_path)

    if image is None:
        print("Erro ao carregar a imagem")
        exit()

    height, width, channels = image.shape

    # Criar um blob e enviar para o YOLO
    blob = cv2.dnn.blobFromImage(image, 0.00392, (416, 416), (0, 0, 0), True, crop=False)
    net.setInput(blob)
    outs = net.forward(output_layers)

    # Analisar as detecções
    for out in outs:
        for detection in out:
            scores = detection[5:]
            class_id = np.argmax(scores)
            confidence = scores[class_id]

            temCarro = False
            validPlaca = False
            # Filtrar apenas carros com confiança > 50%
            if confidence > 0.4 and classes[class_id] == "car":
                temCarro = True
                url = '52.233.90.226:5000/plate-service'

                with open(image_path, 'rb') as file:
                    files = {'imagem': file}
                response = requests.post(url, files=files)

                if response.status_code == 200:
                    response.json()

                    if 'errror' in response:
                        return jsonify({"status": False}) #TODO
                    else:
                        validPlaca = response['result']
                
            
    return jsonify({"status": True, "carro": temCarro, "placa": validPlaca})
