<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function index(Paciente $paciente)
    {
        // Cargar historia médica y sus consultas asociadas
        $paciente->load('historiaMedica.consultas.medico');
        $consultas = $paciente->historiaMedica ? $paciente->historiaMedica->consultas->sortByDesc('fecha_consulta') : collect();
        return view('consultas.index', compact('paciente', 'consultas'));
    }

    public function create(Paciente $paciente)
    {
        return view('consultas.create', compact('paciente'));
    }

    public function store(Request $request, Paciente $paciente)
    {
        $request->validate([
            'motivo_consulta' => 'required|string',
            'signos_vitales' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan_tratamiento' => 'nullable|string',
            'tratamiento_recetado' => 'nullable|string',
            'examenes_solicitados' => 'nullable|string',
        ]);

        if (!$paciente->historiaMedica) {
            return redirect()->back()->with('error', 'El paciente no tiene una historia médica activa.');
        }

        Consulta::create([
            'id_historia' => $paciente->historiaMedica->id_historia,
            'id_medico' => Auth::id(),
            'fecha_consulta' => now(),
            'motivo_consulta' => $request->motivo_consulta,
            'signos_vitales' => $request->signos_vitales,
            'examen_fisico' => $request->examen_fisico,
            'diagnostico' => $request->diagnostico,
            'plan_tratamiento' => $request->plan_tratamiento,
            'tratamiento_recetado' => $request->tratamiento_recetado,
            'examenes_solicitados' => $request->examenes_solicitados,
        ]);

        return redirect()->route('pacientes.show', $paciente->id_paciente)->with('success', 'Consulta registrada exitosamente.');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load('medico', 'historiaMedica.paciente');
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        return view('consultas.edit', compact('consulta'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $request->validate([
            'motivo_consulta' => 'required|string',
            'signos_vitales' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan_tratamiento' => 'nullable|string',
            'tratamiento_recetado' => 'nullable|string',
            'examenes_solicitados' => 'nullable|string',
        ]);

        $consulta->update($request->only([
            'motivo_consulta', 'signos_vitales', 'examen_fisico', 'diagnostico', 'plan_tratamiento',
            'tratamiento_recetado', 'examenes_solicitados'
        ]));

        return redirect()->route('consultas.show', $consulta->id_consulta)->with('success', 'Consulta actualizada exitosamente.');
    }

    public function destroy(Consulta $consulta)
    {
        $idPaciente = $consulta->historiaMedica->id_paciente;
        Consulta::destroy($consulta->id_consulta);

        return redirect()->route('pacientes.show', $idPaciente)->with('success', 'Consulta eliminada exitosamente.');
    }
}
