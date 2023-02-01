<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokalKecamatanModel extends Model
{
    use HasFactory;

    public $timestamps = FALSE;

    protected $table = 'lokal_kecamatan';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama', 'lokal_kota_id', 'lokal_provinsi_id'];
}
