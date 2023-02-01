<?php namespace App\Http\Controllers;

/**
 * Update Controller
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
use App\Libraries\ApiRajaongkirLibrary as ApiRajaongkir;
use App\Models\LokalProvinsiModel;

class UpdateController extends Controller
{
    private function cekToken(string $inputToken)
    {
        $token = env('UPDATE_TOKEN');
        return ($inputToken === $token) ? TRUE : FALSE;
    }

    //=================================================================================================

    public function provinsi(Request $request)
    {
        $inputToken = $request->input('token');

        if (!$this->cekToken($inputToken))
        {
            return response()->json([
                'code' => 403,
                'desc' => 'Anda tidak memiliki izin untuk mengakses halaman ini'
            ], 403);
        }

        $api = new ApiRajaongkir();
        $res = $api->getProvince();

        try {

            $res = json_decode($res, TRUE);

        } catch (Exception $e) {

            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);  
        }

        if (!isset($res['rajaongkir']))
        {
            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);   
        }

        foreach ($res['rajaongkir']['results'] as $item):

            LokalProvinsiModel::updateOrCreate([
                'id'    => $item['province_id'],
                'nama'  => $item['province']
            ]);

        endforeach;

        // return
        return 'OK';
    }

    //=================================================================================================
}
