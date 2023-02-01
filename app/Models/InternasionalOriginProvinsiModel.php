<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternasionalOriginProvinsiModel extends Model
{
    use HasFactory;

    public $timestamps = FALSE;

    protected $table = 'internasional_origin_provinsi';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama'];
}
