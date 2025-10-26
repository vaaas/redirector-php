#!/bin/sh
set -e

alpine=https://dl-cdn.alpinelinux.org/alpine/v3.22/releases/x86_64/alpine-minirootfs-3.22.2-x86_64.tar.gz
php=php84

mkdir      container

echo       'Downloading alpine'
curl       $alpine > alpine.tar.gz
tar -xf    alpine.tar.gz -C container

echo       'Installing packages'
cp         /etc/resolv.conf container/etc/resolv.conf
chroot     container apk add $php-fpm
rm         container/etc/resolv.conf

echo       'Copying files'
mkdir -p   container/app \
           container/app/storage
cp -r      app       \
           index.php \
           container/app
cp         etc/php-fpm.conf \
           container/etc/$php/php-fpm.conf

echo       'Squashing'
mksquashfs container container.squashfs
