<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KurirModel;

class HomeController extends Controller
{
    public function index()
    {
        $allKurir = KurirModel::getAllAvailable('cek_resi');
        dd($allKurir);
    }

    //=================================================================================================
}
