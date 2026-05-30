# SPARK - Plataforma de Gestión de Eventos

Una aplicación PHP MVC (Modelo-Vista-Controlador) con integración de base de datos MySQL para gestión de usuarios y eventos, con características avanzadas de geolocalización y mapas interactivos.

## Descripción General

SPARK es una aplicación web completa construida siguiendo el patrón arquitectónico MVC con PHP y MySQL. Proporciona autenticación de usuarios, gestión de perfiles, seguimiento de eventos, mapas interactivos con geolocalización, galerías fotográficas tipo Instagram y navegación móvil optimizada.

## Arquitectura del Proyecto

### Estructura MVC

- **Controller1/** - Controladores que manejan la lógica de negocio
  - `user.Controler.php` - Operaciones y acciones relacionadas con usuarios
  - `eventController.php` - Gestión de eventos y operaciones CRUD

- **Model/** - Modelos de base de datos y esquemas
  - `spark.sql` - Esquema de base de datos MySQL e inicialización
  - `UserModel.php` - Modelo de usuario con métodos de gestión
  - `EventModel.php` - Modelo de evento con métodos CRUD (crear, obtener, actualizar, eliminar)

- **Vista/** - Plantillas de vistas e interfaz de usuario
  - Páginas de autenticación: `login.php`, `registro.php`, `registroAdmin.php`, `registroUsuario.php`, `verificacion.php`, `logout.php`
  - Páginas de usuario: `home.php`, `perfil.php`, `password.php`, `tipoUsuario.php`
  - Páginas de eventos: `evento.php`, `eventos.php`, `crearEvento.php`, `editarEvento.php`, `eliminarEvento.php`
  - Mapa interactivo: `mapa.php` (Leaflet.js + OpenStreetMap)
  - Foro/Feed: `foro.php` (Galería de fotos tipo Instagram)
  - Bandera de cookies: `cookies-banner.php`
  - Estilos CSS: archivos para cada componente de vista
  - Activos: `recursos/` (imágenes e iconos), `uploads/` (contenido generado por usuarios)
  - JavaScript: Scripts interactivos en `JS/` (cookies.js, eliminar.js, tipoUsuario.js, etc.)

## Características

- **Autenticación de Usuarios**
  - Inicio y cierre de sesión
  - Registro de usuarios (estándar y administrador)
  - Verificación de correo electrónico
  - Gestión de contraseña y recuperación

- **Gestión de Usuarios**
  - Perfiles de usuario personalizables
  - Roles de usuario: Usuario (rol 1) y Organizador (rol 2)
  - Actualización de perfiles

- **Gestión de Eventos**
  - Creación, edición y eliminación de eventos
  - Listado de eventos con filtros por categoría
  - Página de detalle del evento con datos dinámicos de la base de datos
  - Almacenamiento automático de ubicación (Nombre, Descripción, Fecha)

- **Mapas Interactivos**
  - Mapa interactivo usando Leaflet.js y OpenStreetMap
  - Geolocalización automática de eventos usando API Nominatim
  - Almacenamiento de coordenadas (latitud/longitud) en la base de datos
  - Visualización de eventos en el mapa

- **Galería y Foro**
  - Sección de foro/feed con galería de fotos tipo Instagram
  - Cuadrícula de fotos responsiva

- **Experiencia de Usuario**
  - Carrusel/slider en la página principal con múltiples imágenes de portada
  - Barra de navegación móvil en la parte inferior
  - Consentimiento de cookies con bandera interactiva
  - Sistema de diseño CSS con variables de color: --butter, --dark, --beige, --butter-d

## Requisitos

- **Requisitos del Servidor:**
  - PHP 7.0 o superior
  - MySQL 5.7 o superior (o equivalente MariaDB)
  - Servidor web (Apache con mod_rewrite recomendado)

- **Librerías y Dependencias:**
  - Leaflet.js (mapas interactivos)
  - OpenStreetMap (proveedor de mapas)
  - Nominatim API (geolocalización)

- **Navegadores Compatibles:**
  - Navegadores modernos con soporte CSS3 y JavaScript
  - Navegadores móviles con capacidad GPS

## Instalación

### 1. Clonar/Descargar Proyecto
```bash
# Copiar archivos del proyecto al directorio del servidor web
cp -r SPARK /var/www/html/
cd /var/www/html/SPARK
```

### 2. Configuración de la Base de Datos

Importar el esquema de base de datos:

```bash
# Usando la línea de comandos de MySQL
mysql -u root -p < Model/spark.sql

# O a través de phpMyAdmin
# 1. Crear una nueva base de datos
# 2. Importar Model/spark.sql
```

La base de datos incluye las siguientes tablas:
- **Usuario** - Información de usuarios con roles (1: usuario, 2: organizador)
- **Evento** - Información de eventos con campos de geolocalización (Lat, Lng)

Tabla Evento con columnas:
- `Id_Evento` - Identificador único
- `Nombre_evento` - Nombre del evento
- `Descripcion` - Descripción del evento
- `Fecha_evento` - Fecha del evento
- `Ubicacion` - Nombre de la ubicación
- `Lat` - Latitud (DECIMAL 10,7)
- `Lng` - Longitud (DECIMAL 10,7)

### 3. Configurar Conexión a la Base de Datos

Actualizar el archivo de configuración de base de datos con las siguientes credenciales:

```php
$host = 'localhost';
$user = 'tu_usuario_bd';
$password = 'tu_contraseña_bd';
$database = 'spark_db';
```

### 4. Establecer Permisos de Directorios

```bash
# Permitir que el directorio de carga sea escribible
chmod 755 Vista/uploads/
chmod 755 Vista/recursos/
```

### 5. Configurar el Servidor Web

Para Apache, asegurar que `.htaccess` esté habilitado y la reescritura de URL esté configurada si se utilizan URLs limpias.

## Estructura de Archivos

```
SPARK/
├── README.md                      # Documentación del proyecto
├── Controller1/
│   ├── user.Controler.php        # Lógica del controlador de usuario
│   └── eventController.php       # Lógica del controlador de eventos
├── Model/
│   ├── spark.sql                 # Esquema de base de datos
│   ├── UserModel.php             # Modelo de usuario
│   └── EventModel.php            # Modelo de evento (CRUD)
└── Vista/
    ├── home.php                  # Página de inicio con carrusel
    ├── login.php                 # Formulario de inicio de sesión
    ├── logout.php                # Cierre de sesión
    ├── registro.php              # Registro genérico
    ├── registroAdmin.php         # Registro de administrador
    ├── registroUsuario.php       # Registro de usuario
    ├── verificacion.php          # Verificación de correo
    ├── perfil.php                # Perfil de usuario
    ├── password.php              # Gestión de contraseña
    ├── tipoUsuario.php           # Gestión de roles de usuario
    ├── evento.php                # Página de detalle del evento
    ├── eventos.php               # Listado de eventos con filtros
    ├── crearEvento.php           # Creación de evento
    ├── editarEvento.php          # Edición de evento
    ├── eliminarEvento.php        # Eliminación de evento
    ├── mapa.php                  # Mapa interactivo con Leaflet.js
    ├── foro.php                  # Foro/Feed con galería tipo Instagram
    ├── cookies-banner.php        # Bandera de consentimiento de cookies
    ├── layout-top.php            # Encabezado común
    ├── layout-bottom.php         # Pie de página común
    ├── *.css                     # Estilos (home.css, login.css, evento.css, etc.)
    ├── cookies.css               # Estilos de la bandera de cookies
    ├── editarEvento.css          # Estilos de edición de evento
    ├── eliminar.css              # Estilos de eliminación
    ├── evento.css                # Estilos de evento
    ├── JS/
    │   ├── cookies.js            # Manejo de cookies
    │   ├── eliminar.js           # Funcionalidad de eliminación
    │   ├── eliminarEvento.js     # Eliminación de eventos
    │   └── tipoUsuario.js        # Gestión de tipos de usuario
    ├── recursos/                 # Activos estáticos
    │   └── icono_imagen.avif     # Iconos e imágenes del proyecto
    └── uploads/                  # Cargas de usuario
        └── [archivos cargados]   # Imágenes y archivos de usuarios
```

## Uso

### Acceder a la Aplicación

1. Iniciar el servidor web (Apache/Nginx)
2. Abrir el navegador y navegar a: `http://localhost/SPARK/` o su dominio configurado
3. Usar la página de inicio de sesión para acceder al sistema

### Registro de Usuario

1. Navegar a la página de registro
2. Elegir entre registro de usuario estándar o registro de organizador
3. Completar la información requerida
4. Verificar la dirección de correo electrónico
5. Acceder al perfil y gestionar la configuración

### Gestionar Contenido

- **Eventos:** Navegar a la sección de eventos para crear, editar, eliminar y visualizar eventos
- **Mapa Interactivo:** Ver todos los eventos en un mapa interactivo con ubicaciones geolocalizadas
- **Galería/Foro:** Explorar la galería de fotos tipo Instagram en la sección de foro
- **Perfil:** Actualizar información personal en el perfil
- **Cuenta:** Gestionar contraseña y configuración de seguridad

### Roles de Usuario

- **Usuario (Rol 1):** Puede registrarse, crear eventos, consultar el mapa y ver la galería
- **Organizador (Rol 2):** Tiene permisos extendidos para gestionar eventos y usuarios

## Configuración

### Configuración de la Base de Datos

Actualizar la configuración de conexión a la base de datos en el archivo de configuración principal:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'spark_db');
```

### Configuración de Sesiones

Las sesiones se utilizan para la autenticación de usuarios. Asegurar que el manejo de sesiones PHP esté configurado correctamente en `php.ini`.

### Integración de Mapas

Para utilizar el mapa interactivo, la aplicación requiere:
- Leaflet.js (incluido mediante CDN)
- OpenStreetMap (proveedor de mapas gratuito)
- Nominatim API (para geolocalización de direcciones)

No se requiere configuración adicional; estas librerías son públicas y gratuitas.

### Sistema de Diseño CSS

La aplicación utiliza un sistema de variables CSS para mantener consistencia visual:
```css
--butter: Color principal (amarillo mantequilla)
--dark: Color oscuro (texto principal)
--beige: Color beige (fondos secundarios)
--butter-d: Variante oscura del color butter
```

## Consideraciones de Seguridad

- Siempre utilizar sentencias preparadas para prevenir inyección SQL
- Hacer hash de contraseñas usando `password_hash()` y verificar con `password_verify()`
- Implementar tokens CSRF en formularios
- Validar y desinfectar toda la entrada del usuario
- Usar HTTPS en producción
- Mantener archivos de configuración sensibles fuera de la raíz web
- Actualizar regularmente dependencias y versión de PHP
- Validar y restringir tipos de archivo para las cargas
- Proteger los datos de ubicación y privacidad del usuario

## Solución de Problemas

### Problemas de Conexión a la Base de Datos
- Verificar que el servicio MySQL esté ejecutándose
- Comprobar las credenciales de la base de datos
- Asegurar que la base de datos y las tablas se hayan creado desde `spark.sql`

### Problemas de Carga de Archivos
- Verificar permisos del directorio `Vista/uploads/` (755)
- Comprobar configuración PHP `upload_max_filesize` y `post_max_size`

### Problemas de Autenticación
- Limpiar cookies del navegador y datos de sesión
- Verificar que el usuario exista en la base de datos
- Comprobar configuración de sesiones PHP

### Problemas con el Mapa
- Verificar conexión a internet (se requiere para OpenStreetMap)
- Asegurar que Leaflet.js está cargado correctamente
- Verificar que Nominatim API sea accesible

## Notas de Desarrollo

- Seguir el patrón MVC estrictamente: mantener la lógica de negocio en controladores, presentación en vistas
- Usar convenciones de nombres consistentes (camelCase para PHP, kebab-case para HTML/CSS)
- Comentar la lógica compleja para mantener la legibilidad
- Probar todos los flujos de usuario antes del despliegue
- Utilizar variables CSS para mantener consistencia de colores y estilos
- Mantener la aplicación responsive para dispositivos móviles
- Usar métodos CRUD consistentes en los modelos
- Validar datos en el lado del servidor (no depender solo de validación cliente)

## Contribuyendo

Cuando contribuyas a este proyecto:

1. Seguir la estructura MVC existente
2. Mantener consistencia de código
3. Probar todos los cambios minuciosamente
4. Actualizar documentación según sea necesario

## Licencia

Este proyecto es parte del sistema SPARK. Todos los derechos reservados.

## Soporte

Para problemas, preguntas o soporte, por favor contactar al equipo de desarrollo.

---

**Última actualización:** Mayo 2026
