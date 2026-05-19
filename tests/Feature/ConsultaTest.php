<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Paciente;
use App\Models\HistoriaMedica;
use App\Models\Consulta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @mixin \Illuminate\Foundation\Testing\TestCase
 * @mixin \Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication
 * @mixin \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests
 */
class ConsultaTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Paciente $paciente;
    private HistoriaMedica $historiaMedica;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario (médico)
        $this->user = User::factory()->create();

        // Crear un paciente
        $this->paciente = Paciente::create([
            'primer_nombre' => 'John',
            'primer_apellido' => 'Doe',
            'documento_identidad' => '12345678',
            'fecha_nacimiento' => '1990-01-01',
            'genero' => 'Masculino',
            'id_usuario_creador' => $this->user->id_usuario,
        ]);

        // Crear su historia médica
        $this->historiaMedica = HistoriaMedica::create([
            'id_paciente' => $this->paciente->id_paciente,
            'numero_expediente' => 'EXP-000001',
            'tipo_sangre' => 'O+',
        ]);
    }

    public function test_el_medico_puede_ver_el_listado_de_consultas(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('pacientes.consultas.index', $this->paciente->id_paciente));

        $response->assertOk();
        $response->assertViewIs('consultas.index');
    }

    public function test_el_medico_puede_ver_el_formulario_de_creacion_de_consulta(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('pacientes.consultas.create', $this->paciente->id_paciente));

        $response->assertOk();
        $response->assertViewIs('consultas.create');
    }

    public function test_el_medico_puede_registrar_una_nueva_consulta(): void
    {
        $consultData = [
            'motivo_consulta' => 'Dolor de cabeza severo',
            'signos_vitales' => 'TA: 120/80 mmHg, Temp: 37°C',
            'examen_fisico' => 'Abdomen blando, no doloroso',
            'diagnostico' => 'Migraña común',
            'plan_tratamiento' => 'Descanso e hidratación',
            'tratamiento_recetado' => 'Ibuprofeno 400mg cada 8 horas por 3 días',
            'examenes_solicitados' => 'Ninguno por ahora',
        ];

        $response = $this
            ->actingAs($this->user)
            ->post(route('pacientes.consultas.store', $this->paciente->id_paciente), $consultData);

        $response->assertRedirect(route('pacientes.show', $this->paciente->id_paciente));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('consultas', [
            'id_historia' => $this->historiaMedica->id_historia,
            'motivo_consulta' => 'Dolor de cabeza severo',
            'diagnostico' => 'Migraña común',
        ]);
    }

    public function test_el_medico_puede_ver_el_detalle_de_una_consulta(): void
    {
        $consulta = Consulta::create([
            'id_historia' => $this->historiaMedica->id_historia,
            'id_medico' => $this->user->id_usuario,
            'fecha_consulta' => now(),
            'motivo_consulta' => 'Fiebre alta',
            'diagnostico' => 'Gripe viral',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('consultas.show', $consulta->id_consulta));

        $response->assertOk();
        $response->assertViewIs('consultas.show');
        $response->assertSee('Fiebre alta');
    }

    public function test_el_medico_puede_ver_el_formulario_de_edicion_de_consulta(): void
    {
        $consulta = Consulta::create([
            'id_historia' => $this->historiaMedica->id_historia,
            'id_medico' => $this->user->id_usuario,
            'fecha_consulta' => now(),
            'motivo_consulta' => 'Fiebre alta',
            'diagnostico' => 'Gripe viral',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('consultas.edit', $consulta->id_consulta));

        $response->assertOk();
        $response->assertViewIs('consultas.edit');
    }

    public function test_el_medico_puede_actualizar_una_consulta(): void
    {
        $consulta = Consulta::create([
            'id_historia' => $this->historiaMedica->id_historia,
            'id_medico' => $this->user->id_usuario,
            'fecha_consulta' => now(),
            'motivo_consulta' => 'Fiebre alta',
            'diagnostico' => 'Gripe viral',
        ]);

        $updatedData = [
            'motivo_consulta' => 'Fiebre alta y tos persistente',
            'diagnostico' => 'Bronquitis aguda',
            'tratamiento_recetado' => 'Amoxicilina 500mg cada 8 horas',
        ];

        $response = $this
            ->actingAs($this->user)
            ->put(route('consultas.update', $consulta->id_consulta), $updatedData);

        $response->assertRedirect(route('consultas.show', $consulta->id_consulta));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('consultas', [
            'id_consulta' => $consulta->id_consulta,
            'motivo_consulta' => 'Fiebre alta y tos persistente',
            'diagnostico' => 'Bronquitis aguda',
        ]);
    }

    public function test_el_medico_puede_eliminar_una_consulta(): void
    {
        $consulta = Consulta::create([
            'id_historia' => $this->historiaMedica->id_historia,
            'id_medico' => $this->user->id_usuario,
            'fecha_consulta' => now(),
            'motivo_consulta' => 'Chequeo rutinario',
            'diagnostico' => 'Paciente sano',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('consultas.destroy', $consulta->id_consulta));

        $response->assertRedirect(route('pacientes.show', $this->paciente->id_paciente));

        $this->assertDatabaseMissing('consultas', [
            'id_consulta' => $consulta->id_consulta,
        ]);
    }
}
