<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurirModel extends Model
{
    use HasFactory;

    protected $table = 'kurir';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    
    protected $fillable = ['id', 'nama', 'nama_pendek', 'logo', 'is_aktif', 'is_cek_ongkir', 'is_cek_resi', 'is_lokal', 'is_internasional', 'warna'];

    protected static $allKurir = [];

    //=====================================================================================================

    public static function getAllActive()
    {
        if (empty(self::$allKurir))
        {
            $getAll = self::where('is_aktif', 1)
                          ->orderBy('nama_pendek', 'ASC')
                          ->get();

            self::$allKurir = $getAll;

            return $getAll;
        }

        return self::$allKurir;
    }

    //=====================================================================================================

    public static function getAllAvailable(string $column = 'cek_ongkir', array $select = NULL)
    {
        if (empty(self::$allKurir))
        {
            self::getAllActive();
        }

        $column = "is_{$column}";
        $kurir  = [];

        foreach (self::$allKurir as $item):

            if ($item[$column] == 1)
            {
                if (empty($select))
                {
                    array_push($kurir, $item);

                } else {

                    $newItem = [];

                    foreach ($select as $key)
                    {
                        $newItem[$key] = $item[$key];
                    }

                    array_push($kurir, $newItem);
                }
            }

        endforeach;

        return $kurir;
    }

    //=====================================================================================================

    public static function getAllNotAvailable(string $column = 'cek_ongkir', array $select = NULL)
    {
        if (empty(self::$allKurir))
        {
            self::getAllActive();
        }

        $column = "is_{$column}";
        $kurir  = [];

        foreach (self::$allKurir as $item):

            if ($item[$column] == 0)
            {
                if (empty($select))
                {
                    array_push($kurir, $item);

                } else {

                    $newItem = [];

                    foreach ($select as $key)
                    {
                        $newItem[$key] = $item[$key];
                    }

                    array_push($kurir, $newItem);
                }
            }

        endforeach;

        return $kurir;
    }

    //=====================================================================================================
}