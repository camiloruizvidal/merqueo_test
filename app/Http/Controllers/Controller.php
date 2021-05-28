<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function response($data, $codeHTTP = 200)
	{
		$dataEncodeJson = $this->returnJson($data);
		return response()->json(['data' => $dataEncodeJson], $codeHTTP);
	}
	private function returnJson($string)
	{
		$valueJson = json_decode($string);
		$isJson = json_last_error() === JSON_ERROR_NONE;
		return $isJson ? $valueJson : $string;
	}
}
