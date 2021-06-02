<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'system_id',
        'description',
        'runday',
        'next_working_day',
        'start',
        'status',
        'runtime',
        'conclusion',
        'logger_id',
    ];

    public function system() {
        return $this->belongsTo(System::class, 'system_id', 'id');
    }

    public function logger() {
        return $this->belongsTo(User::class, 'logger_id', 'id');
    }

    public function errors() {
        return $this->belongsToMany(Error::class,'logs_contains_errors','log_id','error_id')->withTimestamps();
    }
}
