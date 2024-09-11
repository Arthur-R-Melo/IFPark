import easyocr
import cv2

def test():
    img = cv2.imread('plates\plate00.jpg')
    
    reader = easyocr.Reader(['en'], gpu=True)
    result = reader.readtext(img)
    
test()