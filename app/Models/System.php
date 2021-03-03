<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    public function logs()
    {
        return $this->hasMany(Log::class, 'system_id', 'id');
    }
}
