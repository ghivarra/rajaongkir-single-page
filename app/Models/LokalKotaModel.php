<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokalKotaModel extends Model
{
    use HasFactory;
    
    public $timestamps = FALSE;

    protected $table = 'lokal_kota';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama', 'lokal_provinsi_id', 'kodepos'];
}
