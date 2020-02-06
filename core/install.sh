#!/bin/bash
echo 1 > /tmp/compilation_webview_in_progress
sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y --force-yes php-mbstring php-curl
grep miniProxy.php /etc/apache2/sites-enabled/000-default.conf || sudo sed -i 's|</VirtualHost>|        RewriteEngine On\n        RewriteCond "%{HTTP_REFERER}" ".*miniProxy.php\\?(.*)"\n        RewriteRule "(.*)miniProxy.php([^?].*)" "$1miniProxy.php?%1$2\&%{QUERY_STRING}" [PT,L]\n&|' /etc/apache2/sites-enabled/000-default.conf
ls /etc/apache2/mods-available/rewrite.load && ( ls /etc/apache2/mods-enabled/rewrite.load 2>/dev/null || ( sudo ln -s ../mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load && echo mods-enabled/rewrite.load installed ) )
nohup sudo /etc/init.d/apache2 reload &
sleep 3
echo 100 > /tmp/compilation_webview_in_progress
rm /tmp/compilation_webview_in_progress
