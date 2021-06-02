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
		return response()->json(['data' => $data], $codeHTTP);
	}

	public function responseError($data, $codeHTTP = 422)
	{
		return response()->json(['data' => $data], $codeHTTP);
	}

}
