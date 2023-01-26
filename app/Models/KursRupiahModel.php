<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KursRupiahModel extends Model
{
    use HasFactory;

    protected $table = 'kurs_rupiah';
    protected $primaryKey = 'id';
    protected $incrementing = TRUE;
    
    protected $fillable = ['id', 'mata_uang', 'mata_uang_pendek', 'value', 'sumber_nama', 'sumber_link', 'last_update'];
}
