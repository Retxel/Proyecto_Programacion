# Documentación de Procesos del Backend - Historias Médicas

## 7.1 Flujo de Autenticación
1. Usuario ingresa email y contraseña en el formulario de login.
2. Laravel verifica las credenciales en la base de datos (tabla `usuarios`).
3. Si son correctas → Inicia la sesión y redirige al panel principal `/dashboard`.
4. Si son incorrectas → Muestra un mensaje de error de validación y mantiene al usuario en la vista de login.

## 7.2 Flujo de Creación de Pacientes
1. El médico ingresa a la vista de registro e introduce los datos del paciente (documento de identidad, nombres, apellidos, fecha de nacimiento, género y antecedentes clínicos).
2. El sistema valida que los campos obligatorios estén completos y que el documento de identidad sea único en la tabla `pacientes`.
3. Si la validación es correcta → Registra al paciente en la tabla `pacientes` vinculando el `id_usuario_creador` del médico autenticado.
4. El sistema crea automáticamente la historia médica en la tabla `historias_medicas` generando el número de expediente único (ej. `EXP-000001`).
5. Si se agregaron antecedentes (personales, quirúrgicos o familiares), estos se guardan automáticamente en la tabla `antecedentes` relacionados al expediente.
6. Redirige al médico al listado general de pacientes con un mensaje de éxito.

## 7.3 Flujo de Creación de Consultas
1. El médico ingresa al expediente del paciente y hace clic en "Nueva Consulta", completando el formulario (motivo, signos vitales, examen físico, diagnóstico, tratamiento, exámenes solicitados).
2. El sistema valida que el paciente tenga una historia médica activa.
3. El sistema valida que los campos obligatorios (motivo y diagnóstico) estén completos.
4. Si la validación es correcta → Registra la consulta en la tabla `consultas` asociando el ID de la historia médica (`id_historia`) y el ID del médico logueado (`id_medico`).
5. Redirige a la vista detallada del expediente del paciente con un mensaje de éxito.

---

## 8. SEGURIDAD IMPLEMENTADA

| Aspecto de Seguridad | Implementación |
| :--- | :--- |
| **Autenticación** | Sistema de login/register con Laravel Breeze |
| **Control de acceso por roles** | Restricción por ID de sesión y asignación automática del creador (`id_usuario_creador` / `id_medico`) |
| **Protección de rutas** | Middleware `'auth'` en todas las rutas protegidas en `routes/web.php` |
| **Validación de datos** | `$request->validate()` en todos los formularios de registro y actualización |
| **Protección CSRF** | `@csrf` en todos los formularios de las vistas Blade |
| **Contraseñas cifradas** | `Hash::make()` (algoritmo seguro bcrypt) al crear usuarios |
| **Prevención SQL Injection** | Eloquent ORM y consultas preparadas (PDO nativo de Laravel) |
| **Protección Mass Assignment** | Propiedad `$fillable` explícita en todos los modelos (`User`, `Paciente`, `Consulta`) |
| **Seguridad de Sesión** | Regeneración automática de la sesión (`$request->session()->regenerate()`) al iniciar sesión |
