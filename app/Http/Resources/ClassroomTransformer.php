<?php
namespace App\Http\Resources;

use League\Fractal;

class ClassroomTransformer extends Fractal\TransformerAbstract
{
	public function transform($classroom)
	{
	    return [
	        'id'      => (int) $classroom->id,
	        'description'   => $classroom->description,
	    ];
	}
}