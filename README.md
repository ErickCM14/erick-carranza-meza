# Frontend

Tienda de comercio ekectronico para consumir las API de productos y cotizacion con envia

## Tabla de Contenidos


- [Instalación](#instalación)
- [Versiones](#versiones)


## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local.

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/ErickCM14/erick-carranza-meza.git

2. **Instalar xampp**:

   Debes contar con xampp y apache instalado en tu local

3. **Configurar constantes**:

    En la carpeta \application\config\constants.php configuras las constantes hasta abajo del documento

    URL_BACKEND -> URL donde corre el backend

    TOKEN -> Token generado en la ejecucion del proyecto backend

    TOKEN_ENVIA -> Token proporcionado en el documento

4. **Configurar proyecto**:

    Debes tener xampp instalado y en la carpeta htdocs poner el proyecto, también encender el servicio de apache
    
    En application\config\config.php en la variable 'base_url' se debe configurar la ruta del proyecto, el nombre de la carpeta donde esta alojado htdocs/{NombreCarpeta} entonces quedaria la variable como http//localhost:{PORT}/{NombreCarpeta}


## Versiones

Codeigniter V3.1.13

XAMPP V3.3.0
