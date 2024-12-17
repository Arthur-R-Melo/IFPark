import cv2
import numpy as np

def identifyCar(image_path):
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

            # Filtrar apenas carros com confiança > 50%
            if confidence > 0.5 and classes[class_id] == "car":
                return True
            else:
                return False