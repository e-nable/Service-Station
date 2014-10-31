#!/bin/bash

############################################################################
# This script helps update the repository with a simple set of flags
# --------------------------------------------------------------------------
# Copy the following to your home for extended use:
# cp update.sh ~; chmod 555 ~/update.sh
# --------------------------------------------------------------------------
# Execute with -h for help:
# ~/update.sh -h
############################################################################

found=false;
webDir=/var/www/html
#webDir=/var/www
backDir=$webDir/e-NABLE

removeFrontend(){
        echo "~ frontend remove";
        #rm -rf $webDir/*
        rm -rf $webDir/*.php
        rm -rf $webDir/lib
        rm -rf $webDir/imgs
        rm -rf $webDir/css
        rm -rf $webDir/js
        cd $webDir
        git checkout -f
}

removeBackend(){
        echo "~ backend remove";
        rm -rf $backDir/*
        cd $backDir
        git checkout -f
}

frontendUpdate (){
        echo "~ frontend update";
        cd $webDir
        git pull
        chmod -R 755 *
        chmod -R 777 imagecache log.txt ticket update.log
};

backendUpdate (){
        echo "~ backend update";
        cd $backDir
        git pull
        chmod -R 755 *
};

hardUpdate (){
        echo "~ hardUpdate";
        removeBackend;
        removeFrontend;
        mkdir -p $webDir/imagecache;
        touch log.txt;
        backendUpdate;
        frontendUpdate;
};

simpleUpdate (){
        echo "~ simple update reached";
        backendUpdate;
        frontendUpdate;
};

printHelp (){
        echo " This tool helps you pull from github to update to latest and greatest."
        echo " The following options are available:"
        echo "    -h    Prints this information"
        echo "    -b    Updates backend code only"
        echo "    -w    Updates web frontend code only"
        echo "    -s    Updates both web frontend and backend"
        echo "    -f    Clears the directories and forces"
        echo "          all new information to be pulled"
        echo 
};

if [ $# -eq 0 ] ; then
        printHelp;
else
        case "$1" in
                "-h") found=true; printHelp; ;;
                "-f") found=true; hardUpdate; ;;
                "-s") found=true; simpleUpdate; ;;
                "-b") found=true; backendUpdate; ;;
                "-w") found=true; frontendUpdate; ;;
                *)    printHelp;;
        esac
fi
