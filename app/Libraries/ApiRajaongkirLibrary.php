<?php namespace App\Libraries;

/**
 * API Rajaongkir Libraries
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

use Illuminate\Support\Facades\Http;

class ApiRajaongkirLibrary
{
	protected $baseUrl;
	protected $options;
	protected $headers;

	//=================================================================================================

	public function __construct()
	{
		$this->baseUrl = env('RAJAONGKIR_URL');

		$this->options = [
			'verify' => FALSE
		];

		$this->headers = [
			'key' => env('RAJAONGKIR_KEY')
		];
	}

	//=================================================================================================

	public function cekResi(array $params = [])
	{
		$url    = "{$this->baseUrl}/waybill";
		$client = Http::withHeaders($this->headers)->withOptions($this->options);
		$res 	= $client->asForm()->post($url, $params);

		if (empty($res))
		{
			return $res;
		}

		return $res->body();
	}

	//=================================================================================================
}