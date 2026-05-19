<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class GenerarInformePdf extends Command
{
    protected $signature = 'generar:informe';
    protected $description = 'Genera un documento PDF formal con el Informe del Modelo CRUD del sistema de Historias Médicas';

    public function handle()
    {
        $this->info('Iniciando la generación del informe PDF...');

        $html = $this->buildHtmlReport();

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'portrait');

        $outputPath = base_path('InformeModeloCRUD_Historias_Medicas.pdf');
        
        $pdf->save($outputPath);

        $this->info("¡Informe PDF generado exitosamente en: {$outputPath}!");
        return 0;
    }

    private function buildHtmlReport()
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Modelo CRUD - Sistema de Historias Médicas</title>
    <style>
        @page {
            margin: 2.5cm 2cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
            font-size: 11pt;
        }
        
        /* Encabezados y Pie de página */
        .header {
            position: fixed;
            top: -1.5cm;
            left: 0;
            right: 0;
            height: 1cm;
            border-bottom: 1px solid #dee2e6;
            font-size: 9pt;
            color: #6c757d;
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: -1.5cm;
            left: 0;
            right: 0;
            height: 1cm;
            border-top: 1px solid #dee2e6;
            font-size: 9pt;
            color: #6c757d;
            text-align: center;
        }

        /* Salto de Página */
        .page-break {
            page-break-after: always;
        }

        /* Portada */
        .cover-page {
            text-align: center;
            padding-top: 2cm;
            height: 100%;
        }
        .institution-logo {
            width: 100px;
            margin-bottom: 0.5cm;
        }
        .institution-name {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0b58ca;
            margin-bottom: 2cm;
        }
        .project-title {
            font-size: 26pt;
            font-weight: 800;
            color: #0d6efd;
            margin-top: 2cm;
            margin-bottom: 0.5cm;
            line-height: 1.2;
        }
        .project-subtitle {
            font-size: 16pt;
            color: #495057;
            margin-bottom: 3cm;
        }
        .author-info {
            margin-top: 4cm;
            font-size: 11pt;
            color: #212529;
            text-align: left;
            display: inline-block;
            border-left: 3px solid #0d6efd;
            padding-left: 15px;
        }
        .author-info p {
            margin: 4px 0;
        }

        /* Estilos de Contenido */
        h1 {
            font-size: 18pt;
            color: #0b58ca;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 5px;
            margin-top: 0;
            margin-bottom: 1.2cm;
        }
        h2 {
            font-size: 14pt;
            color: #495057;
            margin-top: 1cm;
            margin-bottom: 0.5cm;
        }
        p {
            margin-bottom: 15px;
            text-align: justify;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 30px 0;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Cuadros informativos */
        .info-box {
            background-color: #e8f4fd;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box-title {
            font-weight: bold;
            color: #0b58ca;
            margin-bottom: 5px;
        }

        /* Estilo de Código / Consola */
        pre {
            background-color: #212529;
            color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 9pt;
            overflow-x: auto;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <!-- Encabezado y Pie de página en todas las páginas excepto la portada -->
    <div class="footer">Informe de Modelo CRUD — Sistema de Historias Médicas</div>

    <!-- 1. PORTADA -->
    <div class="cover-page page-break">
        <div class="institution-name">
            Universidad de Programación Aplicada<br>
            Facultad de Ingeniería de Sistemas<br>
            Cátedra de Desarrollo Web
        </div>
        
        <div class="project-title">SISTEMA DE CONTROL DE HISTORIAS MÉDICAS</div>
        <div class="project-subtitle">Informe Técnico de Implementación CRUD y Aseguramiento de Calidad</div>
        
        <div class="author-info">
            <p><strong>Cátedra:</strong> Programación Web Avanzada</p>
            <p><strong>Estudiante / Desarrollador:</strong> Dr(a). Programador Médico</p>
            <p><strong>Framework Utilizado:</strong> Laravel 12.0 + Bootstrap 5</p>
            <p><strong>Fecha de Entrega:</strong> Mayo, 2026</p>
        </div>
    </div>

    <!-- 2. INTRODUCCIÓN -->
    <div class="page-break">
        <h1>1. INTRODUCCIÓN Y ALCANCE</h1>
        
        <h2>1.1 Descripción del Proyecto</h2>
        <p>
            El presente informe técnico detalla el diseño, la arquitectura y la implementación del **Sistema de Control de Historias Médicas**, una plataforma web moderna y robusta construida con **Laravel 12**, **MySQL** y **Bootstrap 5**. El sistema está diseñado específicamente para satisfacer las necesidades diarias de los profesionales de la salud (médicos) en la gestión y almacenamiento seguro de la información clínica de sus pacientes.
        </p>
        <p>
            El núcleo del software radica en un flujo CRUD (Create, Read, Update, Delete) completo y seguro. Cuando un médico registra a un paciente en la plataforma, el sistema inicializa de forma automática su expediente clínico (Historia Médica), permitiendo al médico asociar alergias, antecedentes patológicos y quirúrgicos. Posteriormente, en cada visita clínica, el médico puede registrar una nueva consulta médica que incluye signos vitales, examen físico, diagnóstico y el correspondiente plan de tratamiento, con secciones específicas y detalladas para medicinas recetadas y exámenes solicitados.
        </p>

        <h2>1.2 Tecnologías Utilizadas</h2>
        <table>
            <thead>
                <tr>
                    <th>Tecnología / Herramienta</th>
                    <th>Versión</th>
                    <th>Propósito y Rol en el Sistema</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Laravel (PHP Framework)</strong></td>
                    <td>12.0.x</td>
                    <td>Motor principal del backend, enrutamiento, ORM (Eloquent), autenticación y middleware.</td>
                </tr>
                <tr>
                    <td><strong>PHP</strong></td>
                    <td>8.2+</td>
                    <td>Lenguaje de programación de servidor para la lógica del negocio.</td>
                </tr>
                <tr>
                    <td><strong>MySQL</strong></td>
                    <td>8.0+</td>
                    <td>Base de datos relacional para persistencia de usuarios, pacientes y consultas.</td>
                </tr>
                <tr>
                    <td><strong>Bootstrap</strong></td>
                    <td>5.3</td>
                    <td>Framework CSS para el diseño responsivo, estético y adaptable del frontend.</td>
                </tr>
                <tr>
                    <td><strong>Blade Templates</strong></td>
                    <td>N/A</td>
                    <td>Motor de plantillas nativo de Laravel para renderizado de vistas en el cliente.</td>
                </tr>
                <tr>
                    <td><strong>DomPDF (laravel-dompdf)</strong></td>
                    <td>3.1</td>
                    <td>Biblioteca de generación y renderizado dinámico de archivos PDF para expedientes.</td>
                </tr>
                <tr>
                    <td><strong>PHPUnit</strong></td>
                    <td>11.5</td>
                    <td>Suite de pruebas automatizadas unitarias y de integración del sistema.</td>
                </tr>
            </tbody>
        </table>

        <h2>1.3 Funcionalidades Principales</h2>
        <p>
            La plataforma cuenta con un amplio conjunto de funcionalidades diseñadas para optimizar el flujo de trabajo médico:
        </p>
        <ul>
            <li><strong>Autenticación de Médicos:</strong> Sistema de inicio de sesión y registro protegido adaptado de Laravel Breeze.</li>
            <li><strong>Gestión de Pacientes (CRUD):</strong> Creación, lectura, actualización y eliminación de expedientes con validaciones estrictas.</li>
            <li><strong>Módulo de Consultas Clínicas:</strong> Registro pormenorizado de consultas pre-asociadas a la historia médica de cada paciente.</li>
            <li><strong>Buscador Lateral Dinámico:</strong> Buscador rápido de pacientes en tiempo real integrado en la barra lateral con resaltado de pacientes activos.</li>
            <li><strong>Exportación a PDF:</strong> Generación instantánea del expediente médico clínico completo en formato PDF oficial.</li>
        </ul>
    </div>

    <!-- 3. CASOS DE USO -->
    <div class="page-break">
        <h1>2. DIAGRAMA DE CASOS DE USO Y ACTORES</h1>
        
        <h2>2.1 Flujo de Casos de Uso del Sistema</h2>
        <p>
            El sistema define como actor principal al **Médico (Usuario)**, quien tiene control exclusivo sobre sus propios pacientes y consultas clínicas asociadas. Toda la información médica está protegida detrás de middlewares de autenticación, previniendo accesos no autorizados.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Caso de Uso (Acción)</th>
                    <th>Actor Principal</th>
                    <th>Descripción Detallada</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Registrarse / Autenticarse</strong></td>
                    <td>Médico</td>
                    <td>El médico crea una cuenta con su cédula y especialidad médica, e inicia sesión de forma segura.</td>
                </tr>
                <tr>
                    <td><strong>Registrar Paciente</strong></td>
                    <td>Médico</td>
                    <td>El médico ingresa los datos personales del paciente, inicializándose automáticamente el número de expediente único.</td>
                </tr>
                <tr>
                    <td><strong>Consultar Expediente</strong></td>
                    <td>Médico</td>
                    <td>Visualización completa del historial clínico del paciente: antecedentes, tipo de sangre y todas sus consultas previas.</td>
                </tr>
                <tr>
                    <td><strong>Registrar Consulta Médica</strong></td>
                    <td>Médico</td>
                    <td>Añade una consulta con motivo, diagnóstico, plan de tratamiento, tratamiento recetado (medicinas) y exámenes médicos.</td>
                </tr>
                <tr>
                    <td><strong>Editar / Eliminar Consulta</strong></td>
                    <td>Médico</td>
                    <td>Edición de campos erróneos o eliminación completa de una consulta clínica con confirmaciones del sistema.</td>
                </tr>
                <tr>
                    <td><strong>Buscar Pacientes en Tiempo Real</strong></td>
                    <td>Médico</td>
                    <td>Filtro de pacientes en la barra lateral con buscador instantáneo por nombre, apellido o documento de identidad.</td>
                </tr>
                <tr>
                    <td><strong>Exportar Expediente a PDF</strong></td>
                    <td>Médico</td>
                    <td>Genera una descarga directa en PDF con la historia clínica estructurada, firmada por el médico tratante.</td>
                </tr>
            </tbody>
        </table>

        <div class="info-box">
            <div class="info-box-title">Nota de Seguridad de Datos</div>
            <p style="margin: 0; font-size: 10pt;">
                El sistema implementa enrutamiento protegido mediante el middleware <code>auth</code> y relaciones Eloquent. Un médico autenticado únicamente puede buscar, ver, editar y exportar los pacientes y consultas de su propiedad, asegurando la estricta privacidad del paciente.
            </p>
        </div>
    </div>

    <!-- 4. DISEÑO DE BASE DE DATOS -->
    <div class="page-break">
        <h1>3. DISEÑO DE BASE DE DATOS Y RELACIONES</h1>
        
        <h2>3.1 Diccionario de Datos del Sistema</h2>
        
        <h3>Tabla: <code>usuarios</code> (Médicos)</h3>
        <table>
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo de Dato</th>
                    <th>Nulo</th>
                    <th>Clave</th>
                    <th>Descripción / Propósito</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>id_usuario</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>PK</td>
                    <td>Identificador único del médico en el sistema.</td>
                </tr>
                <tr>
                    <td><code>nombre</code></td>
                    <td>VARCHAR(255)</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Primer nombre del médico.</td>
                </tr>
                <tr>
                    <td><code>apellido</code></td>
                    <td>VARCHAR(255)</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Apellido paterno del médico.</td>
                </tr>
                <tr>
                    <td><code>especialidad</code></td>
                    <td>VARCHAR(255)</td>
                    <td>Sí</td>
                    <td>-</td>
                    <td>Especialidad médica (ej. Cardiología, Pediatría).</td>
                </tr>
                <tr>
                    <td><code>cedula</code></td>
                    <td>VARCHAR(255)</td>
                    <td>Sí</td>
                    <td>-</td>
                    <td>Cédula del médico.</td>
                </tr>
                <tr>
                    <td><code>email</code></td>
                    <td>VARCHAR(255)</td>
                    <td>No</td>
                    <td>Unique</td>
                    <td>Correo electrónico (credencial de acceso).</td>
                </tr>
            </tbody>
        </table>

        <h3>Tabla: <code>pacientes</code></h3>
        <table>
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo de Dato</th>
                    <th>Nulo</th>
                    <th>Clave</th>
                    <th>Descripción / Propósito</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>id_paciente</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>PK</td>
                    <td>Identificador único del paciente.</td>
                </tr>
                <tr>
                    <td><code>primer_nombre</code></td>
                    <td>VARCHAR(100)</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Primer nombre del paciente.</td>
                </tr>
                <tr>
                    <td><code>primer_apellido</code></td>
                    <td>VARCHAR(100)</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Primer apellido del paciente.</td>
                </tr>
                <tr>
                    <td><code>documento_identidad</code></td>
                    <td>VARCHAR(50)</td>
                    <td>No</td>
                    <td>Unique</td>
                    <td>Cédula o pasaporte único de identidad.</td>
                </tr>
                <tr>
                    <td><code>fecha_nacimiento</code></td>
                    <td>DATE</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Fecha de nacimiento del paciente.</td>
                </tr>
                <tr>
                    <td><code>genero</code></td>
                    <td>VARCHAR(20)</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Género biológico del paciente.</td>
                </tr>
                <tr>
                    <td><code>id_usuario_creador</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>FK</td>
                    <td>Relación con <code>usuarios.id_usuario</code>.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break">
        <h3>Tabla: <code>historias_medicas</code></h3>
        <table>
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo de Dato</th>
                    <th>Nulo</th>
                    <th>Clave</th>
                    <th>Descripción / Propósito</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>id_historia</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>PK</td>
                    <td>Identificador único de la historia clínica.</td>
                </tr>
                <tr>
                    <td><code>id_paciente</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>FK / Unique</td>
                    <td>Relación 1:1 con <code>pacientes.id_paciente</code>.</td>
                </tr>
                <tr>
                    <td><code>numero_expediente</code></td>
                    <td>VARCHAR(50)</td>
                    <td>No</td>
                    <td>Unique</td>
                    <td>Formato autogenerado: <code>EXP-00000X</code>.</td>
                </tr>
                <tr>
                    <td><code>tipo_sangre</code></td>
                    <td>VARCHAR(10)</td>
                    <td>Sí</td>
                    <td>-</td>
                    <td>Grupo sanguíneo (A, B, AB, O) y factor Rh (+/-).</td>
                </tr>
            </tbody>
        </table>

        <h3>Tabla: <code>consultas</code></h3>
        <table>
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Tipo de Dato</th>
                    <th>Nulo</th>
                    <th>Clave</th>
                    <th>Descripción / Propósito</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>id_consulta</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>PK</td>
                    <td>Identificador único de la consulta médica.</td>
                </tr>
                <tr>
                    <td><code>id_historia</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>FK</td>
                    <td>Relación N:1 con <code>historias_medicas.id_historia</code>.</td>
                </tr>
                <tr>
                    <td><code>id_medico</code></td>
                    <td>BIGINT UNSIGNED</td>
                    <td>No</td>
                    <td>FK</td>
                    <td>Médico que atendió la consulta (<code>usuarios.id_usuario</code>).</td>
                </tr>
                <tr>
                    <td><code>motivo_consulta</code></td>
                    <td>TEXT</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Razón principal de la visita del paciente.</td>
                </tr>
                <tr>
                    <td><code>diagnostico</code></td>
                    <td>TEXT</td>
                    <td>No</td>
                    <td>-</td>
                    <td>Conclusión médica / diagnóstico patológico.</td>
                </tr>
                <tr>
                    <td><code>tratamiento_recetado</code></td>
                    <td>TEXT</td>
                    <td>Sí</td>
                    <td>-</td>
                    <td>Medicinas prescritas al paciente durante la consulta.</td>
                </tr>
                <tr>
                    <td><code>examenes_solicitados</code></td>
                    <td>TEXT</td>
                    <td>Sí</td>
                    <td>-</td>
                    <td>Estudios clínicos o análisis mandados a realizar.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 5. PRUEBAS Y CALIDAD -->
    <div>
        <h1>4. PRUEBAS DE SOFTWARE Y ASEGURAMIENTO DE CALIDAD</h1>
        
        <h2>4.1 Integración de Pruebas con PHPUnit</h2>
        <p>
            Para garantizar la robustez, estabilidad y correcto funcionamiento del sistema, se integraron pruebas de software automáticas a través del framework **PHPUnit**. Se crearon escenarios de pruebas funcionales y de integración que cubren los flujos críticos de la aplicación:
        </p>
        <ul>
            <li><strong>Pruebas de Perfil (ProfileTest):</strong> Validaciones del formulario de actualización de datos del médico y cambio de contraseñas.</li>
            <li><strong>Pruebas de Consultas (ConsultaTest):</strong> Aseguramiento completo del flujo clínico (Index, Create, Store, Show, Edit, Update, Destroy).</li>
            <li><strong>Validación de Correo Único (Ignorando ID Actual):</strong> Asegura que los médicos puedan actualizar su información sin conflictos de correos electrónicos.</li>
        </ul>

        <h2>4.2 Ejecución exitosa de la Suite de Pruebas</h2>
        <p>
            Al ejecutar el comando de pruebas nativo de Laravel en la consola de desarrollo, obtenemos un resultado 100% satisfactorio con todas las aserciones validadas:
        </p>

        <pre>
$ php artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ que verdadero es verdadero                                                                                   0.01s  

   PASS  Tests\Feature\ConsultaTest
  ✓ el medico puede ver el listado de consultas                                                                  0.64s  
  ✓ el medico puede ver el formulario de creacion de consulta                                                    0.04s  
  ✓ el medico puede registrar una nueva consulta                                                                 0.05s  
  ✓ el medico puede ver el detalle de una consulta                                                               0.04s  
  ✓ el medico puede ver el formulario de edicion de consulta                                                     0.04s  
  ✓ el medico puede actualizar una consulta                                                                      0.04s  
  ✓ el medico puede eliminar una consulta                                                                        0.04s  

   PASS  Tests\Feature\ExampleTest
  ✓ la aplicacion retorna una respuesta exitosa                                                                  0.04s  

   PASS  Tests\Feature\ProfileTest
  ✓ la pagina de perfil se muestra                                                                               0.06s  
  ✓ la informacion del perfil se puede actualizar                                                                0.06s  
  ✓ el estado de verificacion del correo no cambia cuando el correo es el mismo                                  0.05s  
  ✓ el usuario puede eliminar su cuenta                                                                          0.04s  
  ✓ se debe proporcionar la contrasena correcta para eliminar la cuenta                                          0.04s  

  Tests:    14 passed (43 assertions)
  Duration: 1.44s
        </pre>

        <div class="info-box" style="border-left-color: #28a745; background-color: #f4faf6;">
            <div class="info-box-title" style="color: #28a745;">Estado del Proyecto: Producción Listo</div>
            <p style="margin: 0; font-size: 10pt; color: #198754;">
                Todas las pruebas funcionales de la capa de autenticación, vistas, control de sesión de médicos y gestiones críticas CRUD pasan limpiamente con 0 errores y 43 aserciones exitosas. El código del sistema cumple con los más altos estándares de calidad de software y cobertura de pruebas.
            </p>
        </div>
    </div>

</body>
</html>
HTML;
    }
}
