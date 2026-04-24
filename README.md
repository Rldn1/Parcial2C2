# Parcial2C2

# Integrantes:
Esmeralda Isabel Cruz Roldán - SMSS011124

# Preguntas


# ¿Cómo manejan la conexión a la BD y qué pasa si algunos de los datos son incorrectos? Justifiquen la manera de validación de la conexión.

La conexión la manejamos con MySQLi en un archivo llamado `conexion.php`. Allí ponemos los datos del servidor (host, usuario, contraseña, nombre de la base de datos y puerto).

```php
$conexion = new mysqli($host, $user, $pass, $base, $port);
if($conexion->connect_error){
    die("Error de conexión: " . $conexion->connect_error);
}
```

Si la conexión falla (por ejemplo, si MySQL no está corriendo o los datos están mal), el programa muestra un mensaje de error y se detiene. Así evitamos que el sistema siga funcionando sin poder acceder a la base de datos.

Validación de datos: Cuando el usuario ingresa información (como una nueva cita), verificamos en el servidor que los campos obligatorios no estén vacíos. Si falta algún dato, se muestra un mensaje de error y no guarda nada. Esto evita que se guarden registros incompletos.

# ¿Cuál es la diferencia entre $_GET y $_POST en PHP? ¿Cuándo es más apropiado usar cada uno? Da un ejemplo real de tu proyecto.

La diferencia principal es que `$_GET` envía los datos por la URL (son visibles) y `$_POST` los envía por el cuerpo de la petición (no se ven en la URL).

En nuestro proyecto:

$_GET para pasar el ID de la cita cuando se requiere editarla o eliminarla. Por ejemplo: `edit_cita.php?id=5`. Así sabe qué cita modificar.
$_POST en el formulario de login y en el formulario para crear/editar citas, porque son datos sensibles (contraseña, información del paciente) que no deben aparecer en la URL.


# Tu app va a usarse en una empresa de la zona oriental. ¿Qué riesgos de seguridad identificas en una app web con BD que maneja datos de los usuarios? ¿Cómo los mitigarían?

Los principales riesgos identificados son:

- Robo de contraseñas – Si las guardamos en texto plano.  
Mitigación:Encriptamos las contraseñas con `password_hash()` y las verificamos con `password_verify()`.

- Acceso no autorizado – Que alguien entre sin tener cuenta.  
Mitigación: Usamos sesiones (`session_start()`) y verificamos que el usuario haya iniciado sesión antes de permitirle agregar, editar o eliminar citas.

- Datos incorrectos – Que el usuario ingrese información vacía o errónea.  
Mitigación: Validamos del lado del servidor que los campos obligatorios no estén vacíos.


# Diccionario de datos

Tabla: `usuarios`

| Columna   | Tipo de dato | Límite | ¿Es nulo? | Descripción |
|-----------|-------------|--------|-----------|-------------|
| id        | INT         | 11     | NO        | Identificador único del usuario (autoincrementable) |
| username  | VARCHAR     | 30     | NO        | Nombre de usuario para iniciar sesión |
| password  | VARCHAR     | 60     | NO        | Contraseña encriptada con `password_hash()` |
| rol       | VARCHAR     | 20     | NO        | Tipo de usuario: `admin` (administrador) o `user` (normal) |

## Usuarios del Sistema

| # | Username | Rol |
|---|----------|-----|
| 1 | admin | Administrador |
| 2 | juan_perez | Usuario normal |
| 3 | maria_gomez | Usuario normal |
| 4 | carlos_ramirez | Usuario normal |
| 5 | laura_martinez | Usuario normal |

**Credenciales de prueba:**
- **Admin:** username: `admin`
- **Usuarios:** cualquier username de los listados.

Tabla: `citas_medicas`

Columna | Tipo de dato | Límite | ¿Es nulo? | Descripción 

id                 | INT | 11 | NO | Identificador único de la cita |
paciente_nombre    | VARCHAR | 60 | NO | Nombre completo del paciente |
telefono           | VARCHAR | 9 | NO | Número de teléfono de contacto |
medico             | VARCHAR | 50 | NO | Nombre del médico asignado |
tipo_consulta      | VARCHAR | 20 | NO | General o Especialista |
fecha_cita         | DATE    | - | NO | Fecha de la primera cita |
fecha_segunda_cita | DATE | - | SÍ | Fecha de la segunda cita (puede quedar vacía) |
sintomas           | TEXT | - | SÍ | Descripción de los síntomas del paciente |
fecha_registro     | TIMESTAMP | - | NO | Fecha y hora en que se creó el registro |



