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
        $originInput      = $request->input('origin');
        $originInput      = explode('-', $originInput);
        $destinationInput = $request->input('destination');
        $destinationInput = explode('-', $destinationInput);

        // create params
        $params = [
            'courier'         => $request->input('courier'),
            'origin'          => $originInput[1],
            'originType'      => $originInput[0],
            'destination'     => $destinationInput[1],
            'destinationType' => $destinationInput[0],
            'weight'          => floatval(str_ireplace([' ', 'kg', ','], ['', '', '.'], $request->input('weight'))) * 1000,
        ];

        // cek dimensi
        $dimensions = [
            'length'   => floatval(str_ireplace([' ', 'kg', ','], ['', '', '.'], $request->input('length'))),
            'width'    => floatval(str_ireplace([' ', 'kg', ','], ['', '', '.'], $request->input('width'))),
            'height'   => floatval(str_ireplace([' ', 'kg', ','], ['', '', '.'], $request->input('height'))),
            'diameter' => floatval(str_ireplace([' ', 'kg', ','], ['', '', '.'], $request->input('diameter'))),
        ];

        foreach ($dimensions as $key => $value):

            if (empty($value))
            {
                unset($dimensions[$key]);

            } else {

                $params[$key] = $value;
            }

        endforeach;


        // get all available kurir
        $availableKurir = KurirModel::getAllAvailable('lokal', ['id']);
        $availableKurir = array_column($availableKurir, 'id');

        // validasi
        $validator = Validator::make($params, [
            'courier'         => ['required', Rule::in($availableKurir)],
            'origin'          => ['required'],
            'originType'      => ['required', Rule::in(['subdistrict', 'city'])],
            'destination'     => ['required'],
            'destinationType' => ['required', Rule::in(['subdistrict', 'city'])],
            'weight'          => ['required', 'numeric'],
            'length'          => ['numeric', 'required_with:width,height,diameter'],
            'width'           => ['numeric', 'required_with:length,height,diameter'],
            'height'          => ['numeric', 'required_with:length,width,diameter'],
            'diameter'        => ['numeric', 'required_with:length,width,height'],
        ]);

        // cek error validator
        if ($validator->fails())
        {
            $errors = $validator->errors()->all();

            return response()->json([
                'code' => 400,
                'desc' => implode(', ', $errors)
            ], 200);
        }

        // kirim api
        $api = new ApiRajaongkir();
        $res = $api->localCostCheck($params);

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

        // return
        return response()->json([
            'code'   => 200,
            'result' => $res['rajaongkir']['results']
        ]);
    }

    //===========================================================================================

    public function internasional(Request $request)
    {

    }

    //===========================================================================================
}