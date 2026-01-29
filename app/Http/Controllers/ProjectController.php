<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Projects", description="Gestión de proyectos")
 */
class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Listar proyectos",
     *     @OA\Response(response=200, description="Lista de proyectos")
     * )
     */
    public function index()
    {
        try {
            $projects = Project::all();

            return response()->json([
                'success' => true,
                'projects' => $projects
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la lista de proyectos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Crear proyecto",
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/Project")),
     *     @OA\Response(response=201, description="Proyecto creado")
     * )
     */
    public function store(Request $request) {
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:activo,pausado,completado',
                'start_date' => 'nullable|date',
                'end_date' => 'required|date',
            ], [
                'name.required' => 'El campo nombre es requerido.',
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'description.string' => 'El campo descripción debe ser una cadena de texto.',
                'status.required' => 'El campo estado es requerido.',
                'status.in' => 'El campo estado debe ser uno de los siguientes valores: activo, pausado o completado.',
                'start_date.date' => 'El campo fecha de inicio debe ser una fecha válida.',
                'end_date.required' => 'El campo fecha de finalización es obligatorio.',
                'end_date.date' => 'El campo fecha de finalización debe ser una fecha válida.',
            ]);
            

            $project = Project::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado correctamente.',
                'project' => $project
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proyecto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Project $project)
    {
        try {
            return response()->json([
                'success' => true,
                'project' => $project
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proyecto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $projectId) {
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:activo,pausado,completado',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
            ], [
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'description.required' => 'El campo descripcion es requerido',
                'description.string' => 'El campo descripción debe ser una cadena de texto.',
                'status.required' => 'El campo status es requerido',
                'status.in' => 'El campo estado debe ser uno de los siguientes valores: activo, pausado o completado.',
                'start_date.date' => 'El campo fecha de inicio debe ser una fecha válida.',
                'end_date.date' => 'El campo fecha de finalización debe ser una fecha válida.',
            ]);

            $project = Project::findOrFail($projectId);

            $project->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'El registro se actualizo con exito',
                'proyect' => $project
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proyecto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($projectId) {
        try {

            $project = Project::find($projectId);
            
            if(empty($project)){      

                return response()->json([
                    'success' => true,
                    'message' => 'Proyecto no existe.'
                ], 200);


            }
 
            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proyecto eliminado correctamente.'
            ], 200);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proyecto.',
                'error' => $e->getMessage()
            ], 500);
            
        }
    }


}
 