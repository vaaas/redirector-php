#!/bin/sh
set -e

name=redirector
build=/tmp/build
timestamp=$(date '+%s')

container() {
  mkdir -p $build/container
  curl https://dl-cdn.alpinelinux.org/alpine/v3.20/releases/x86_64/alpine-minirootfs-3.20.3-x86_64.tar.gz > $build/alpine.tar.gz
  tar -xf $build/alpine.tar.gz -C $build/container
  cp /etc/resolv.conf $build/container/etc/resolv.conf
  chroot $build/container apk add php83-fpm
  mkdir -p $build/container/app
  cp -r ./src/* $build/container/app
  cp ./etc/php-fpm.conf $build/container/etc/php83/php-fpm.conf
  rm $build/container/etc/resolv.conf
  mksquashfs $build/container/ $build/container.squashfs
}

package() {
  dirname=$build/"$name"_"$timestamp"_amd64
  mkdir -p $dirname/DEBIAN $dirname/srv/$name/storage
  cp ./etc/Caddyfile ./etc/entrypoint $build/container.squashfs $dirname/srv/$name
  chmod 755 $dirname/DEBIAN

  cat << EOF > $dirname/DEBIAN/control
Package: $name
Version: $timestamp
Architecture: amd64
Maintainer: Vasileios Pasialiokis <vas@tsuku.ro>
Description: url redirect service (link shortener)
Depends: systemd, systemd-container, caddy, dash
EOF

  cat << EOF > $dirname/DEBIAN/preinst
#!/bin/sh
systemctl stop container@redirector
systemctl stop caddy
EOF
  chmod +x $dirname/DEBIAN/preinst

  cat << EOF > $dirname/DEBIAN/postinst
systemctl start container@redirector
systemctl start caddy
if ! test -f /srv/$name/storage/configuration.php
then
    echo 'No configuration file found. Generating one for you.'
    cat << INNER > $/srv/$name/storage/configuration.php
<?php
return [
    "authUsername" => "admin",
    "authPassword" => $(tr -dc A-Za-z0-9 </dev/urandom | head -c 20),
];
INNER
fi
EOF
  chmod +x $dirname/DEBIAN/postinst

  dpkg-deb --build --root-owner-group $dirname
}

mkdir -p $build
container
package
cp $build/*deb .
