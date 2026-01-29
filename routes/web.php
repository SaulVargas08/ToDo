<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/manager', function () {
    return view('manager');
});

Route::view('/projects-module', 'modules.projects');
Route::view('/tasks-module', 'modules.tasks');
Route::view('/subtasks-module', 'modules.subtasks');
Route::view('/tags-module', 'modules.tags');

// Puedes agregar mケs rutas aquヴ si es necesario.

Route::get('/reports/projects', [ReportController::class, 'projectReport']);

// Ruta para el reporte de tareas (esto debe ir en api.php, no en web.php)
Route::get('/reports/tasks', [ReportController::class, 'tasksReport']);
