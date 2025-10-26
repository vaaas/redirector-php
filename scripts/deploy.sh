#!/bin/sh
set -e

if test -z "$USER"
then USER=root
fi

if test -z "$DOMAIN"
then exit 1
fi

if test -z "$PORT"
then PORT=22
fi

auth=$USER@$DOMAIN
pkg=`basename *.deb`

echo 'uploading package'
scp -P $PORT $pkg $auth:/root/$pkg

echo 'installing'
ssh -p $PORT $auth dpkg -i /root/$pkg

echo 'cleanup'
ssh -p $PORT $auth rm -v /root/$pkg

echo 'done!'
