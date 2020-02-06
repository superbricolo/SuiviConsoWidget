#!/bin/bash
echo 1 > /tmp/compilation_suiviconsowidget_in_progress
sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y --force-yes php-mbstring php-curl
nohup sudo /etc/init.d/apache2 reload &
sleep 3
echo 100 > /tmp/compilation_suiviconsowidget_in_progress
rm /tmp/compilation_suiviconsowidget_in_progress
