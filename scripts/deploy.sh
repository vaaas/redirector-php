#!/bin/sh
user=root
domain=sexualise.it
auth=$user@$domain
pkg=`basename *.deb`

echo 'uploading package'
scp $pkg $auth:/root/$pkg

echo 'installing'
ssh $auth apt install /root/$pkg

echo 'cleanup'
ssh $auth rm -v /root/$pkg

echo 'done!'
