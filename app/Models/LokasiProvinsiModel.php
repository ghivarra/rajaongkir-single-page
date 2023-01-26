<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiProvinsiModel extends Model
{
    use HasFactory;

    protected $table = 'lokasi_provinsi';
    protected $primaryKey = 'id';
    protected $incrementing = TRUE;
    
    protected $fillable = ['id', 'nama'];
}
