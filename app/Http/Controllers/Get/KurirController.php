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
        $kurir = KurirModel::getAllAvailable('lokal', ['id', 'nama']);
        return response()->json($kurir);
    }

    //===========================================================================================

    public function internasional(Request $request)
    {
        $kurir = KurirModel::getAllAvailable('internasional', ['id', 'nama']);
        return response()->json($kurir);
    }

    //===========================================================================================
}