#!/bin/sh
set -e

name=redirector-php
build=/tmp/build
timestamp=$(date '+%s')

package() {
  dirname=$build/"$name"_"$timestamp"_amd64
  mkdir -p $dirname/DEBIAN $dirname/srv/$name/storage
  cp -r etc/Caddyfile index.php app $dirname/srv/$name
  chmod 755 $dirname/DEBIAN

  cat << EOF > $dirname/DEBIAN/control
Package: $name
Version: $timestamp
Architecture: musl-linux-amd64
Maintainer: Vasileios Pasialiokis <vas@tsuku.ro>
Description: url redirect service (link shortener)
EOF

  cat << EOF > $dirname/DEBIAN/postinst
#!/bin/sh
chown -R php /srv/$name
EOF
  chmod +x $dirname/DEBIAN/postinst

  dpkg-deb --build --root-owner-group $dirname
}

mkdir -p $build
package
cp $build/*deb .
