## Plate-Scan ---------

## Detect car/vehicle Number plates easily

import shutil
import os
from commands import detect
from ops import model_config,display_top,load_model
cfg,weights,classes = load_model()

if('plates' in os.listdir('./')):
    shutil.rmtree('plates')


img = "images/car.jpg"
hide_img = False
save_img = True
hide_out = False			



## Detect
detect(img,cfg,weights,classes,save_img,hide_img,hide_out)
