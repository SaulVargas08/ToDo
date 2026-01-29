<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;



// Rutas para proyectos
Route::apiResource('projects', ProjectController::class);

// Rutas para tareas
Route::apiResource('tasks', TaskController::class);

// Rutas para subtareas
Route::apiResource('subtasks', SubtaskController::class);

Route::put('/subtasks/{id}', [SubtaskController::class, 'update']);

// Rutas para etiquetas
Route::apiResource('tags', TagController::class);

Route::get('tags/list', [TagController::class, 'list'])->name('tags.list');

// Rutas personalizadas para la relación entre tareas y etiquetas
Route::delete('tasks/{task}/tags/{tag}', [TagController::class, 'removeTag']);

Route::post('/tasks/{id}/tags', [TaskController::class, 'assignTags']);

// Ruta para el reporte de tareas
Route::get('/reports/tasks', [ReportController::class, 'tasksReport']);

// Ruta para el reporte de proyectos
Route::get('/reports/projects', [ReportController::class, 'projectReport']);
//Ruta para eliminar subtareas
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy']);
// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
