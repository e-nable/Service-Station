#!/bin/bash

# Name of new directory
# - will be directly reflected in www
newDir=dev;

# Repo names to be used from github
assemblyRepo=dev;
uiRepo=development;

# Standard - change if personal config is different
webHome=/var/www/html;
baseCodeDir=/var/code;

## Do not modify
workingDir=$baseCodeDir/$newDir;
updateScript="update$newDir.sh";
escapedDir=`echo $workingDir/Service-Station | sed -e 's/\//\\\\\//g'`;

mkdir $workingDir;
cd $workingDir;

git clone -b $assemblyRepo https://github.com/e-nable/Assembler.git;
git clone -b $uiRepo https://github.com/e-nable/Service-Station.git;

cd Service-Station;
git config core.fileMode false;

ln -s ../Assembler e-NABLE;
git config core.fileMode false;

## Copy update script to user home directory

cp $workingDir/Service-Station/config_default.php $workingDir/Service-Station/config.php

cd $workingDir/Service-Station;
chmod 755 * -R;

mkdir imagecache; touch log.txt; touch update.log;

chmod 777 log.txt imagecache ticket update.log;

## Linking dev directory structure

cd $webHome; ln -s $workingDir/Service-Station $newDir;

## Copy update script to user home directory

cp $workingDir/Service-Station/update.sh ~/$updateScript;

chmod 755 ~/$updateScript;

perl -i -pe"s/webDir=\/var\/www\/html/webDir=$escapedDir/g" ~/$updateScript;

echo 
echo "---------------------------------------------------------"
echo "The following must be configured with the corresponding "
echo " web location for email URL:"
echo "---------------------------------------------------------"
echo "  $workingDir/Service-Station/config.php"
echo
echo "---------------------------------------------------------"
echo "Please update crontab with the following information:"
echo "---------------------------------------------------------"
echo
echo "0,10,20,30,40,50 * * * *  ~/$updateScript -s >> $workingDir/Service-Station/update.log 2>&1"
echo


