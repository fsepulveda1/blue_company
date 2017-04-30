Prueba Symfony Blue Company
===========================

Como instalar 
--------------

  * Clonar proyecto de github
  * Utilizar composer para instalar dependencias (composer update)
  * Ejecutar comandos de base de datos (php bin/console d:d:c, d:s:u --force, d:f:l)
  * Ejecutar php bin/console server:start e ingresar a la ruta impresa en consola.


Que Probar 
--------------
  * La página inicial es un listado de productos.
  * Los productos se almacenan en la base de datos
  * Las imagenes se guardan en la carpeta /web/uploads (necesita permisos)
  * Al crear un nuevo producto, si la categoría es 'Alimentos', se despliega un formulario embebido (cargado con AJAX)
  el cual contiene fecha de elaboración y expiración.
  * Para ver el detalle de un producto guardado, se debe hacer clic en el nombre.