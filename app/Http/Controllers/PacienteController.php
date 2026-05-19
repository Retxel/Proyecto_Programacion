<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\HistoriaMedica;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::with('historiaMedica')->where('id_usuario_creador', Auth::id())->get();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento_identidad' => 'required|unique:pacientes,documento_identidad',
            'primer_nombre' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'tipo_sangre' => 'nullable|string',
        ]);

        $paciente = new Paciente($request->all());
        $paciente->id_usuario_creador = Auth::id();
        $paciente->save();

        $historia = HistoriaMedica::create([
            'id_paciente' => $paciente->id_paciente,
            'numero_expediente' => 'EXP-' . str_pad($paciente->id_paciente, 6, '0', STR_PAD_LEFT),
            'tipo_sangre' => null, // Ya no se recibe en este form
        ]);

        // Guardar antecedentes si existen
        $tiposAntecedentes = [
            'Personales' => 'antecedentes_personales',
            'Quirúrgicos' => 'antecedentes_quirurgicos',
            'Familiares' => 'antecedentes_familiares'
        ];

        foreach ($tiposAntecedentes as $tipo => $campo) {
            if ($request->filled($campo)) {
                $historia->antecedentes()->create([
                    'tipo_antecedente' => $tipo,
                    'descripcion' => $request->$campo,
                ]);
            }
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado con éxito.');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load('historiaMedica.consultas');
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'documento_identidad' => 'required|unique:pacientes,documento_identidad,' . $paciente->id_paciente . ',id_paciente',
            'primer_nombre' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
        ]);

        $paciente->update($request->all());

        if ($request->has('tipo_sangre') && $paciente->historiaMedica) {
            $paciente->historiaMedica->update([
                'tipo_sangre' => $request->tipo_sangre
            ]);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado con éxito.');
    }

    public function destroy(Paciente $paciente)
    {
        if($paciente->historiaMedica) {
            $paciente->historiaMedica->delete();
        }
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado con éxito.');
    }

    public function exportPdf(Paciente $paciente)
    {
        // Cargar las relaciones necesarias
        $paciente->load(['historiaMedica.consultas.medico', 'historiaMedica.antecedentes']);
        
        $pdf = Pdf::loadView('pacientes.pdf', compact('paciente'));
        
        // Devolver el archivo PDF para descarga con el nombre del paciente
        $filename = 'Expediente_' . $paciente->documento_identidad . '.pdf';
        return $pdf->download($filename);
    }
}
