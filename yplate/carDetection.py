import cv2
import numpy as np

# Carregar a rede YOLO
net = cv2.dnn.readNet("yolov3-tiny.weights", "yolov3-tiny.cfg")
layer_names = net.getLayerNames()
output_layers = [layer_names[i - 1] for i in net.getUnconnectedOutLayers()]
classes = []
with open("coco.names", "r") as f:
    classes = f.read().strip().split("\n")

# Carregar o vídeo
video_path = "video.mp4"
cap = cv2.VideoCapture(video_path)

# Configurar o buffer para evitar saltos
cap.set(cv2.CAP_PROP_BUFFERSIZE, 1)

if not cap.isOpened():
    print("Erro ao carregar o vídeo")
    exit()

while True:
    ret, frame = cap.read()
    if not ret:
        print("Fim do vídeo ou erro ao ler o frame")
        break

    frame = cv2.resize(frame, (640, 480))  # Reduzir a resolução para melhorar a performance
    height, width, channels = frame.shape

    # Criar um blob e enviar para o YOLO
    blob = cv2.dnn.blobFromImage(frame, 0.00392, (416, 416), (0, 0, 0), True, crop=False)
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
                center_x = int(detection[0] * width)
                center_y = int(detection[1] * height)
                w = int(detection[2] * width)
                h = int(detection[3] * height)

                # Calcular coordenadas do retângulo
                x = max(0, int(center_x - w / 2))
                y = max(0, int(center_y - h / 2))

                # Desenhar retângulo ao redor do carro
                cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)

                # Adicionar texto "Carro" acima do retângulo
                label = f"Carro: {confidence:.2f}"
                cv2.putText(frame, label, (x, y - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)

    # Mostrar o frame com os carros marcados
    cv2.imshow("Detecção de Carros", frame)

    # Controle do loop: pressione 'q' para sair
    if cv2.waitKey(30) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAll
