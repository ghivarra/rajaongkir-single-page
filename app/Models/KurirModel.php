<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurirModel extends Model
{
    use HasFactory;

    protected $table = 'permohonan_lsp';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $guarded = [];
    protected $fillable = ['id', 'nama', 'nama_pendek', 'logo', 'is_aktif', 'is_cek_ongkir', 'is_cek_resi', 'is_lokal', 'is_internasional', 'warna'];

    protected $dispatchesEvents = [];
}