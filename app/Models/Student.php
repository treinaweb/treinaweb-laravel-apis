<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * indica os atributos para definição de dados em massa
     *
     * @var array
     */
    protected $fillable = ['name', 'birth', 'gerder', 'classroom_id'];

    // /**
    //  * Faz conversão na hora de serialização
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'birth' => 'date:d/m/Y'
    // ];

    // /**
    //  * Define atributos não mostrados depois da serialização
    //  */
    // //protected $hidden = ['created_at', 'updated_at'];

    // /**
    //  * Define os atributos visiveis depois da serialização
    //  *
    //  * @var array
    //  */
    // protected $visible = ['name', 'gerder', 'birth', 'classroom_id', 'is_accepted'];

    // /**
    //  * Define os atributos dinamicos anexos a serialização
    //  *
    //  * @var array
    //  */
    // protected $appends = ['is_accepted'];

    /**
     * mapeamento do relacionamento com salas de aula
     *
     * @return void
     */
    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }

    // /**
    //  * cria um assessor no model de studante chamado is_accepted
    //  *
    //  * @return void
    //  */
    // public function getIsAcceptedAttribute()
    // {
    //     return $this->attributes['birth'] > '2002-01-01' ? 'aceito' : 'não foi aceito';
    // }
}
