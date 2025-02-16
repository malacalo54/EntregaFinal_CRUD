# PROYECTO CRUD

## Descripción
Este proyecto consiste en mejorar una aplicación funcional que implementa un CRUD con paginación sobre una base de datos MySQL usando PDO. La aplicación sigue el patrón Modelo-Vista-Controlador (MVC) y parte de una tabla de clientes con datos generados desde Mockaroo.

El objetivo es implementar mejoras sin afectar el resto del funcionamiento de la aplicación.

## Mejoras Implementadas

1. Se ha agregado la opción de navegar entre registros (siguiente y anterior) en las vistas de detalles y modificación.
2. Se han mejorado las validaciones en la creación y modificación de clientes:
   - El correo electrónico no puede repetirse.
   - La IP ingresada debe ser válida.
   - El teléfono debe seguir el formato 999-999-9999.
3. Se muestra una imagen asociada al cliente. Si no existe, se genera una aleatoria desde [RoboHash](https://robohash.org/).
4. Se permite subir o cambiar la foto del cliente en la creación y modificación de registros, verificando que sea JPG o PNG y que no supere los 500 KB.
5. Se muestra una bandera del país correspondiente a la IP del cliente, utilizando [IP-API](https://ip-api.com/) y [Flagpedia](https://flagpedia.net/).
6. Se ha mejorado la lista de clientes, permitiendo ordenar por nombre, apellido, correo, género o IP y navegar según este criterio.
7. Se ha agregado la opción de generar un PDF con los detalles completos de un cliente, incluyendo un botón de impresión.
8. Se ha creado una tabla de usuarios con login, contraseña encriptada con SHA-256 y rol (0/1). Se controla el acceso mediante login y password.
9. Se ha implementado un control de acceso según el rol:
   - Rol 0: Solo puede visualizar la lista y los detalles de los clientes.
   - Rol 1: Puede modificar, borrar y gestionar usuarios.
10. Se ha integrado un mapa con [OpenLayers](https://openlayers.org/) para mostrar la ubicación del cliente según su IP.

## Acceso a la Aplicación

🔑 **Usuario:** user1 | **Contraseña:** 123
🔑 **Usuario:** admin | **Contraseña:** 12345

## Conclusión
Todas las mejoras han sido implementadas de acuerdo a los criterios establecidos. La aplicación sigue funcionando correctamente sin afectar la base original.

