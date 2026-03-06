#!/bin/bash
PWD= `pwd`

echo "-- Generating migration file --"
../vendor/bin/doctrine-module migrations:diff

if [ $? != 0 ]; then
    echo 'There was an error creating the migration file'
    exit -1
else
    echo "-- migrating generated file--"
    ../vendor/bin/doctrine-module migrations:migrate 
    if [ $? != 0 ]; then
        echo 'generated file could not be migrated'
        exit -1
    fi

fi
