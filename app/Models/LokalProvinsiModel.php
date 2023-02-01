<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokalProvinsiModel extends Model
{
    use HasFactory;

    public $timestamps = FALSE;

    protected $table = 'lokal_provinsi';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama'];
}
