<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operasi extends Model
{
    protected $table = 'operasi';
    protected $fillable = ['denda_per_hari'];
}
