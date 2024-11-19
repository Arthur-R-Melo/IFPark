from upload import enviaFoto
from picamera import PiCamera
import time

# Inicializa a câmera
camera = PiCamera()

# Tira a foto e salva em um arquivo

time.sleep(5)
camera.capture('fotos/foto.jpg')

# Finaliza a câmera
camera.close()

enviaFoto()
