<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKotaModel extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kota';
    protected $primaryKey = 'id';
    protected $incrementing = TRUE;
    
    protected $fillable = ['id', 'nama', 'lokasi_provinsi_id'];
}
