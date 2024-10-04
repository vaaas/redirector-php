echo 'note that you might want to run this with admin rights'

echo 'cleaning up'
rm -r build

mkdir -p build

echo 'downloading alpine'
curl https://dl-cdn.alpinelinux.org/alpine/v3.20/releases/x86_64/alpine-minirootfs-3.20.3-x86_64.tar.gz > build/alpine.tar.gz

echo 'creating base container'
mkdir -p build/redirector
tar -xf build/alpine.tar.gz -C build/redirector
systemd-nspawn -D build/redirector apk add php83-fpm

echo 'copying source code and configuration'
mkdir -p build/redirector/opt/redirector
cp src/* build/redirector/opt/redirector
cp etc/php-fpm.conf build/redirector/etc/php83/php-fpm.conf

echo 'creating image'
mksquashfs build/redirector/ build/redirector.squashfs

echo 'done'
