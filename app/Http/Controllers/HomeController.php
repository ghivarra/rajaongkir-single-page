<?php namespace App\Http\Controllers;

/**
 * Home Controller
 *
 * Created with love and proud by Ghivarra Senandika Rushdie
 *
 * @package Aplikasi Cek Ongkir
 *
 * @var https://github.com/ghivarra
 * @var https://facebook.com/bcvgr
 * @var https://twitter.com/ghivarra
 *
**/

use Illuminate\Http\Request;
use App\Models\KurirModel;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'cekResiKurir'             => KurirModel::getAllAvailable('cek_resi', ['id', 'nama_pendek', 'nama']),
            'cekResiKurirNotAvailable' => KurirModel::getAllNotAvailable('cek_resi', ['id', 'nama_pendek', 'nama'])
        ];

        return view('home', $data);
    }

    //=================================================================================================
}
