<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\LinksGenerator;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $links = new LinksGenerator;
        $links->addGet('self', route('students.show', $this->id));
        $links->addPut('update', route('students.update', $this->id));
        $links->addDelete('delete', route('students.destroy', $this->id));

        return [
            'id'    => (int) $this->id,
            'name'  => $this->name,
            'birth' => $this->birth,
            'gender' => $this->gerder,
            'classroom' => new Classroom($this->whenLoaded('classroom')),
            'links' => $links->toArray() 
        ];
    }
}
