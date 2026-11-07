# Jukebox PHP

## Compose

No me gusta la idea de duplicar código como pide el ejercicio [docker/src](docker/src/) así que he apuntado el compose a la raíz, el COPY del dockerfile no funciona porque lo sobreescribo con compose.

## Sobre usuarios.json y canciones.json

Estoy trabajando todo este rato con el src de raíz para no duplicar. No me parece correcto ahora esconder algo dentro de docker/ así que he almacenado la carpeta data en la raíz

# Proyecto

Aplicación web de gestión y reproducción de canciones. Incluye ejercicios de PHP, un catálogo con persistencia JSON y el reproductor JavaScript de PracticaJS.

## Requisitos

- Docker Desktop con Docker Compose (plugin `docker compose`).
- Puertos `8091`, `3307` y `5432` disponibles para la web, MariaDB y PostgreSQL.
- Un archivo `docker/.env` con las variables de configuración de los servicios.

PHP 8.5 y las extensiones PDO para MariaDB y PostgreSQL se instalan en la imagen web; no hace falta instalarlos en el equipo.

## Estructura

```text
.
├── data/
│   ├── songs.json            # Catálogo inicial
│   ├── usuarios.json         # Datos de usuarios (local, excluido de Git)
│   └── usuarios.json.example # Ejemplo para crear usuarios.json
├── docker/
│   ├── apache/jukebox.conf   # VirtualHost y documento inicial de Apache
│   ├── compose.yaml          # Web, MariaDB y PostgreSQL
│   ├── Dockerfile            # Imagen PHP/Apache con PDO para ambas bases
│   └── .env-example          # Plantilla de configuración
└── src/
    ├── 01-*.php ... 12-*.php # Ejercicios de PHP
    ├── api/                  # API de canciones
    ├── assets/               # Hojas de estilo
    ├── class/                # Clases del dominio y respuestas
    ├── persistence/          # Lectura y escritura del catálogo y usuarios
    ├── services/             # Sesiones, validaciones y conexiones
    ├── views/                # Formularios y vistas
    └── PracticaJS/Practica2/ # Reproductor web y recursos de audio
```

El Compose monta `src/` en `/var/www/html` y `data/` en `/var/www/data`. Los datos JSON quedan fuera del directorio público de Apache.

## Configuración y arranque

Desde la raíz del proyecto, prepara los archivos locales:

```powershell
Copy-Item docker\.env-example docker\.env
Copy-Item data\usuarios.json.example data\usuarios.json
```

En macOS o Linux:

```sh
cp docker/.env-example docker/.env
cp data/usuarios.json.example data/usuarios.json
```

Edita `docker/.env` y sustituye los valores de ejemplo por credenciales propias. El archivo configura ambas bases de datos; no compartas ni subas ese archivo al repositorio.

Arranca los tres servicios usando el Compose de `docker/`:

```sh
docker compose --env-file docker/.env -f docker/compose.yaml up --build -d
```

Consulta los registros:

```sh
docker compose --env-file docker/.env -f docker/compose.yaml logs -f web
```

Detén los servicios:

```sh
docker compose --env-file docker/.env -f docker/compose.yaml down
```

MariaDB y PostgreSQL conservan sus datos en volúmenes de Docker. `down` no elimina esos volúmenes.

## URLs y puertos

- Aplicación: <http://localhost:8091/>
- Formulario de acceso/registro: <http://localhost:8091/login.php>
- Catálogo de canciones: <http://localhost:8091/canciones.php> (requiere iniciar sesión)
- Reproductor JavaScript: <http://localhost:8091/PracticaJS/Practica2/index.html>
- Formulario de ejercicios PHP: <http://localhost:8091/views/form.html>
- MariaDB desde el equipo: `localhost:3307` (en la red de Docker: `mariadb:3306`)
- PostgreSQL desde el equipo: `localhost:5432` (en la red de Docker: `postgres:5432`)

Apache usa `home.php` como página inicial. Las conexiones de la aplicación a las bases de datos usan los nombres de servicio de Docker y las credenciales de `docker/.env`.

## Datos JSON

El catálogo inicial se encuentra en `data/songs.json`. Los registros de usuario se guardan en `data/usuarios.json`; el archivo de ejemplo sirve como base para crearlo. Ambos se montan desde el equipo, así que los cambios persisten al detener los contenedores.
