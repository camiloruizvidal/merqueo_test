<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BillsCoinsController extends Controller
{
	public function validationTypes(Request $request)
	{

		$validation = Validator::make(
			$request->all(),
			[
				'tipo' => ['required', Rule::in(['billetes', 'monedas'])],
				'valor' =>
				[
					'required',
					Rule::in([
						100000,
						50000,
						20000,
						10000,
						5000,
						1000,
						500,
						200,
						100,
						50
					]),
				],
			],
			[
				'required' => 'El atributo ":attribute" es obligatorio.',
				'in'=>'El atributo ":attribute" = ":input" es invalido'
			]
		);

		$response = new \stdClass;
		$response->isValid = !$validation->fails();
		$response->errors = $validation->errors();

		if($validation->fails()) {
			throw new \Exception($validation->errors());
		}

		return $response;
	}
}
