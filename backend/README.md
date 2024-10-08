# Backend

API para crear, leer, actualizar y eliminar productos. Se realizaron todas las especificaciones del documento

## Tabla de Contenidos


- [Instalación](#instalación)
- [Ejecución](#ejecución)
- [Versiones](#versiones)


## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local.

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/ErickCM14/erick-carranza-meza.git
   ```

2. **Instalar dependencias**:

   ```bash
   npm install
   ```

3. **Configurar variables de entorno**:

    PORT -> Puerto donde se ejecutara el proyecto
    
    MONGO_URI -> URI de la bdd
    
    USERID -> Este userid se creo directamente el usuario desde la bdd

    JWT_SECRET -> Password para el token - use secretpassword2024 para el usuario _id: 66e164de6ff679813ba5ac70

    Crea un archivo .env en la carpeta raíz de tu proyecto y configura las siguientes variables

    ```bash
    PORT=3000
    MONGO_URI=mongodb://127.0.0.1:27017/tendencys
    USERID=66e164de6ff679813ba5ac70
    JWT_SECRET=secretpassword2024
    ```

4. **Relacionar un token con el usuario en access token**:

    Primero en tus variables de entorno en USERID establece el id del usuario de la bdd

    Ejecuta el siguiente comando

   ```bash
    node generateToken.js
    ```
    Recuerda guardar el token que imprimira en consola y ponerlo en el front para validar las peticiones

    Si requiren las colecciones hechas previamente las encontraran en la carpeta public/collections

## Ejecución

### Ejecutar con Nodemon

   Para iniciar el proyecto en modo de desarrollo con **Nodemon**, que automáticamente reinicia el servidor cuando detecta cambios en el código, utiliza el siguiente comando:

   ```bash
   npm run dev
   ```

### Ejecutar sin Nodemon

   Ejecutar la aplicación en un entorno sin herramientas adicionales de desarrollo

   ```bash
   npm run start
   ```

## Versiones

NodeJS 18.20.4

NPM 10.8.3
    
Express 4.20.0

BDD MongoDB
