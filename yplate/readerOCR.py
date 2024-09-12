import easyocr
import cv2

def leiaPlaca():
    img = cv2.imread("plates\plate00.jpg")
    reader = easyocr.Reader(['en'], gpu=True)
    result = reader.readtext(img)

    for res in result:
        print(f'Texto: {res[1]}')

#teste()