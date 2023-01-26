<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKecamatanModel extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kecamatan';
    protected $primaryKey = 'id';
    protected $incrementing = TRUE;
    
    protected $fillable = ['id', 'nama', 'lokasi_kota_id', 'lokasi_provinsi_id'];
}
