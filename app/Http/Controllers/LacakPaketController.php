<?php namespace App\Http\Controllers;

/**
 * Lacak Paket Controller
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

class LacakPaketController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'waybill' => $request->input('waybill'),
            'courier' => $request->input('courier'),
        ];

        // tarik kurir yang bisa cek resi
        $cekResiKurir = KurirModel::getAllAvailable('cek_resi', ['id']);
        $cekResiKurir = array_column($cekResiKurir, 'id');

        // validasi
        $validator = Validator::make($params, [
            'waybill' => [
                'required'
            ],
            'courier' => [
                'required',
                Rule::in($cekResiKurir),
            ]
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'code'        => 400,
                'status'      => 'error',
                'description' => implode(', ', $validator->errors->all())
            ]);
        }

        // library api rajaongkir
        $api = new ApiRajaongkir();
        $res = $api->cekResi($params);

        // if response kosong
        if (empty($res))
        {
            return response()->json([
                'code'        => 500,
                'status'      => 'error',
                'description' => 'Server API Rajaongkir sedang bermasalah, silahkan coba lagi dalam beberapa menit'
            ]);
        }

        // parse json
        try {

            $res = json_decode($res, TRUE);

        } catch (Exception $e) {

            return response()->json([
                'code'        => 500,
                'status'      => 'error',
                'description' => 'Server API Rajaongkir sedang bermasalah, silahkan coba lagi dalam beberapa menit'
            ]);
        }

        // mutasi rajaongkir
        $rajaongkir = $res['rajaongkir'];

        // cek error query
        if ($rajaongkir['status']['code'] != 200)
        {
            return response()->json([
                'code'        => $rajaongkir['status']['code'],
                'status'      => 'error',
                'description' => $rajaongkir['status']['description']
            ]);
        }

        // return json
        return response()->json([
            'code'        => $rajaongkir['status']['code'],
            'status'      => $rajaongkir['status']['description'],
            'description' => $rajaongkir['status']['description'],
            'result'      => $rajaongkir['result'],
            'courier'     => KurirModel::select('id', 'nama', 'nama_pendek', 'logo', 'warna')->find($params['courier'])
        ]);
    }

    //=================================================================================================
}