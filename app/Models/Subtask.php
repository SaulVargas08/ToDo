<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtask extends Model {


    protected $fillable = ['task_id', 'name', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
