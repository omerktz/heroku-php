import sys
with open('web/users.txt','w') as f:
	for i in range(1,int(sys.argv[1])+1):
		f.write('user0'+str(i).zfill(9)+':pass0'+str(i).zfill(9)+'\n')

