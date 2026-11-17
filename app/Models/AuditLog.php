<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_name',
        'user_email',
        'role',
        'action',
        'category',
        'resource',
        'ip_address',
        'status',
    ];
}
