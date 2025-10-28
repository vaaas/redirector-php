#!/bin/sh
self=/srv/redirector
exec systemd-nspawn                    \
    -D      $self/container            \
    -M      redirector                 \
    --bind  $self/storage:/app/storage \
    --chdir /                          \
    --read-only                        \
    /usr/sbin/php-fpm84 -R
