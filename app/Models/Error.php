<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;
    protected $fillable = [
        'component',
        'sequence',
        'problem',
        'resolution',
        'resolver_id',
    ];

    public function logs() {
        return $this->belongsToMany(CobLog::class,'logs_contains_errors','error_id','log_id')->withTimestamps();
    }

    public function resolver() {
        return $this->belongsTo(User::class, 'resolver_id', 'id');
    }
}
