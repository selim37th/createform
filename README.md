createform
==========

PHP. conecta a una mysql y crea formulario automáticamente para incrustar en un php o html.


Project: createform.php

Objetivos.
    Crear un php que partiendo de una DB mysql y una determinada tabla, 
    generar un formulario con todos los campos de esa tabla, para incrustar en 
    un php/html.

Requerimientos.
    Entorno de desarrollo local con:
    root.
    mysql.
    apache.
    php.
    

Configuración del servidor.
    apache con un vitual host con nombre: createform

    apache:
    fichero: /etc/apache2/sites-avalible/createform.conf

    #NameVirtualHost createform
    <VirtualHost *:80>
            ServerAdmin webmaster@localhost
            ServerName createform
            DocumentRoot /home/....... proyecto .....
            LogLevel debug
            <Directory />
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Order allow,deny
                    Allow from all
                    Require all granted
            </Directory>
    </VirtualHost>

    enlace en /etc/apache2/sites-enable/
    
    #ln -s /etc/apache2/sites-avalible/createform.conf /etc/apache2/sites-enable

    añadir el virtualhost a /etc/hosts
    
    127.0.0.1   createform

    reset de apache

    #service apache2 restart

    ya en el navegador debe funcionar : http://createform/


    
