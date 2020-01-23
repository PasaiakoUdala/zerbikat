ZERBItzuen KATalogoa
========================

Zerbitzuen katalogoa kudeatzeko aplikazioa. 

Aplikazioaren eskuliburua doc karpeta barruan dago.

Ikus demo bideo bat:

[![Zerbikat aplikazioaren demo bideo bat](http://img.youtube.com/vi/Mbg05GfrS9s/0.jpg)](http://www.youtube.com/watch?v=Mbg05GfrS9s "Zerbikat aplikazioaren demo bideo bat")

## Requirements

    PHP needs to be a minimum version of PHP 5.5.9
    JSON needs to be enabled
    ctype needs to be enabled
    Your php.ini needs to have the date.timezone setting

##### Optional

    You need to have the PHP-XML module installed
    You need to have at least version 2.6.21 of libxml
    PHP tokenizer needs to be enabled
    mbstring functions need to be enabled
    iconv needs to be enabled
    POSIX needs to be enabled (only on *nix)
    Intl needs to be installed with ICU 4+
    APC 3.0.17+ (or another opcode cache needs to be installed)
    php.ini recommended settings
    short_open_tag = Off
    magic_quotes_gpc = Off
    register_globals = Off
    session.auto_start = Off


# Instalaziorako jarraibideak

##### MySQL
``doc/Zerbikat.sql`` fitxategia erabiliz phpmyadmin bidez datu basea sortu.

##### Composer
Jarraitu jarraibideak [hemen](https://getcomposer.org/download/)

##### Repositorioa deskargatu apache zerbitzarian eta liburutegiak instalatu
cd /var/www/
git clone https://github.com/PasaiakoUdala/zerbikat.git zerbikat.dev

cd zerbikat.dev

composer install

Instalazioa amaitu ondoren datu basea, erabiltzailea, izena... datuak eskatuzko dizkigu.

##### Instalazio prozesua amaitu

php bin/console assets:install web --symlink

php bin/console cache:clear --env=prod --no-debug

mkdir -p web/doc

chmod -R 777 web/doc

##### Baimenak zehaztu

sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/logs var/sessions web/doc

sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/logs var/sessions web/doc

##### Erabiltzaile bat sortu eta ROLE_SUPER_ADMIN eman

php bin/console fos:user:create

php bin/console fos:user:promote

##### Apache vhost bat sortu

###### Apache 2.2
    <VirtualHost *:80>
        ServerName www.zerbikat.dev
        ServerAlias zerbikat.dev
        ServerAdmin webmaster@localhost

        DocumentRoot /var/www/zerbikat.dev/web
        <Directory /var/www/zerbikat.dev/web>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride None
            Order allow,deny
            allow from all

            <IfModule mod_rewrite.c>
                RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^(.*)$ /app.php [QSA,L]
            </IfModule>
        </Directory>
    </VirtualHost>


###### Apache 2.4
    <VirtualHost *:80>
        ServerName zerbikat.dev

        DocumentRoot /var/www/zerbikat.dev/web
        <Directory /var/www/zerbikat.dev/web>
            AllowOverride All
            Require all granted
        </Directory>

        <Directory /var/www/zerbikat.dev>
            Options FollowSymlinks
        </Directory>

        ErrorLog /var/log/apache2/zerbikat.dev_error.log
        CustomLog /var/log/apache2/zerbikat.dev_access.log combined
    </VirtualHost>
