import requests
import sys
import time
def client(u,p):
	timer = time.time
	start_ref = timer()
	requests.get('https://shielded-wildwood-60311.herokuapp.com/static')
	end_ref = timer()
	start_query = timer()
	requests.get('https://shielded-wildwood-60311.herokuapp.com/dynamic?user='+u+'&pass='+p)
	end_query = timer()
	return ((end_query-start_query),(end_ref-start_ref))
	
if __name__ == "__main__":
	(query,ref) = client(sys.argv[1],sys.argv[2])
	print 'query: '+str(query)+'\nreference: '+str(ref)
