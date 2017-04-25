from client import client
import sys
import numpy
u = sys.argv[1]
p = sys.argv[2]
num_reps = int(sys.argv[3])
def print_now(s,newline=True):
	if newline:
		print s
	else:
		print s,
	sys.stdout.flush()
print_now('initializing...\t',False)
client(u,p)
print_now('Done!')
print_now('sampling...')
vals = []
for i in range(num_reps):
	print_now('\r\t'+str(i+1)+'/'+str(num_reps),False)
	vals.append(client(u,p))
print_now('\nDone!\n')
querys = map(lambda x:x[0],vals)
refs = map(lambda x:x[1],vals)
print 'query: '+str(numpy.mean(querys))+'  ('+str(numpy.std(querys))+')'
print 'reference: '+str(numpy.mean(refs))+'  ('+str(numpy.std(refs))+')'
print '(averaged over '+str(num_reps)+' repetitions)'
