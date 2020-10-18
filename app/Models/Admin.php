<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'username';
    public $incrementing = false;
    public $timestamps = false;

    use HasFactory;
}
