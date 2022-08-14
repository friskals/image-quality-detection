import base64
import cv2
import json
import numpy
import urllib.request as urllib
import sys
numpy.set_printoptions(threshold=sys.maxsize)

def main():
    
    url = 'https://src-dte-lambda.s3.ap-southeast-1.amazonaws.com/image-testing/normal-exposed.jpg'
    
    image = url_to_image(url)
    # image = base64_to_image(file)

    value = calculate_exposure_level(image)

    print(value)

def base64_to_image(data):
    res = base64.b64decode(data.split(',')[1])
    image = numpy.fromstring(res, numpy.uint8)
    image = cv2.imdecode(image, cv2.IMREAD_UNCHANGED)
    
    return image

def url_to_image(url):
	res = urllib.urlopen(url)
	image = numpy.asarray(bytearray(res.read()), dtype="uint8")
	image = cv2.imdecode(image, cv2.IMREAD_COLOR)

	return image
    # [[
    #     [128 148 165]
    #     [ 55  71  86]]
    # [
    #     [ 91 105 120]
    #     [ 58  72  88]
    # ]]
	
def calculate_exposure_level(image):
    value = image.mean(axis=2).flatten()
    value = numpy.mean(value)
    
    return value

main()
