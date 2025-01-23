# -*- coding: utf-8 -*-

import cv2
import numpy as np
import time
from upload import enviarFoto
import protoboard

statusPortao = False

def detectMovment():
    # Define as coordenadas do quadrado (x, y, largura, altura)
    square_x = 300
    square_y = 400
    square_width = 100
    square_height = 100

    # Inicializa a captura de v�deo com libcamera via GStreamer
    pipeline = (
    "libcamerasrc ! video/x-raw, width=640, height=480, framerate=30/1 ! "
    "videoconvert ! appsink"
    )
    cap = cv2.VideoCapture("C:/Users/0068943/Desktop/video98.mp4")

    # Lê o primeiro frame
    ret, prev_frame = cap.read()

    while True:
        # Captura frame a frame
        ret, frame = cap.read()
        
        if not ret:
            break
        
        # Recorta a área de interesse (ROI) do frame atual e do frame anterior
        roi_current = frame[square_x:square_x+square_width, square_y:square_y+square_height]
        roi_prev = prev_frame[square_x:square_x+square_width, square_y:square_y+square_height]

        # Converte as ROIs para escala de cinza
        roi_current_gray = cv2.cvtColor(roi_current, cv2.COLOR_BGR2GRAY)
        roi_prev_gray = cv2.cvtColor(roi_prev, cv2.COLOR_BGR2GRAY)
        
        # Calcula a diferença absoluta entre os frames
        diff = cv2.absdiff(roi_current_gray, roi_prev_gray)
        
        # Calcula a soma das diferenças
        change = np.sum(diff)
        
        # Define um limiar para mudança significativa
        threshold = 100000  # Ajuste este valor conforme necessário
        
        # Verifica se a mudança é significativa
        if change > threshold:
            print("Mudança significativa detectada!")
            color = (0, 0, 255)  # Vermelho em BGR
            cv2.imwrite("frame.jpg", frame)
            response = enviarFoto()
            controlaPortao(response)
        else:
            color = (0, 255, 0)  # Verde em BGR
        
        # Desenha um quadrado na imagem
        top_left = (square_x, square_y)
        bottom_right = (square_x + square_width, square_y + square_height)
        thickness = 2
        cv2.rectangle(frame, top_left, bottom_right, color, thickness)
        
        # Exibe o frame com o quadrado
        cv2.imshow('Camera com Detecção de Mudança', frame)

        # Atualiza o frame anterior
        prev_frame = frame.copy()
        
        # Sai do loop ao pressionar a tecla 'q'
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

    # Libera a captura e fecha as janelas
    cap.release()
    cv2.destroyAllWindows()


def controlaPortao(jaison):
    global statusPortao
    if jaison["status"] == True:
        if statusPortao == False and jaison["placa"] == True:
            protoboard.abrePortao()
            time.sleep(5)
            statusPortao = True
            exit()
        elif statusPortao == True and jaison['carro'] == False:
            protoboard.fechaPortao()
            statusPortao = False
        else:
            print("nada")
        time.sleep(0)

detectMovment()

