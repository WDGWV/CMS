#!/bin/bash

BASEDIR=$(dirname $0)
echo 'Generating Documentation'
echo $BASEDIR

cd $BASEDIR

mkdir Documentation &>/dev/null

phpDocumentor -t Documentation -d . -i xx_PRIVATE,documentation,build -p --title 'WDGWV CMS Documentation'

open documentation/index.html &>/dev/null
exit &>/dev/null