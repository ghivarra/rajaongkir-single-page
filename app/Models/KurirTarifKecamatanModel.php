<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurirTarifKecamatanModel extends Model
{
    use HasFactory;

    protected $table = 'kurir_tarif_kecamatan';
    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'kecamatan_asal_id', 'kecamatan_tujuan_id', 'last_update', 'kurir_id', 'berat', 'dimensi_panjang', 'dimensi_lebar', 'dimensi_tinggi', 'dimensi_diameter', 'rincian_biaya'];
}
