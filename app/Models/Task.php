<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Task;


class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'description', 'status', 'priority', 'due_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id');
    }


public function tasksReport(Request $request)
{
    $tasks = Task::query();

    // Aplicar filtros si existen
    if ($request->has('status')) {
        $tasks->where('status', $request->status);
    }
    if ($request->has('priority')) {
        $tasks->where('priority', $request->priority);
    }

    return response()->json([
        'message' => 'Reporte generado con éxito',
        'data' => $tasks->get(), // Retorna las tareas filtradas
        
    ]);
}

    
}
