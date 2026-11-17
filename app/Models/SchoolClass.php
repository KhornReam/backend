<?php

namespace App\Models;

use Database\Factories\SchoolClassFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    /** @use HasFactory<SchoolClassFactory> */
    use HasFactory;

    protected $fillable = [
        'grade',
        'section',
    ];

    protected $appends = ['name'];

    protected function name(): Attribute
    {
        return Attribute::get(fn (): string => $this->grade.'('.$this->section.')');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
