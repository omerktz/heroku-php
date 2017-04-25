import sys
with open('web/users.txt','w') as f:
	for i in range(1,int(sys.argv[1])+1):
		print '\r'+str(i).zfill(len(sys.argv[1]))+'/'+sys.argv[1],
		f.write('user'+str(i).zfill(6)+':pass'+str(i).zfill(6)+'\n')
print ''
