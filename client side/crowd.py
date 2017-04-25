import requests
from multiprocessing import Pool
import random
import signal

import sys
num_processes = int(sys.argv[1])

server = 'https://shielded-wildwood-60311.herokuapp.com/'
def sendRequest():
	i = int(random.uniform(0,3))
	if i == 0:
		requests.get(server+'/static')
	else:
		r = random.randint(0,499999)+1
		if i == 1:
			r += 500000
		requests.get(server+'dynamic?user=user'+str(r)+'&pass=pass'+str(r))

def sendRequests():
	while True:
		sendRequest()

def stopRequests(pool):
	print 'Killing processes'
	sys.stdout.flush()
	pool.terminate()
	sys.exit(0)

p = Pool(processes=num_processes)
signal.signal(signal.SIGINT, lambda s,f: stopRequests(p))
print "Crowding server at "+server+" using "+str(num_processes)+" processes"
p.apply(sendRequests(),range(num_processes))
