<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * mapeamento do relacionamento com salas de aula
     *
     * @return void
     */
    public function classrom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
}
