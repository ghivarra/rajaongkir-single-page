<?php namespace App\Http\Controllers;

/**
 * Cek Ongkir Controller
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
use App\Libraries\ApiRajaongkirLibrary as ApiRajaongkir;
use App\Models\KurirModel;

class CekOngkirController extends Controller
{
    public function lokal(Request $request)
    {
        
    }

    //===========================================================================================

    public function internasional(Request $request)
    {

    }

    //===========================================================================================
}