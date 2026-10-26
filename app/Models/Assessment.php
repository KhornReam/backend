<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    protected $fillable = ['class_subject_id', 'title', 'type', 'max_score', 'due_date', 'description'];

    protected function casts(): array
    {
        return ['max_score' => 'decimal:2', 'due_date' => 'date'];
    }

    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
