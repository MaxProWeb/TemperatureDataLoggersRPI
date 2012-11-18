import os, sys
import time, datetime
import RPi.GPIO as GPIO

if True:
	BTN      = 17 # GPIO BTN
	LED1     = 18 # GPIO
	LED2     = 24 # GPIO
	DeviceId = "/sys/bus/w1/devices/28-000004080b44/w1_slave"
	logFile  = "/home/pi/python/log"
	
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(BTN, GPIO.IN)
	GPIO.setup(LED2, GPIO.OUT)
	GPIO.setup(LED1, GPIO.OUT)
	
	status = False
	
	def setStatus(status):
		if(status == True):
			GPIO.output(LED2, False)
			GPIO.output(LED1, True)
		else:
			GPIO.output(LED2, True)
                	GPIO.output(LED1, False)

	def press():
		return GPIO.input(BTN)

	def getTemp():
		tfile = open(DeviceId) 
		# Read all of the text in the file. 
		text = tfile.read() 
		# Close the file now that the text has been read. 
		tfile.close() 
		# Split the text with new lines (\n) and select the second line. 
		secondline = text.split("\n")[1] 
		# Split the line into words, referring to the spaces, and select the 10th word (counting from 0). 
		temperaturedata = secondline.split(" ")[9] 
		# The first two characters are "t=", so get rid of those and convert the temperature from a string to a number. 
		temperature = float(temperaturedata[2:]) 
		# Put the decimal point in the right place and display it. 
		temperature = temperature / 1000 
		return temperature
	
	def writeLog(c):
		print c
		log = open(logFile, 'a')
		log.write(str(c))
		log.write("|")
		now = datetime.datetime.now()
		log.write(str(now))
		log.write("\n")
		log.close()
		
	while True:
		#print press() # print press status
		if(press() == True):
			status = True
			c = getTemp()
			#print c # print temperature
			writeLog(c)		
		else:
			status = False
		setStatus(status)
		time.sleep(60)
			
