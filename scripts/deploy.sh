#!/bin/sh
if test -z "$USER"
then USER=root
fi

if test -z "$DOMAIN"
then DOMAIN=sexualise.it
fi

auth=$USER@$DOMAIN
pkg=`basename *.deb`

echo 'uploading package'
scp $pkg $auth:/root/$pkg

echo 'installing'
ssh $auth apt install /root/$pkg

echo 'cleanup'
ssh $auth rm -v /root/$pkg

echo 'done!'
