<?php namespace App\Http\Controllers\Get;

/**
 * Kurir Controller
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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\KurirModel;
use App\Http\Controllers\Controller;

class KurirController extends Controller
{
    public function lokal(Request $request)
    {
        return response()->json([
            'code'   => 200,
            'result' => KurirModel::getAllAvailable('lokal', ['id', 'nama', 'nama_pendek'])
        ]);
    }

    //===========================================================================================

    public function internasional(Request $request)
    {
        return response()->json([
            'code'   => 200,
            'result' => KurirModel::getAllAvailable('internasional', ['id', 'nama', 'nama_pendek'])
        ]);
    }

    //===========================================================================================
}