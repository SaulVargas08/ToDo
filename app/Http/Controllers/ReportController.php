<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ReportController extends Controller
{
    public function tasksReport(Request $request)
    {
        // Obtiene todas las tareas
        $tasks = Task::all(); // Puedes agregar filtros según sea necesario

        // Devuelve las tareas como un reporte en formato JSON
        return response()->json([
            'message' => 'Reporte generado con éxito',
             'data' => $tasks
        ], 200);
    }

    public function projectReport() {

        // Simulación de respuesta
        return response()->json([
            'report' => [
                [
                    'id' => 1,
                    'name' => 'Proyecto A',
                    'status' => 'activo',
                    'tasks_count' => 10,
                    'completed_tasks' => 5,
                ]
            ]
        ]);

        
    }

}
