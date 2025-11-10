<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'tbskripsi';
    public $timestamps = false;
    protected $guarded = ['id'];
}
