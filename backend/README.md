# Backend

API para crear, leer, actualizar y eliminar productos. Se realizaron todas las especificaciones del documento

## Tabla de Contenidos


- [Instalación](#instalación)
- [Versiones](#versiones)


## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local.

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/tu_usuario/tu_repositorio.git

2. **Instalar dependencias**:

   ```bash
   npm install

3. **Configurar variables de entorno**:

    PORT -> Puerto donde se ejecutara el proyecto
    
    MONGO_URI -> URI de la bdd
    
    USERID -> Este userid se creo directamente el usuario desde la bdd

    JWT_SECRET -> Password para el token

4. **Relacionar un token con el usuario en access token**:

    Primero en tus variables de entorno en USERID establece el id del usuario de la bdd

    Ejecuta el siguiente comando

   ```bash
    node generateToken.js
    
    Recuerda guardar el token que imprimira en consola y ponerlo en el front para validar las peticiones

    Si requiren las colecciones hechas previamente las encontraran en la carpeta public/collections


## Versiones

    NodeJS V18.20.4

    NPM V10.8.3
    
    Express V4.20.0

    BDD MongoDB
