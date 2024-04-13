#!/bin/sh

user=root
domain=sexualise.it
auth=$user@$domain
container=/var/lib/machines/apps
appdir=$container/opt/redirector

ssh $auth mkdir -p $appdir
scp -r src/* root@sexualise.it:$appdir
