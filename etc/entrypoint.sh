#!/bin/sh
self=/srv/redirector
exec systemd-nspawn                   \
    -D $self/container                \
    -M redirector                     \
    --bind $self/storage:/app/storage \
    --chdir /                         \
    /usr/sbin/php-fpm84 -R
