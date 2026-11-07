Tuve que adaptar el [json](songs.json) de la practicaJS y para mantener el versionado lo he movido a la raíz, ya que el otro pertenece a otro proyecto.
Tampoco versiono nada dentro de [docker/src](docker/src/) porque no me gusta la idea de duplicar código como pide el ejercicio.

# PracticaJS

Necesitas la practica Js del repo: [PracticaJS](https://github.com/aCuevasDev/Practica2) y clonarla en [src/PracticaJS/Practica2](src/PracticaJS/Practica2)

# Sync-docker.bat

Para poder ejecutar la aplicación primero ejecuta [sync-docker.bat](sync-docker.bat) para sincronizar [songs.json](songs.json) y src dentro de la prácticaJS y la carpeta docker
(Ya no hace falta sincronizar src porque no me gustaba estar obligado a duplicar código y he apuntado el compose al src raíz pero sigue haciendo falta para songs.json)

# usuarios.json

Estoy trabajando todo este rato con el src de raíz para no duplicar. No me parece correcto ahora esconder algo dentro de docker/ así que he almacenado la carpeta data en la raíz
