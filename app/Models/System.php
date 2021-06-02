<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    protected $fillable = [
        'machine',
        'system',
        'zone',
        'release',
        'rundate',
        'creator_id',
    ];

    public function logs()
    {
        return $this->hasMany(Log::class, 'system_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
