<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_number' => $this->student_number,
            'name' => $this->name,
            'email' => $this->email,
            'course' => $this->course,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'guardian_name' => $this->guardian_name,
            'guardian_phone' => $this->guardian_phone,
            'created_at' => $this->created_at,
        ];
    }
}
