import cv2

# Define as coordenadas do quadrado (x, y, largura, altura)
square_x = 200
square_y = 200
square_width = 200
square_height = 200

# Inicializa a captura de vídeo (0 para a câmera padrão)
cap = cv2.VideoCapture(0)

while True:
    # Captura frame a frame
    ret, frame = cap.read()
    
    if not ret:
        break
    
    # Desenha um quadrado na imagem
    top_left = (square_x, square_y)
    bottom_right = (square_x + square_width, square_y + square_height)
    color = (0, 255, 0)  # Verde em BGR
    thickness = 2
    cv2.rectangle(frame, top_left, bottom_right, color, thickness)
    
    # Exibe o frame com o quadrado
    cv2.imshow('Camera com Quadrado', frame)
    
    # Sai do loop ao pressionar a tecla 'q'
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Libera a captura e fecha as janelas
cap.release()
cv2.destroyAllWindows()
