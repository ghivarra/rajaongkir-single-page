<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternasionalTujuanModel extends Model
{
    use HasFactory;

    public $timestamps = FALSE;

    protected $table = 'internasional_tujuan';
    protected $primaryKey = 'id';    
    protected $fillable = ['id', 'nama', 'nama_trans'];
}
