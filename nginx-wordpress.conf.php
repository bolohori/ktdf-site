index             index.html index.php;

gzip              on;
gzip_vary         on;
gzip_proxied      any;
gzip_min_length   1k;
gzip_buffers      16 8k;
gzip_http_version 1.1;
gzip_comp_level   9;
gzip_types        text/plain
                  text/javascript
                  text/css
                  text/xml
                  image/jpeg
                  application/json
                  application/javascript
                  application/atom+xml
                  application/rss+xml
                  application/x-javascript
                  application/xml
                  application/xhtml+xml
                  application/x-font-ttf
                  image/svg+xml
                  ;


# Global restrictions configuration file.
# Designed to be included in any server {} block.
location = /favicon.ico {
	log_not_found off;
	access_log off;
}

location = /robots.txt {
	allow all;
	log_not_found off;
	access_log off;
}

# Deny all attempts to access hidden files such as .htaccess, .htpasswd, .DS_Store (Mac).
# Keep logging the requests to parse later (or to pass to firewall utilities such as fail2ban)
location ~ /\. {
	deny all;
}

# Deny access to any files with a .php extension in the uploads directory
# Works in sub-directory installs and also in multisite network
# Keep logging the requests to parse later (or to pass to firewall utilities such as fail2ban)
location ~* /(?:uploads|files)/.*\.php$ {
	deny all;
}

location /wp-content/ {
	root "<?=getenv("HEROKU_APP_DIR")?>";
}

# WordPress single site rules.
# Designed to be included in any server {} block.

# This order might seem weird - this is attempted to match last if rules below fail.
# http://wiki.nginx.org/HttpCoreModule
location / {
	try_files $uri $uri/ /index.php?$args;
}

# Add trailing slash to */wp-admin requests.
rewrite /wp-admin$ $scheme://$host$uri/ permanent;

# Directives to send expires headers and turn off 404 error logging.
#location ~* ^.+\.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|rss|atom|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf)$ {
#  access_log off;
#  log_not_found off;
#  expires 30d;
#}

location ~* \.(?:eot|oft|ttf|woff2?)$ {
  root "<?=getenv("HEROKU_APP_DIR")?>";
  add_header Access-Control-Allow-Origin *;
  add_header Cache-Control public;
  expires max;
  access_log off;
  log_not_found off;
}

location ~* \.(?:jpg|jpeg|gif|png|ico|bmp|svg|svgz)$ {
  root "<?=getenv("HEROKU_APP_DIR")?>";
  add_header Cache-Control public;
  expires 14d;
  access_log off;
  log_not_found off;
}

location ~* \.(?:mp3|mp4|m4a|wav|zip|doc|xls|rtf)$ {
  root "<?=getenv("HEROKU_APP_DIR")?>";
  add_header Cache-Control public;
  expires 30d;
  access_log off;
  log_not_found off;
}
