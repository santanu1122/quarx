"""
build.py
Author: Matt Lantz

A build tool for websites/apps with version numbering based on builds
"""

import os
import datetime
import shutil
import sys
import getopt
from contextlib import closing
from zipfile import ZipFile, ZIP_DEFLATED

skippedFileCount = 0
deployedFileCount = 0
totalFileCount = 0

def zipdir(basedir, archivename):
    assert os.path.isdir(basedir)
    with closing(ZipFile(archivename, "w", ZIP_DEFLATED)) as z:
        for root, dirs, files in os.walk(basedir):
            for fn in files:
                absfn = os.path.join(root, fn)
                zfn = absfn[len(basedir)+(len(os.sep)-1):]
                z.write(absfn, zfn)
                print "Archived "+zfn+"..."

def getIgnoredFiles(source):
    f = source+"/.build_ignore.txt"
    igf = open(f, "r+")
    if igf:
        igfr = igf.read()
        res = igfr.split()
        return res
    
    print "Collected list of ignored files..."

def getVersion(source):
    v = updateVersion(source)
    if v:
        return v;
    else:
        return "N/A"

def updateVersion(source):
    f = source+"/.version_build.txt"
    vf = open(f, "r+")
    cv = vf.read()

    nv = (float(cv) + 0.001)
    vf = open(f, "w+")

    vf.write(str(nv))
    vf.close()
    return str(nv)

def copyForDeployment(source, build, ignored):
    lof = os.listdir(source)

    global skippedFileCount
    global deployedFileCount
    global totalFileCount

    for f in lof:
        if f not in ignored:
            if os.path.isdir(source+f):
                if os.path.isdir(build+f):
                    print build+f+" already exists..."
                else:
                    os.makedirs(build+f)
                    print "made "+build+f+"..."

                copyForDeployment(source+f+"/", build+f+"/", ignored)

            else:
                shutil.copy(source+f, build+f)
                print "Deployed - "+f+"..."
                deployedFileCount += 1
                totalFileCount += 1
        else:
            print "Skipped - "+f+"..."
            skippedFileCount += 1
            totalFileCount += 1

def stampBuildDate(build, version, fileCount):
    d = datetime.datetime.now()
    v = float(version)
    vn = v + 0.1
    if not os.path.exists(build+".build.txt"):
        f = file(build+".build.txt", "w")
    with open(build+".build.txt","a+") as f:
        f.write("Version: "+str(vn)+" ---- Build: "+str(d)+" ---- "+str(fileCount)+" files deployed"+"\n")
        print "Stamping build..."

def main(argv):

    global skippedFileCount
    global deployedFileCount
    global totalFileCount

    skippedFileCount = 0
    deployedFileCount = 0
    totalFileCount = 0
    d = datetime.datetime.now()

    try:
        opts, args = getopt.getopt(argv,"hp:",["package="])
    except getopt.GetoptError:
        print 'type -h for help\nor -p for a package to deploy'
        sys.exit(2)
    if not opts:
        print 'type -h for help'
        sys.exit(2)

    for opt, arg in opts:
        if opt == '-h':
            print 'build.py -p <package for deployment>'
            sys.exit()
        elif opt in ("-p", "--package"):
            package = arg

        dur = os.path.dirname(os.path.realpath(__file__))
        buildPath = dur+"/_deploy/"
        sourcePath = dur+"/"+package+"/"

        if not os.path.exists(buildPath): 
            os.makedirs(dur+"/_deploy")
        else:
            if not os.path.exists(dur+"/_archives"):
                os.makedirs(dur+"/_archives")

            print "Zipping old deployment..."
            zipdir(buildPath, "_archives/archive-"+str(d)+".zip")
            print "Old deployment archived successfully..."

        # Get the files to ignore
        ignored = getIgnoredFiles(sourcePath)
        # Get the version
        version = getVersion(sourcePath)
        # Copy only the files that matter.
        copyForDeployment(sourcePath, buildPath, ignored)
        # Stamp the build so we know when it was last worked on.
        stampBuildDate(buildPath, version, deployedFileCount)

        percentage = (deployedFileCount / float(totalFileCount))*100

        print "Build Complete.\nSkipped "+str(skippedFileCount)+" Files and Deployed "+str(deployedFileCount)+". Total Number of Files: "+str(totalFileCount)+"\n"+"Successfully deployed "+str('%.2f' % percentage)+"%"+" of files of version "+version+"."

if __name__ == "__main__":
   main(sys.argv[1:])