<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'birth', 'gerder', 'classroom_id'];

    /**
     * mapeamento do relacionamento com salas de aula
     *
     * @return void
     */
    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
}
