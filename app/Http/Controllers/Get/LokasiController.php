<?php namespace App\Http\Controllers\Get;

/**
 * Lokasi Controller
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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LokalKecamatanModel;
use App\Models\LokalKotaModel;
use App\Models\InternasionalOriginKotaModel;
use App\Models\InternasionalOriginProvinsiModel;
use App\Models\InternasionalTujuanModel;

class LokasiController extends Controller
{
    public function origin(Request $request)
    {
        $data = [
            'type'  => $request->input('type'),
            'query' => $request->input('query'),
        ];

        if (empty($data['query']))
        {
            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);
        }

        if ($data['type'] == 'lokal')
        {
            $searchKecamatan = LokalKecamatanModel::selectRaw("CONCAT('subdistrict-', lokal_kecamatan.id) as value, CONCAT(lokal_kecamatan.nama, ' - ', lokal_kota.nama, ', ', lokal_provinsi.nama) as label")
                                                  ->where('lokal_kecamatan.nama', 'ilike', "%{$data['query']}%")
                                                  ->leftJoin('lokal_kota', 'lokal_kota_id', '=', 'lokal_kota.id')
                                                  ->leftJoin('lokal_provinsi', 'lokal_kecamatan.lokal_provinsi_id', '=', 'lokal_provinsi.id')
                                                  ->orderBy('lokal_kecamatan.nama', 'ASC')
                                                  ->limit(25)
                                                  ->get()
                                                  ->toArray();

            $searchKota = LokalKotaModel::selectRaw("CONCAT('city-', lokal_kota.id) as value, CONCAT(lokal_kota.nama, ' - ', lokal_provinsi.nama) as label")
                                        ->where('lokal_kota.nama', 'ilike', "%{$data['query']}%")
                                        ->leftJoin('lokal_provinsi', 'lokal_provinsi_id', '=', 'lokal_provinsi.id')
                                        ->orderBy('lokal_kota.nama', 'ASC')
                                        ->limit(25)
                                        ->get()
                                        ->toArray();

            // cari
            return response()->json([
                'code'   => 200,
                'result' => array_merge($searchKecamatan, $searchKota)
            ], 200);

        } elseif ($data['type'] == 'internasional') {

            $searchOrigin = InternasionalOriginKotaModel::selectRaw("internasional_origin_kota.id as value, CONCAT(internasional_origin_kota.nama, ', ', internasional_origin_provinsi.nama) as label")
                                                        ->where('internasional_origin_kota.nama', 'ilike', "%{$data['query']}%")
                                                        ->leftJoin('internasional_origin_provinsi', 'internasional_origin_kota.internasional_origin_provinsi_id', '=', 'internasional_origin_provinsi.id')
                                                        ->orderBy('internasional_origin_kota.nama', 'ASC')
                                                        ->limit(25)
                                                        ->get()
                                                        ->toArray();

            return response()->json([
                'code'   => 200,
                'result' => $searchOrigin
            ], 200);

        } else {

            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);
        }
    }

    //===========================================================================================

    public function destination(Request $request)
    {
        $data = [
            'type'  => $request->input('type'),
            'query' => $request->input('query'),
        ];

        if (empty($data['query']))
        {
            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);
        }

        if ($data['type'] == 'lokal')
        {
            $searchKecamatan = LokalKecamatanModel::selectRaw("CONCAT('subdistrict-', lokal_kecamatan.id) as value, CONCAT(lokal_kecamatan.nama, ' - ', lokal_kota.nama, ', ', lokal_provinsi.nama) as label")
                                                  ->where('lokal_kecamatan.nama', 'ilike', "%{$data['query']}%")
                                                  ->leftJoin('lokal_kota', 'lokal_kota_id', '=', 'lokal_kota.id')
                                                  ->leftJoin('lokal_provinsi', 'lokal_kecamatan.lokal_provinsi_id', '=', 'lokal_provinsi.id')
                                                  ->orderBy('lokal_kecamatan.nama', 'ASC')
                                                  ->limit(25)
                                                  ->get()
                                                  ->toArray();

            $searchKota = LokalKotaModel::selectRaw("CONCAT('city-', lokal_kota.id) as value, CONCAT(lokal_kota.nama, ' - ', lokal_provinsi.nama) as label")
                                        ->where('lokal_kota.nama', 'ilike', "%{$data['query']}%")
                                        ->leftJoin('lokal_provinsi', 'lokal_provinsi_id', '=', 'lokal_provinsi.id')
                                        ->orderBy('lokal_kota.nama', 'ASC')
                                        ->limit(25)
                                        ->get()
                                        ->toArray();

            // cari
            return response()->json([
                'code'   => 200,
                'result' => array_merge($searchKecamatan, $searchKota)
            ], 200);

        } elseif ($data['type'] == 'internasional') {

            $search = InternasionalTujuanModel::selectRaw('id as value, nama_trans as label')
                                              ->where('internasional_tujuan.nama_trans', 'ilike', "%{$data['query']}%")
                                              ->orWhere('internasional_tujuan.nama', 'ilike', "%{$data['query']}%")
                                              ->orderBy('internasional_tujuan.nama_trans', 'ASC')
                                              ->limit(25)
                                              ->get()
                                              ->toArray();

            return response()->json([
                'code'   => 200,
                'result' => $search
            ], 200);

        } else {

            return response()->json([
                'code' => 400,
                'desc' => 'Bad Parameters'
            ], 400);
        }
    }

    //===========================================================================================
}