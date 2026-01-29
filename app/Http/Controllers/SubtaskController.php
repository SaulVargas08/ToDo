<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function index()
    {
        return response()->json(Subtask::with('task')->get());
    }

    public function store(Request $request)
    {
        try {
            // Validar datos
            $validatedData = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'name' => 'required|string|max:255',
                'status' => 'required|in:pendiente,completada',
            ], [
                'task_id.required' => 'El campo tarea es obligatorio.',
                'task_id.exists' => 'La tarea seleccionada no existe.',
                'name.required' => 'El campo nombre es obligatorio.',
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'status.required' => 'El campo estado es obligatorio.',
                'status.in' => 'El estado debe ser "pendiente" o "completada".',
            ]);

            // Crear la subtarea
            $subtask = Subtask::create($validatedData);

            // Retornar la respuesta
            return response()->json([
                'success' => true,
                'message' => 'Subtarea creada exitosamente',
                'subtask' => $subtask,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errores de validación
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Errores generales
            return response()->json([
                'message' => 'Ocurrió un error inesperado al crear la subtarea.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($subtask) {
        try {
            $sub = Subtask::find($subtask);

            if (!$sub) {
                return response()->json(['message' => 'Subtarea no encontrada.'], 404);
            }

            // Eliminar la subtarea
            $sub->delete();

            // Retornar una respuesta exitosa
            return response()->json([
                'message' => 'Subtarea eliminada exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'message' => 'Ocurrió un error al intentar eliminar la subtarea.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Encuentra la subtarea por ID
            $subtask = Subtask::find($id);

            if (!$subtask) {
                return response()->json(['message' => 'Subtarea no encontrada.'], 404);
            }

            // Valida los datos de entrada
            $validated = $request->validate([
                'task_id' => 'exists:tasks,id',
                'name' => 'string|max:255',
                'status' => 'in:pendiente,completada',
            ], [
                'task_id.exists' => 'La tarea seleccionada no existe.',
                'name.string' => 'El campo nombre debe ser una cadena de texto.',
                'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
                'status.in' => 'El estado debe ser "pendiente" o "completada".',
            ]);

            // Actualiza los campos permitidos
            $subtask->update($validated);

            // Retorna la respuesta de éxito
            return response()->json([
                'message' => 'Subtarea actualizada con éxito.',
                'data' => $subtask
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error inesperado al actualizar la subtarea.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
