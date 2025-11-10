<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tbmahasiswa';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'idMhs',  'id');
    }

    public function yudisium()
    {
        return $this->hasOne(Yudisium::class, 'NPM',  'NPM');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'NPM',  'NPM');
    }
}
