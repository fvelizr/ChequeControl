# Aplicacion desarrollada por:
  # Edmundo Abraham Guerrero Morataya
  # Emely Andrea Espinoza Pérez
  # Erick Alberto Velásquez Castillo
  # Felipe Inocencio Veliz Rabanales

# Plantilla Base MVC

Esta plantilla es el modelo básico de programación MVC(Modelo Vista Controlador),
la arquitectura sigue los patrones similares a los que muchos Frameworks utilizan hoy en día con funciones básicas para comenzar proyectos en PHP, aportando de manera sencilla la base para entender el MVC.

La estructura de directorios es esta:
  - app
    - base -> Librerías base de la plantilla
    - config -> Algunas configuraciones y cargadores
    - controllers -> controladores de la aplicación
    - models -> modelos de la aplicación
    - views -> vistas de la aplicación
  - public
    - css -> Hojas de estilo
    - files -> Archivos varios
    - img -> Imágenes
    - js -> JavaScript

La aplicación utiliza el modrewrite de apache para tener las url más amigables y se apunta a el directorio public para mayor seguridad, ocultando la lógica del exterior manteniendo solo acceso a este directorio (public), el cual se utiliza para tener los archivos de estilos, javascript entre otros publicamente.

### Instalación
Para instalarlo necesitas descargarlo o clonarlo desde [Github](https://github.com/Phoenix2140/plantilla-mvc), seguiremos los pasos de instalación desde linux (debian/ubuntu). Esta es la version original.

El repositorio actual, es para un proyecto de UMG, ESCUINTLA.

Luego necesitas configurar un VirtualHost en apache y habilitar el module_rewrite, editando por ejemplo  /etc/apache2/sites-available/mcv.dev.conf , siguiendo los pasos a consinuación:

Buscamos en nuestro archivo la siguiente linea y le quitamos el simbolo #

#LoadModule rewrite_module modules/mod_rewrite.so


```sh
#Virtual Host agregado para el proyecto de base de datos
<VirtualHost *:8080>
        #nombre del host de la máquina virtual
        #Agregar la dirección "127.0.0.1  mvc.dev" en el archivo /etc/hosts
        #o realizar la configuración como deseen
        ServerName chequecontrol.com

        ServerAdmin webmaster@localhost
        #Document Root y Directory deben apuntar con la dirección total a la 
        #carpeta public dentro de mvc
        DocumentRoot C:/AppServ/www/ChequeControl/public
        <Directory C:/AppServ/www/ChequeControl/public>	
                Allow from all
                Order allow,deny
                Options Indexes Multiviews FollowSymLinks
                AllowOverride ALL
		Require all granted
        </Directory>
</VirtualHost>

```
Hacer este paso si usan linux: Root activamos el módulo modrewrite y la página
```sh
$ a2enmod rewrite
$ a2ensite mcv.dev.conf
$ service apache2 restart
```

SI NO USAN LINUX, REINICIEN EL SERVIDOR APACHE.

### Instalación alternativa
Si tuvieron problemas con la instalación es posible lanzar un servidor directamente desde PHP, para hacerlo tienen que ir al directorio "public" dentro de la ruta de su proyecto, a continuación ejecutan el siguiente comando en el terminal ( desde la carpeta public ):
```sh
$ php -S localhost:8080
```
Luego para acceder a su proyecto ingresan a la url http://localhost:8080 , No se olviden de agregar esa dirección en la configuración de su proyecto.
```
