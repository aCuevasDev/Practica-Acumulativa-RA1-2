@echo off
setlocal EnableExtensions
cd /d "%~dp0"

set "JS_DIR=src\PracticaJS\Practica2"
set "DOCKER_SRC=docker\src"

echo ============================================
echo  Sincronizando src\ --^> docker\src\
echo ============================================
echo.

if not exist "songs.json" goto :err_no_songs
if not exist "src\" goto :err_no_src
if not exist "docker\" goto :err_no_docker

echo [1/3] Dependencias JS ^(Howler^)...
if exist "%JS_DIR%\node_modules" (
    echo       node_modules ya existe, se omite npm ci.
) else (
    where npm >nul 2>&1
    if errorlevel 1 (
        echo       [AVISO] npm no disponible; ejecuta "npm ci" en %JS_DIR%.
    ) else (
        pushd "%JS_DIR%"
        call npm ci
        if errorlevel 1 echo       [AVISO] npm ci fallo; se continua igualmente.
        popd
    )
)

echo.
echo [2/3] Copiando songs.json a %JS_DIR%...
copy /Y "songs.json" "%JS_DIR%\songs.json" >nul
if errorlevel 1 goto :err_copy
echo       OK

echo.
echo [3/3] Espejo src\ --^> %DOCKER_SRC%\ ...
robocopy "src" "%DOCKER_SRC%" /MIR /XD .git /NFL /NDL /NP
set "RC=%ERRORLEVEL%"
if %RC% GEQ 8 goto :err_robocopy

echo       OK ^(codigo robocopy: %RC%^)
echo.
echo Sincronizacion completada.
if /I not "%~1"=="-q" pause
exit /b 0

:err_no_songs
echo [ERROR] No se encuentra songs.json en la raiz.
goto :fail

:err_no_src
echo [ERROR] No existe la carpeta src\.
goto :fail

:err_no_docker
echo [ERROR] No existe la carpeta docker\.
goto :fail

:err_copy
echo [ERROR] No se pudo copiar songs.json.
goto :fail

:err_robocopy
echo [ERROR] robocopy fallo con codigo %RC%.
goto :fail

:fail
echo.
echo Sincronizacion abortada.
if /I not "%~1"=="-q" pause
exit /b 1
