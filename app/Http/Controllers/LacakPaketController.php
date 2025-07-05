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
                'description' => $validator->errors()
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

        } catch (\Exception $e) {

            return response()->json([
                'code'        => 500,
                'status'      => 'error',
                'description' => 'Server API Rajaongkir sedang bermasalah, silahkan coba lagi dalam beberapa menit'
            ]);
        }

        if (!isset($res['rajaongkir']))
        {
            return response()->json([
                'code'        => 400,
                'status'      => 'warning',
                'description' => 'Resi pengiriman yang anda input sudah kadaluarsa'
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

        // cek error kadaluarsa
        if (empty($rajaongkir['result']['summary']['waybill_number']))
        {
            return response()->json([
                'code'        => 400,
                'status'      => 'warning',
                'description' => 'Resi pengiriman yang anda input sudah kadaluarsa'
            ]);
        }

        // mutasi data manifest ke history & details date
        $historyDate = [];

        foreach ($rajaongkir['result']['manifest'] as $n => $item):

            if (!in_array($item['manifest_date'], $historyDate))
            {
                // push and get key
                array_push($historyDate, $item['manifest_date']);
                $key = array_search($item['manifest_date'], $historyDate);

                // create
                $rajaongkir['result']['history'][$key] = [
                    'day'       => id_time('EEEE', strtotime($item['manifest_date'])),
                    'date'      => id_time('dd MMM YYYY', strtotime($item['manifest_date'])),
                    'manifests' => []
                ];

            } else {

                $key = array_search($item['manifest_date'], $historyDate);
            }

            array_push($rajaongkir['result']['history'][$key]['manifests'], [
                'code' => $item['manifest_code'],
                'time' => "{$item['manifest_time']} WIB",
                'desc' => $item['manifest_description'],
            ]);

        endforeach;

        // mutasi details
        $rajaongkir['result']['details']['datetime'] = id_time('dd MMM YYYY - HH:mm', strtotime("{$rajaongkir['result']['details']['waybill_date']} {$rajaongkir['result']['details']['waybill_time']}")) . ' WIB';

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