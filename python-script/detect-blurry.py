import base64
import cv2
import json
import numpy
import urllib.request as urllib


def main():
    # url = 'https://src-dte-lambda.s3.ap-southeast-1.amazonaws.com/image-testing/blurry-dog.png'
    url = 'https://src-dte-lambda.s3.ap-southeast-1.amazonaws.com/image-testing/not-blurry-dog.png'
    
    image = url_to_image(url)
    # image = base64_to_image(file)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    value = variance_of_laplacian(gray)
    
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
	
def variance_of_laplacian(image):
	# compute the Laplacian of the image and then return the focus measure
	# which is simply the variance of the Laplacian
	return cv2.Laplacian(image, cv2.CV_64F).var()

main()