<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; //mendefinisikan nama tabel yang digunakan model ini
    protected $primaryKey = 'level_id'; //mendefinisikan primary key dari tabel yang digunakan
}
