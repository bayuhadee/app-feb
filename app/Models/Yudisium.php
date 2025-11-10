<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Yudisium extends Model
{
    use HasFactory;

    protected $table = 'tbyudisium';
    public $timestamps = false;
    protected $guarded = ['id'];
}
