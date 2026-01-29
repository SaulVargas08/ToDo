<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        try {
            $tags = Tag::all();
            return response()->json($tags, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las etiquetas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:tags,name|max:255',
            ], [
                'name.required' => 'El nombre de la etiqueta es obligatorio.',
                'name.string' => 'El nombre de la etiqueta debe ser un texto.',
                'name.unique' => 'Esta etiqueta ya existe.',
                'name.max' => 'El nombre de la etiqueta no puede superar los 255 caracteres.',
            ]);

            $tag = Tag::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Etiqueta creada exitosamente.',
                'tag' => $tag
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación.',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la etiqueta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function assignTag(Request $request, Task $task)
    {
        try {

            return response()->json([
                'message' => 'Esto funca...'
            ], 200);



            $data = json_decode($request->getContent(), true);

            $validated = $request->validate([
                'tag_id' => 'required|exists:tags,id',
            ], [
                'tag_id.required' => 'El campo tag_id es obligatorio.',
                'tag_id.exists' => 'La etiqueta seleccionada no existe en la base de datos.',
            ])->validate();

            if ($task->tags()->where('tag_id', $validated['tag_id'])->exists()) {
                return response()->json([
                    'message' => 'Esta etiqueta ya está asignada a la tarea.'
                ], 400);
            }

            $task->tags()->attach($validated['tag_id']);

            return response()->json([
                'message' => 'Etiqueta asignada correctamente.'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar la etiqueta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removeTag(Task $task, Tag $tag)
    {
        try {
            if (!$task->tags()->where('tag_id', $tag->id)->exists()) {
                return response()->json([
                    'message' => 'La etiqueta no está asignada a esta tarea.'
                ], 404);
            }

            $task->tags()->detach($tag);

            return response()->json([
                'message' => 'Etiqueta removida correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al remover la etiqueta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
