<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id'    => (int) $this->id,
            'name'  => $this->full_name,
            'birth' => $this->birth,
            'gender' => $this->gerder,
            'classroom' => (int) $this->classroom_id 
        ];
    }
}
