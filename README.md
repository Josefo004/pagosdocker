# DOCKER

## Como crear la Imagen
~~~bash
docker build -t editpagos:1.0.0 .
~~~ 

El argumento `build -t` le pone un mombre a la imagen en nuestro caso se denomina `editpagos:1.0.0` el `.` indica la ruta hacia el archivo `Dockerfile` en nuestro caso es la carpeta actual por eso solo colocamos punto (`.`)

## Como ejecutar la imagen
~~~bash
 docker run -d --name editPagos -p 4051:80 -v /home/jose/editar-pagos:/var/www/html editpagos:1.0.0
~~~

`docker run` ejecuta la imagen 

## Como hacemos las pruebas 
La imagen se conecta con el servidor de base de datos de prueba que esta en el server `192.168.200.64`
- usuario `postgres`
- contraseña `p0sTgr35*gadCH.`
- base de datos `pagosmigrado`  

Estos datos se pueden verificar y/o modificar en el archivo `database.php`
