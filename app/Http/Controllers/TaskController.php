<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tasks = Task::query();
    
            if ($request->has('status')) {
                $tasks->where('status', $request->input('status'));
            }
    
            return response()->json([
                'success' => true,
                'tasks' => $tasks->get(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la lista de tareas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:pendiente,en progreso,completada',
                'priority' => 'required|in:alta,media,baja',
                'due_date' => 'nullable|integer|date_format:U', // Cambiado para aceptar timestamp
            ], [
                'project_id.required' => 'El campo proyecto es obligatorio.',
                'project_id.exists' => 'El proyecto seleccionado no existe.',
                'name.required' => 'El campo nombre es obligatorio.',
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'description.string' => 'El campo descripción debe ser una cadena de texto.',
                'status.required' => 'El campo estado es obligatorio.',
                'status.in' => 'El campo estado debe ser uno de los siguientes valores: pendiente, en progreso, completada.',
                'priority.required' => 'El campo prioridad es obligatorio.',
                'priority.in' => 'El campo prioridad debe ser uno de los siguientes valores: alta, media, baja.',
                'due_date.integer' => 'El campo fecha de vencimiento debe ser un número entero (timestamp).',
                'due_date.date_format' => 'El campo fecha de vencimiento debe ser un timestamp válido.',
            ]);

            if (isset($validatedData['due_date'])) {
                $validatedData['due_date'] = date('Y-m-d H:i:s', $validatedData['due_date']);
            }
    
            $task = DB::transaction(function () use ($validatedData) {
                return Task::create($validatedData);
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Tarea creada exitosamente.',
                'task' => $task,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'status' => 'sometimes|required|in:pendiente,en progreso,completada',
                'priority' => 'sometimes|required|in:alta,media,baja',
                'due_date' => 'sometimes|nullable|date',
            ], [
                'name.required' => 'El campo nombre es obligatorio.',
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'description.string' => 'El campo descripción debe ser una cadena de texto.',
                'status.required' => 'El campo estado es obligatorio.',
                'status.in' => 'El campo estado debe ser uno de los siguientes valores: pendiente, en progreso, completada.',
                'priority.required' => 'El campo prioridad es obligatorio.',
                'priority.in' => 'El campo prioridad debe ser uno de los siguientes valores: alta, media, baja.',
                'due_date.date' => 'El campo fecha de vencimiento debe ser una fecha válida.',
            ]);
    
            $task = Task::findOrFail($id);
    
            $task->update($validatedData);
    
            return response()->json([
                'success' => true,
                'message' => 'Tarea actualizada exitosamente.',
                'task' => $task,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
    
            $task->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Tarea eliminada exitosamente.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'La tarea no fue encontrada.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage(),
            ], 500);
        }
    } 
    public function assignTags(Request $request, $taskId){
    try {

        $task = Task::find($taskId);

        if(empty($task))
            throw new \Exception("Tarea no existe.", 1);
        

        // Validar los datos de entrada
        $validated = $request->validate([
            'tag_ids' => 'required',
        ], [
            'tag_ids.required' => 'Debes proporcionar al menos una etiqueta.',
        ]);

        $tags = explode(',', $validated['tag_ids']);
        

        // Asignar las etiquetas a la tarea
        $task->tags()->sync($tags);

       

        return response()->json([
            'success' => true,
            'message' => 'Etiquetas asignadas correctamente.',
            'task' => $task->load('tags'),
        ], 200);


    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Errores de validación.',
            'errors' => $e->getMessage(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error inesperado.',
            'error' => $e->getMessage(),
        ], 500);
    }
    }

    
}