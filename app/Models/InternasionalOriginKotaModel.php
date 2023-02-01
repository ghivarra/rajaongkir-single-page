<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternasionalOriginKotaModel extends Model
{
    use HasFactory;
    
    public $timestamps = FALSE;

    protected $table = 'internasional_origin_kota';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama', 'internasional_origin_provinsi_id', 'kodepos'];
}
