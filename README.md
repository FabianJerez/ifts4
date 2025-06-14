# Grupo 2 Requerimientos
- Base de estudiantes para envíos de mensajes
- PHP CSS eventos JS 
- Tres tipos de usuarios, estudiantes, profesores, administrativos 
- Estudiantes, solo puede realizar alta. 
- Profesores, sólo pueden listar estudiantes.
- Administrativos, pueden enviar mail, y realizar una baja lógica de los estudiantes.
- Luego de (variable tiempo), se produce una baja lógica.

# Módulo Newsletter IFTS4

Este módulo permite:

- Suscripción al newsletter por parte de estudiantes.
- Envío de correos por parte de administrativos.
- Baja automática a los 4 años.
- Baja voluntaria vía enlace en el correo.

## Archivos principales

- `suscripcion.php`: formulario de alta
- `enviar_newsletter.php`: envío de boletines (solo admin)
- `newsletter_unsuscribe.php`: baja voluntaria por token
- `cron_baja.php`: baja automática (manual)
- `usuarios.php`, `listado.php`: vistas de usuarios y control

## Integración

- Incluir la carpeta `newsletter/` en el proyecto web
- Asegurarse de tener acceso a la base `ifts4`
- Iniciar sesión antes de usar funciones protegidas
