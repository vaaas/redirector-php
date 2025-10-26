#!/bin/sh
name=redirector
timestamp=$(date '+%s')
dirname="$name"_"$timestamp"_amd64

mkdir -p  $dirname/DEBIAN             \
          $dirname/etc/systemd/system \
          $dirname/srv/$name/storage  \
cp -r     etc/Caddyfile $name
cp        etc/redirector.service \
          $dirname/etc/systemd/system
mv        container.squashfs $dirname/srv/$name
chmod 755 $dirname/DEBIAN

cat << EOF > $dirname/DEBIAN/control
Package: $name
Version: $timestamp
Architecture: amd64
Maintainer: Vasileios Pasialiokis <vas@tsuku.ro>
Description: url redirect service (link shortener)
Depends: systemd, systemd-container, caddy, dash
EOF

cat << EOF > $dirname/DEBIAN/postinst
systemctl enable --now redirector
systemctl enable --now caddy
EOF

chmod +x $dirname/DEBIAN/postinst

dpkg-deb --build --root-owner-group $dirname
