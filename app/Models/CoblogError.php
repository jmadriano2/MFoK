<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoblogError extends Model
{
    use HasFactory;
    protected $table = 'logs_contains_errors';
}
