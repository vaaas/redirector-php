#!/bin/sh

user=root
domain=sexualise.it
auth=$user@$domain

echo 'uploading container'
scp build/redirector.squashfs $auth:/var/lib/machines

echo 'uploading systemd service'
scp etc/redirector.service $auth:/etc/systemd/system

echo 'uploading caddyfile'
scp etc/redirector.caddy $auth:/etc/caddy

echo 'reloading systemd daemons'
ssh $auth systemctl daemon-reload

echo 'restarting container'
ssh $auth systemctl restart redirector

echo 'restarting caddy'
ssh $auth systemctl restart caddy
