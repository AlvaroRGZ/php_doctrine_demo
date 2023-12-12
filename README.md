MiW: Doctrine - Gestión de Resultados
======================================

[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Minimum PHP Version](https://img.shields.io/badge/php-%5E8.2-blue.svg)](http://php.net/)

> 🎯 Ejemplo ORM Doctrine

Para desarrollar una sencilla gestión de datos se ha utilizado
el ORM [Doctrine][doctrine]. Doctrine 2 es un Object-Relational Mapper que proporciona
persistencia transparente para objetos PHP. Utiliza el patrón [Data Mapper][dataMapper]
con el objetivo de obtener un desacoplamiento completo entre la lógica de negocio y la
persistencia de los datos en los sistemas de gestión de bases de datos.

Para su configuración, este proyecto se apoya en el componente [Dotenv][dotenv], que
permite realizar la configuración a través de variables de entorno. De esta manera,
cualquier configuración que pueda variar entre diferentes entornos puede ser establecida
en variables de entorno, tal como se aconseja en la metodología [“The twelve-factor app”][12factor].

## 🛠️ Instalación de la aplicación

El primer paso consiste en generar un esquema de base de datos vacío y un usuario/contraseña con privilegios completos sobre dicho esquema.

A continuación se deberá crear una copia del fichero `./.env` y renombrarla
como `./.env.local`. Después se debe editar dicho fichero y modificar las variables `DATABASE_NAME`,
`DATABASE_USER` y `DATABASE_PASSWD` con los valores generados en el paso anterior (el resto de opciones
pueden quedar como comentarios). Una vez editado el anterior fichero y desde el directorio raíz del
proyecto se deben ejecutar los comandos:
```
$ composer update
$ ./bin/doctrine orm:schema-tool:update --dump-sql --force
```
Para verificar la validez de la información de mapeo y la sincronización con la base de datos:
```
$ ./bin/doctrine orm:validate-schema
```

## 🗄️ Estructura del proyecto:

A continuación se describe el contenido y estructura del proyecto:

* Directorio `/bin`:
    - Ejecutables (*doctrine* y *phpunit*)
* Directorio `/config`:
    - `config/cli-config.php`: configuración de la consola de comandos de Doctrine
* Directorio `/src`:
    - Subdirectorio `src/Entity`: entidades PHP (incluyen atributos de mapeo del ORM)
    - Subdirectorio `src/scripts`: scripts de ejemplo
* Directorio `/public`:
    - Raíz de documentos del servidor web
    - `public/index.php`: controlador frontal
* Directorio `/tests`:
    - Pruebas unitarias y funcionales de la API
* Directorio `/vendor`:
    - Componentes desarrollados por terceros (Doctrine, Dotenv, etc.)

## 🚀 Puesta en marcha de la aplicación

Para acceder a la aplicación utilizando el servidor interno del intérprete
de PHP se ejecutará el comando:
```
$ php -S 127.0.0.1:8000 -t public
```

Una vez hecho esto, la aplicación estará disponible en [http://127.0.0.1:8000/][lh].

## 🔎 Ejecución de pruebas

La aplicación incorpora un conjunto completo de herramientas para la ejecución de pruebas 
unitarias y de integración con [PHPUnit][phpunit]. Empleando este conjunto de herramientas
es posible comprobar de manera automática el correcto funcionamiento de las entidades
sin la necesidad de herramientas adicionales.

Para configurar el entorno de pruebas se debe crear una copia del fichero `./phpunit.xml.dist`
y renombrarla como `./phpunit.xml`. A continuación se debe editar dicho fichero y modificar los
mismos parámetros (`DATABASE_NAME`, `DATABASE_USER` y `DATABASE_PASSWD`) que en la fase de
instalación con los valores apropiados. Para lanzar la suite de pruebas se debe ejecutar:
```
$ ./bin/phpunit [--testdox] [--coverage-text] [-v]
$ ./bin/phpunit --testdox --display-warnings
$ ./bin/phpunit --testdox --display-warnings > last_phpunit_result.txt
```

[12factor]: https://www.12factor.net/es/
[dataMapper]: http://martinfowler.com/eaaCatalog/dataMapper.html
[doctrine]: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/
[dotenv]: https://packagist.org/packages/vlucas/phpdotenv
[lh]: http://127.0.0.1:8000/
[phpunit]: http://phpunit.de/manual/current/en/index.html
