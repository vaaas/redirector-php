#!/bin/sh
set -e

name=redirector
timestamp=$(date '+%s')

echo 'note that you might want to run this with admin rights'

cleanup() {
  echo 'cleaning up'
  rm -r build
}

container() {
  mkdir -p container

  echo 'downloading alpine'
  curl https://dl-cdn.alpinelinux.org/alpine/v3.20/releases/x86_64/alpine-minirootfs-3.20.3-x86_64.tar.gz > alpine.tar.gz

  echo 'creating base container'
  tar -xf alpine.tar.gz -C container
  systemd-nspawn -D container apk add php83-fpm

  echo 'copying source code and configuration'
  mkdir -p container/app
  cp ../src/* container/app
  cp ../etc/php-fpm.conf container/etc/php83/php-fpm.conf

  echo 'creating image'
  mksquashfs container/ container.squashfs
}

package() {
  echo 'creating debian package'
  dirname="$name"_"$timestamp"_amd64
  mkdir -p $dirname/DEBIAN $dirname/srv/$name/storage
  cp ../etc/Caddyfile ../etc/entrypoint container.squashfs $dirname/srv/$name
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
EOF
  chmod +x $dirname/DEBIAN/postinst

  dpkg-deb --build --root-owner-group $dirname
}

cleanup
mkdir -p build
cd build
container
package
cd ..
echo 'done!'
