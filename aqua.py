"""
Atomic-Quarx-Unboxing-Application
aqua.py

aqua.py is able to deliver the latest build of atomic 
and/or quarx to any directory you choose.

Author: Matt Lantz
"""

import getopt, urllib2, sys, zipfile, os

#Scrap the zip file
def removePackage(package):
	os.remove(package)

#Unzip and dump
def unPackage(package, dest):
    zfile = zipfile.ZipFile(package)
    for name in zfile.namelist():
        (dirName, fileName) = os.path.split(name)
        if fileName == '':
            # directory
            newDir = dest + '/' + dirName
            if not os.path.exists(newDir):
                os.mkdir(newDir)
                print 'adding '+newDir
        else:
            # file
            fd = open(dest + '/' + name, 'wb')
            fd.write(zfile.read(name))
            fd.close()
            print 'adding '+name

    zfile.close()
    removePackage(package)

#find on the interWeb!
def grabPackageAndDeliver(package, target):
	u = urllib2.urlopen('http://ottacon.co/_quarx_/'+package+'.latest.zip')
	localFile = open(target+'/'+package+'.latest.zip', 'w')
	boxedPackage = target+'/'+package+'.latest.zip'
	localFile.write(u.read())
	localFile.close()

	print 'Aquired '+boxedPackage+'...'
	unPackage(boxedPackage, target)

def main(argv):
	package = ''
	target = ''

	try:
		opts, args = getopt.getopt(argv, "hp:t:", ["package=", "target="])
	except getopt.GetoptError:
		print 'aqua.py -p <package> -t <target>'
		sys.exit(2)

	for opt, arg in opts:
		if opt == '':
			print 'aqua.py -p <package> -t <target>'
			sys.exit(2)
		elif opt == '-h':
			print 'aqua.py -p <package> -t <target>'
			sys.exit(2)
		elif opt in ("-p", "--package"):
			package = arg
		elif opt in ("-t", "--target"):
			target = arg
		else:
			print 'aqua.py -p <package> -t <target>'
			sys.exit()

	if package > '' and target > '':
		print 'Collecting '+package+'...'
		grabPackageAndDeliver(package, target);
		print "Deployment of "+package+" at "+target+" is complete."
	else:
		print 'aqua.py -p <package> -t <target>'
		sys.exit()

if __name__ == "__main__":
   main(sys.argv[1:])